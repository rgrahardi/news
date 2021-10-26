<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengaturan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('output');
            $table->longText('nilai');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('pengaturan')->insert(
            [
                'id' => 1,
                'user_id' => 1,
                'nama' => 'nama aplikasi',
                'output' => 'text',
                'nilai' => 'Aplikasi Starter Kit Bitcode',
                'status' => 'aktif'
            ]
        );

        DB::table('pengaturan')->insert(
            [
                'id' => 2,
                'user_id' => 1,
                'nama' => 'intro',
                'output' => 'text',
                'nilai' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu pretium leo. Phasellus viverra consectetur lorem quis efficitur. In non volutpat metus. Donec consequat aliquam lobortis. Duis orci nisi, elementum a feugiat non, convallis non quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce in ligula id turpis sagittis vehicula. Maecenas efficitur sollicitudin mauris, facilisis iaculis Interdum et malesuada.</p>',
                'status' => 'aktif'
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
        Schema::dropIfExists('pengaturan');
    }
}
