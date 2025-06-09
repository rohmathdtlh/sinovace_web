<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubKategoriIdToLaporTable extends Migration
{
    public function up()
    {
        Schema::table('lapor', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_kategori_id')->nullable()->after('kategori_id');
            $table->foreign('sub_kategori_id')->references('id')->on('sub_kategori_pengaduan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('lapor', function (Blueprint $table) {
            $table->dropForeign(['sub_kategori_id']);
            $table->dropColumn('sub_kategori_id');
        });
    }
}