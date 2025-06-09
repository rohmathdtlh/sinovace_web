<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IzinPenelitian extends Model
{
    use HasFactory;
    use Notifiable;
    // Menentukan nama tabel secara eksplisit
    protected $table = 'izin_penelitian';

    // Menentukan field yang bisa diisi secara mass assignment
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'sr_kesbangpol',
        'sip_kampus_lembaga',
        'output',
        'status',
    ];
}
