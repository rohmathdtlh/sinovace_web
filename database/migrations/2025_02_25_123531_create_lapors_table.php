<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_pengaduan')->onDelete('set null'); // Foreign key kategori_id
            $table->string('judul');
            $table->string('lokasi_kejadian');
            $table->date('tanggal_kejadian');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->text('balasan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lapor');
    }
};
