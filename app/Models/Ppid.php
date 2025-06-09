<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ppid extends Model
{
    use HasFactory;
    use Notifiable;
    // Menentukan nama tabel secara eksplisit
    protected $table = 'ppid';

    // Menentukan field yang bisa diisi secara mass assignment
    protected $fillable = [
        'jenis',
        'nama',
        'no_hp',
        'email', // Pastikan field email sudah ada di database
        'alamat',
        'file_upload',
        'output',
        'status',
    ];
}
