<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $fillable = ['lapor_id', 'user_id', 'tanggapan','file_path',];

    // Relasi ke Lapor
    public function lapor()
    {
        return $this->belongsTo(Lapor::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'tanggapan_id');
    }
}