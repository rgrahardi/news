<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Blog;

class BlogTest extends TestCase
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

        $response = $this->actingAs($user)->post(route('admin_blog_store'), [
            'user_id' => 1,
            'tanggal' => date('Y-m-d H:i:s'),
            'judul' => $this->faker->sentence(5),
            'meta' => $this->faker->sentence(3),
            'tag' => $this->faker->words(5, true),
            'kategori_id' => 1,
            'featured' => $this->faker->imageUrl(640, 480, 'animals', true),
            'konten' => $this->faker->randomHtml(),
            'status' => 'terbit'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'info'
        ]);
    }

    public function test_show ()
    {
        $blog = DB::table('blog')->orderBy('id', 'desc')->first();
        $response = $this->get('/landing/blog/'.$blog->slug);

        $response->assertStatus(200);
    }

    public function test_destroy ()
    {
        $user = User::find(1);
        $blog = Blog::orderBy('id', 'asc')->first();

        $response = $this->actingAs($user)->post('/admin/blog/destroy/'.$blog->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'info'
        ]);
    }
}
