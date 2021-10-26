<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use WithFaker;

    public function test_login()
    {
        $response = $this->post(route('user_login'), [
            'email' => 'nismara@gmail.com',
            'password' => 'qwerty123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email_verified_at',
                'role'
            ]
        ]);
    }

    public function test_registrasi()
    {
        $response = $this->post(route('user_registrasi'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'password' => 'qwerty123',
            'password_confirmation' => 'qwerty123',
            'remember_token' => Str::random(10),
            'hp' => Str::random(8),
            'provinsi_id' => 32,
            'kota_id' => 3201,
            'kecamatan_id' => 3201050,
            'alamat' => Str::random(20),
            'role' => 'user'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'info'
        ]);
    }
}
