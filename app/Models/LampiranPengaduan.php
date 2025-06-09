<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranPengaduan extends Model
{
    use HasFactory;

    protected $table = 'lampiran_pengaduan'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'lapor_id',
        'file_path',
    ];
}
