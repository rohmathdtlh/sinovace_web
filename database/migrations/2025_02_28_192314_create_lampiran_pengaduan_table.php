<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lampiran_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapor_id')->constrained('lapor')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lampiran_pengaduan');
    }
};
