<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;
    use Notifiable;
    // Menentukan nama tabel secara eksplisit
    protected $table = 'admin';

    // Menentukan field yang bisa diisi secara mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
