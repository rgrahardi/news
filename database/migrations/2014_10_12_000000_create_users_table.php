<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role', 50)->default('user');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        DB::table('users')->insert(
            [
                'id' => 1,
                'name' => 'Superadmin App',
                'email' => 'admin@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('qwerty123'),
                'role' => 'superadmin',
            ]
        );

        DB::table('users')->insert(
            [
                'id' => 2,
                'name' => 'Admin App',
                'email' => 'admin2@gmail.com',
                'email_verified_at' => null,
                'password' => Hash::make('qwerty123'),
                'role' => 'admin',
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
