<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengaduan'; // ← Ini yang penting!

    protected $fillable = ['nama_kategori'];

    // Relasi ke sub kategori
    public function subKategori()
    {
        return $this->hasMany(SubKategoriPengaduan::class, 'kategori_id', 'id');
    }

    // Relasi ke model Lapor
    public function lapor()
    {
        return $this->hasMany(Lapor::class, 'kategori_id');
    }

    public function lapors()
    {
        return $this->hasMany(Lapor::class, 'kategori_id');
    }
}
