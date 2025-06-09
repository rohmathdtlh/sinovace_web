<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('komentar', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lapor_id'); // ID pengaduan
        $table->unsignedBigInteger('user_id'); // ID user/admin yang mengirim komentar
        $table->text('komentar'); // Isi komentar
        $table->string('file_path')->nullable(); // Lampiran (opsional)
        $table->timestamps();

        // Foreign key ke tabel lapor
        $table->foreign('lapor_id')->references('id')->on('lapor')->onDelete('cascade');
        // Foreign key ke tabel users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};
