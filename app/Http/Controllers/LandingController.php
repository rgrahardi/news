<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use File;
use Validator;
use App\Models\Blog;
use App\Models\Pengaturan;

class LandingController extends Controller
{
    // ambil data provinsi, kota dan kecamatan untuk pendaftaran
    public function provinsi ()
    {
        $data = DB::table('provinces')->select('id', 'name')->get();

        return response()->json([
                'data' => $data
        ]);
    }

    public function kota ($provinsi_id)
    {
        $data = DB::table('regencies')->where('province_id', $provinsi_id)->select('id', 'name')->orderBy('name', 'asc')->get();

        return response()->json([
                'data' => $data
        ]);
    }

    public function kecamatan ($kota_id)
    {
        $data = DB::table('districts')->where('regency_id', $kota_id)->select('id', 'name')->orderBy('name', 'asc')->get();

        return response()->json([
                'data' => $data
        ]);
    }

    // landing page (halaman induk)
    public function index ()
    {
        $nama_aplikasi = DB::table('pengaturan')->where([['nama', 'nama aplikasi'],['status', 'aktif']])->select('id', 'nama', 'nilai')->first();
        $intro = DB::table('pengaturan')->where([['nama', 'intro'],['status', 'aktif']])->select('id', 'nama', 'nilai')->first();
        $blog  = DB::table('blog')
                ->join('users', 'blog.user_id', 'users.id')
                ->join('kategori', 'blog.kategori_id', 'kategori.id')
                ->select('kategori.nama as kategori', 'users.name as user', 'blog.id', 'blog.judul', 'blog.slug', 'blog.tanggal', 'blog.meta')->get();

        return response()->json([
            'nama_aplikasi' => $nama_aplikasi,
            'intro' => $intro,  
            'blog' => $blog
        ]);
    }
}
