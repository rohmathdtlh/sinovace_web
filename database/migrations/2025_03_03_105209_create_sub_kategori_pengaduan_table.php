<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sub_kategori_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id'); // Relasi ke kategori
            $table->string('nama_sub_kategori');
            $table->timestamps();

            // Foreign key ke kategori_pengaduan
            $table->foreign('kategori_id')->references('id')->on('kategori_pengaduan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_kategori_pengaduan');
    }
};
