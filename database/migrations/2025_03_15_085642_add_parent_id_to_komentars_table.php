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
        $table->unsignedBigInteger('parent_id')->nullable()->after('id'); // Kolom parent_id boleh NULL
        $table->foreign('parent_id')->references('id')->on('komentar')->onDelete('cascade'); // Foreign key ke tabel komentars
    });
}

public function down()
{
    Schema::table('komentar', function (Blueprint $table) {
        $table->dropForeign(['parent_id']); // Hapus foreign key
        $table->dropColumn('parent_id'); // Hapus kolom
    });
}
};
