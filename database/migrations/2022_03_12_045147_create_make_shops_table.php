<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('make_shops', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nm_pu');
            $table->string('nm_usaha');
            $table->string('alamat');
            $table->bigInteger('nik');
            $table->string('img_ktp');
            $table->string('img_siu');
            $table->string('pas_foto');
            $table->string('foto_usaha')->nullable();
            $table->string('status')->default('review');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('make_shops');
    }
};
