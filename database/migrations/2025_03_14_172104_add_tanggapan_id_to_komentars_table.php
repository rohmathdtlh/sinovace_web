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
        Schema::table('komentar', function (Blueprint $table) {
            $table->unsignedBigInteger('tanggapan_id')->nullable()->after('id'); // Tambahkan kolom
            $table->foreign('tanggapan_id')->references('id')->on('tanggapans')->onDelete('cascade'); // Tambahkan foreign key
        });
    }
    
    public function down()
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->dropForeign(['tanggapan_id']); // Hapus foreign key
            $table->dropColumn('tanggapan_id'); // Hapus kolom
        });
    }
};
