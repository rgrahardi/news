<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Kategori;

class KategoriTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;

    public function test_store ()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->post(route('admin_kategori_store'), [
            'nama' => Str::random(8)
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'info'
        ]);
    }

    public function test_show ()
    {
        $user = User::find(1);
        $kategori = Kategori::orderBy('id', 'desc')->first();
        $response = $this->actingAs($user)->get('/admin/kategori/show/'.$kategori->slug);

        $response->assertStatus(200);
    }

    public function test_destroy ()
    {
        $user = User::find(1);
        $kategori = Kategori::orderBy('id', 'asc')->first();

        $response = $this->actingAs($user)->post('/admin/kategori/destroy/'.$kategori->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'info'
        ]);
    }
}
