<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapor extends Model
{
    use HasFactory;

    protected $table = 'lapor';
    
    protected $fillable = [
        'user_id',
        'kategori_id', 
        'sub_kategori_id',
        'judul',
        'lokasi_kejadian',
        'tanggal_kejadian',
        'deskripsi',
        'status',
        'waktu_respon',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori (jika diperlukan)
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriPengaduan::class, 'sub_kategori_id');
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }
    public function lampiranPengaduan()
    {
        return $this->hasMany(LampiranPengaduan::class, 'lapor_id', 'id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'lapor_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'lapor_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'lapor_id');
    }
}
