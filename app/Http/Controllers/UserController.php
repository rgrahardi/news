<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
	// list data user oleh admin
    public function index ()
    {
    	$data = User::orderBy('updated_at', 'desc')->limit(5000)->get();
        
    	return response()->json([
    		'data' => $data
    	]);
    }

    // tampilkan data profil oleh admin/user sendiri
    public function show ($id = null)
    {
    	if (auth()->user()->role == 'superadmin' || 'admin') {
    		$data = User::find($id);
    	} else {
    		$data = User::where('id', auth()->user()->id)->first();
    	}

    	return response()->json([
    		'data' => $data
    	]);
    }

    // registrasi, buat atau update akun
    public function store (Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'hp' => 'required|string|max:15',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan_id' => 'required',
            'alamat' => 'required|string|max:200'
        ], [
            'name.required' => 'Nama harus diisi',
            'name.regex' => 'Format nama hanya huruf, tidak boleh simbol, angka atau karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak benar',
            'password.required' => 'Password harus diisi minimal 6 karakter',
            'hp.required' => 'Nomor hp harus diisi',
            'provinsi_id.required' => 'Provinsi harus diisi',
            'kota_id.required' => 'Kota harus diisi',
            'kecamatan_id.required' => 'Kecamatan harus diisi',
            'alamat.required' => 'Alamat harus diisi'
        ]);

    	$role = $request->role ? $request->role : 'user';

        $user = User::updateOrCreate(
          [
                'id' => $request->id
          ],
          [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'hp' => $request->hp,
                'provinsi_id' => $request->provinsi_id,
                'kota_id' => $request->kota_id,
                'kecamatan_id' => $request->kecamatan_id,
                'alamat' => $request->alamat,
                'role' => $role
          ]
        );

        if ($user) {
          event(new Registered($user));
          return response()->json([
              'info' => 'Pendaftaran akun atas nama '.$request->name.' email '.$request->email.' berhasil'
          ], 200);
        }
    }

    // login manual untuk custom response, belum ketemu cara custom response fortify
    public function login (Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak benar',
            'password.required' => 'Password minimal 6 karakter',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($login)) {
            return response()->json([
                'user' => DB::table('users')
                            ->where('id', auth()->user()->id)
                            ->select('id', 'name', 'email_verified_at', 'role')
                            ->first(),
                'status' => 'sukses login'
            ], 200);
        } else {
            return response()->json([
                'errors' => [
                    'login' => 'Email atau password salah',
                    'email' => null,
                    'password' => null
                ]
            ], 403);
        }
    }

    public function forget_password (Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json('berhasil '.$status)
                    : response()->json('gagal '.$status);
    }

    public function reset_password (Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? response()->json('berhasil '.$status)
                    : response()->json('gagal '.$status);
    }

    // cek stats user jika nuxt hot reload
    public function status ()
    {
        $id = auth()->user() ? auth()->user()->id : null;
        $user = DB::table('users')
                ->where('id', $id)
                ->select('id', 'name', 'email_verified_at', 'role')
                ->first();

        return response ([
            'user' => $user
        ]);
    }

    public function export_excel ()
    {
        return Excel::download(new UserExport, 'export_user.xlsx');
    }

    // hapus data, softdeletes
    public function destroy ($id)
    {
        $data = User::find($id);
        if ($data->delete()) {
            return response()->json([
            	'info' => 'Data telah dihapus'
            ]);
        }
    }
}
