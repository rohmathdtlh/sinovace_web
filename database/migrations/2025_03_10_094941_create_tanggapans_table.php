<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key)
            $table->foreignId('lapor_id')->constrained('lapor')->onDelete('cascade'); // Relasi ke tabel lapors
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->text('tanggapan'); // Kolom untuk menyimpan isi tanggapan
            $table->string('file_path')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapans'); // Menghapus tabel tanggapans jika migrasi di-rollback
    }
};