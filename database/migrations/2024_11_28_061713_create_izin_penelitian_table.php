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
        Schema::create('izin_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email');
            $table->string('sr_kesbangpol')->nullable(); // Untuk file upload
            $table->string('sip_kampus_lembaga')->nullable(); // Untuk file upload
            $table->string('output')->nullable(); // Untuk file upload
            $table->string('status')->nullable()->default('Diterima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_penelitian');
    }
};
