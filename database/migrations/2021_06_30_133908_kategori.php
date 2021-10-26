<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('kategori')->insert(
            [
                'id' => 1,
                'nama' => 'Berita',
                'slug' => 'berita'
            ]
        );

        DB::table('kategori')->insert(
            [
                'id' => 2,
                'nama' => 'Sejarah',
                'slug' => 'sejarah'
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
        Schema::dropIfExists('kategori');
    }
}
