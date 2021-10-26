<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use File;
use Validator;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    // list pengaturan untuk admin dan publik
    public function index ()
    {
    	$data = DB::table('pengaturan')
                ->leftJoin('users', 'subweb.user_id', '=', 'users.id')
                ->orderBy('pengaturan.updated_at', 'desc')
                ->select('users.id as user_id', 'users.name', 'pengaturan.id as id', 'pengaturan.nama as pengaturan', 'pengaturan.output', 'pengaturan.nilai')
                ->limit(5000)->get();
    	return response()->json([
    		'data' => $data
    	]);
    }

    // tampilkan pengaturan
    public function show ($nama)
    {
    	$data = Pengaturan::where('nama', $nama)->where('status', 'terbit')->first();
    	return response()->json([
    		'data' => $pengaturan
    	]);	
    }

    // buat atau update subweb
    public function store (Request $request)
    {
    	$this->validate($request, [
            'nama' => 'required',
            'output' => 'required',
            'nilai' => 'required',
            'status' => 'required'
        ], [
            'nama.required' => 'Nama pengaturan harus diisi',
            'output.required' => 'Output pengaturan harus diunggah',
            'nilai.required' => 'Nilai pengaturan harus diisi',
            'status.required' => 'Status harus dipilih'
        ]);

        $slug = $request->slug ?? Str::slug($request->nama, '-');
        $pengaturan = Pengaturan::updateOrCreate(
          [
            'id' => $request->id
          ],
          [
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'output' => $request->output,
            'nilai' => $request->nilai,
            'status' => $request->status
          ]);

        if ($pengaturan) {
        	return response()->json([
        		'info' => 'Pengaturan '.$request->nama.' telah '.$request->status
        	]);
        }
    }

    // hapus data, softdeletes
    public function destroy ($id)
    {
        $data = Pengaturan::find($id);
        if ($data->delete()) {
            return response()->json([
            	'info' => 'Data telah dihapus'
            ]);
        }
    }
}
