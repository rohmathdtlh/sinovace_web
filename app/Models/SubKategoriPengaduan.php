<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'sub_kategori_pengaduan';

    protected $fillable = ['kategori_id', 'nama_sub_kategori'];

    // Relasi ke kategori pengaduan
    public function kategori()
{
    return $this->belongsTo(KategoriPengaduan::class, 'kategori_id', 'id');
}
public function lapors()
{
    return $this->hasMany(Lapor::class, 'kategori_id');
}
}