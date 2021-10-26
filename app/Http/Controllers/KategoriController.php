<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use File;
use Validator;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function status ($data, $ok = 200, $err = 404)
    {
        return !empty(is_array($data) ? count($data) : $data) ? $ok : $err;
    }

    // list kategori untuk admin dan publik
    public function index ()
    {
    	$data = Kategori::orderBy('nama', 'asc')->select('id', 'nama', 'slug', 'updated_at')->limit(5000)->get();

    	return response()->json([
    		'data' => $data
    	], $this->status($data, 200, 404));
    }

    // tampilkan kategori
    public function show ($slug)
    {
    	$data = Kategori::where('slug', $slug)->first();

    	return response()->json([
    		'data' => $data
    	], $this->status($data, 200, 404));	
    }

    // buat atau update kategori
    public function store (Request $request)
    {
    	$this->validate($request, [
            'nama' => 'required'
        ], [
            'nama.required' => 'Nama kategori harus diisi',
        ]);

        $slug = $request->slug ?? Str::slug($request->nama, '-');
        
        try {
            $kategori = Kategori::updateOrCreate(
                [
                'id' => $request->id
                ],
                [
                'nama' => $request->nama,
                'slug' => $slug
                ]);

            return response()->json([
                'info' => 'Kategori '.$request->nama.' telah dibuat'
            ]);

        } catch (Exception $e) {
            return response()->json('Kategori gagal disimpan', 422);
        }
    }

    // hapus data, softdeletes
    public function destroy ($id)
    {
        $data = Kategori::find($id);
        if ($data->delete()) {
            return response()->json([
            	'info' => 'Data telah dihapus'
            ], $this->status($data, 200, 422));
        }
    }
}
