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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama admin
            $table->string('email')->unique(); // Email admin, unik
            $table->timestamp('email_verified_at')->nullable(); // Verifikasi email (opsional)
            $table->string('password'); // Password
            $table->string('role')->default('admin'); // Kolom role, default admin
            $table->rememberToken(); // Token untuk "remember me"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
