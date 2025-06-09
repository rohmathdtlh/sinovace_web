<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    protected $fillable = [
        'lapor_id', 'user_id', 'komentar', 'file_path','parent_id',
    ];

    // Relasi ke tabel lapor
    public function lapor()
    {
        return $this->belongsTo(Lapor::class, 'lapor_id');
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tanggapan()
    {
        return $this->belongsTo(Tanggapan::class, 'tanggapan_id');
    }

    // Relasi ke Komentar Induk (Parent)
    public function parent()
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    // Relasi ke Komentar Anak (Replies)
    public function replies()
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }
}