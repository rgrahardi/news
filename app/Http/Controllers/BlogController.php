<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use File;
use Validator;
use Exception;
use App\Models\Blog;

class BlogController extends Controller
{
    public function status ($data, $ok = 200, $err = 404)
    {
        return !empty(is_array($data) ? count($data) : $data) ? $ok : $err;
    }

    // list blog untuk admin dan publik
    public function index ()
    {
        if (auth()->user()->role == 'superadmin' || 'admin') {
            $data = DB::table('blog')
                    ->leftJoin('users', 'blog.user_id', '=', 'users.id')
                    ->leftJoin('kategori', 'blog.kategori_id', '=', 'kategori.id')
                    ->where('blog.user_id', auth()->user()->id)
                    ->whereNull('blog.deleted_at')
                    ->orderBy('blog.updated_at', 'desc')
                    ->select('users.name', 'kategori.nama as kategori', 'blog.id', 'blog.tanggal', 'blog.judul', 'blog.slug', 'blog.meta', 'blog.status', 'blog.featured')
                    ->limit(5000)->get();
        } else {
            $data = DB::table('blog')
                    ->leftJoin('users', 'blog.user_id', '=', 'users.id')
                    ->leftJoin('kategori', 'blog.kategori_id', '=', 'kategori.id')
                    ->whereNull('blog.deleted_at')
                    ->orderBy('blog.updated_at', 'desc')
                    ->select('users.name', 'kategori.nama as kategori', 'blog.id', 'blog.tanggal', 'blog.judul', 'blog.slug', 'blog.meta', 'blog.status', 'blog.featured')
                    ->limit(5000)->get();
        }

    	return response()->json([
    		'data' => $data
    	], $this->status($data, 200, 404));
    }

    // tampilkan blog
    public function show ($slug)
    {
    	$data = Blog::with('user', 'kategori')->where('slug', $slug)->first();

        return response()->json([
    		'data' => $data
    	], $this->status($data, 200, 404));	
    }

    // arsip blog berdasarkan kategori
    public function arsip ($kategori)
    {
    	$data = DB::table('blog')
                ->leftJoin('users', 'blog.user_id', '=', 'users.id')
                ->leftJoin('kategori', 'blog.kategori_id', '=', 'kategori.id')
                ->orderBy('blog.updated_at', 'desc')
                ->where('kategori.slug', $kategori)
                ->whereNull('blog.deleted_at')
                ->where('blog.status', 'terbit')
                ->select('users.name', 'kategori.nama as kategori', 'blog.id', 'blog.tanggal', 'blog.judul', 'blog.slug', 'blog.meta', 'blog.status', 'blog.featured')
                ->limit(5000)->get();

    	return response()->json([
    		'data' => $data
    	], $this->status($data, 200, 404));
    }

    // buat atau update blog
    public function store (Request $request)
    {   
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'tanggal' => 'required',
                'judul' => 'required|string|max:250',
                'meta' => 'required|string|max:250',
                'kategori_id' => 'required',
                'konten' => 'required|string',
                'status' => 'required'
            ], [
                'tanggal.required' => 'Tanggal harus diisi',
                'judul.required' => 'Judul harus diisi',
                'judul.max' => 'Judul maksimal 250 karakter',
                'meta.required' => 'Meta harus diisi',
                'meta.max' => 'Meta maksimal 250 karakter',
                'kategori_id.required' => 'kategori harus dipilih',
                'konten.required' => 'Konten harus diisi',
                'status.required' => 'Status harus dipilih'
            ]);

            $slug = $request->slug ?? Str::slug($request->judul, '-');
            $user_id = $request->user_id ? $request->user_id : auth()->user()->id;

            $blog = Blog::updateOrCreate(
              [
                'id' => $request->id
              ],
              [
                'user_id' => $user_id,
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'slug' => $slug,
                'meta' => $request->meta,
                'tag' => $request->tag,
                'kategori_id' => $request->kategori_id,
                'featured' => $request->featured,
                'konten' => $request->konten,
                'status' => $request->status
              ]);

            DB::commit();
            return response()->json([
                'info' => 'Konten '.$request->judul.' telah '.$request->status
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json('Gagal membuat blog', 422);
        }
    	
    }

    // upload file, simpan ke sub direktori laravel file manager
    public function upload(Request $request)
    {
        $blacklist = ['php', 'sh', 'bin', 'exe'];
        $file = $request->upload ? $request->upload : $request->file;
        $file_ori_name = $file->getClientOriginalName();
        $file_path = realpath($file);
        $file_name = explode('.',$file_ori_name)[0];
        $file_extension = $file->getClientOriginalExtension();
        $file_slug = Str::slug($file_name, '_').".".$file_extension;

        $name = auth()->user()->name;
        $name_slug = Str::slug($name, '_');
        $role = auth()->user()->role;
        $path = '';
        $role == "superadmin" ? $path =  'storage/files/superadmin' : $path =  'storage/files/superadmin/'.$name_slug;

        try {
            if (!in_array($file_extension, $blacklist)) {
                $file->move($path, $file_slug);
                $url = $path.'/'.$file_slug;
                return response()->json($url, 200);
            } else {
                throw new Exception('Jenis file tidak diizinkan', 1);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 422);
        }

    }

    // hapus data, softdeletes
    public function destroy ($id)
    {
        $data = Blog::find($id);
        if ($data->delete()) {
            return response()->json([
                'info' => 'Data telah dihapus'
            ], $this->status($data, 200, 422));
        }
    }
}
