<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;
use App\Models\SubKategoriPengaduan;

class KategoriSubKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriSubKategori = [
            'Laporan Terkait Sarana dan Prasarana Pendidikan' => [
                'Pengaduan fasilitas sekolah rusak (gedung, meja, kursi, toilet, dll.)',
                'Kurangnya sarana pendidikan (buku, komputer, laboratorium, dll.)',
                'Masalah jaringan internet sekolah',
                'Pengadaan barang yang tidak sesuai',
            ],
            'Laporan Terkait Pembinaan Sekolah Dasar & Menengah Pertama' => [
                'Kurikulum dan metode pembelajaran yang kurang efektif',
                'Kualitas pengajaran guru',
                'Kesalahan dalam penilaian akademik',
                'Kesulitan dalam pendaftaran dan administrasi siswa',
            ],
            'Laporan Terkait Pembinaan Pendidikan Anak Usia Dini (PAUD) dan Pendidikan Masyarakat' => [
                'Kualitas pendidikan PAUD tidak memadai',
                'Program pendidikan masyarakat tidak berjalan dengan baik',
                'Kurangnya tenaga pengajar atau fasilitas untuk PAUD',
            ],
            'Laporan Terkait Kepegawaian dan Kinerja Guru/Pegawai' => [
                'Pelanggaran disiplin pegawai/guru',
                'Penundaan pencairan tunjangan atau gaji',
                'Masalah kenaikan pangkat atau mutasi pegawai',
            ],
            'Laporan Terkait Perencanaan dan Evaluasi Pendidikan' => [
                'Kesalahan dalam data pendidikan',
                'Ketidaksesuaian pelaporan evaluasi sekolah',
                'Pengawasan pendidikan yang kurang optimal',
            ],
            'Laporan Keuangan dan Aset Sekolah' => [
                'Dugaan penyalahgunaan dana BOS atau dana pendidikan lainnya',
                'Kesalahan dalam pengelolaan aset sekolah',
                'Keterlambatan pencairan dana bantuan pendidikan',
            ],
            'Laporan Terkait Unit Pelaksana Teknis Daerah (UPTD)' => [
                'Masalah layanan pendidikan di tingkat daerah',
                'Kurangnya koordinasi antara UPTD dan sekolah',
                'Masalah dalam pengelolaan administrasi pendidikan',
            ],
        ];

        foreach ($kategoriSubKategori as $kategori => $subKategoris) {
            $kategoriModel = KategoriPengaduan::create([
                'nama_kategori' => $kategori,
            ]);

            foreach ($subKategoris as $subKategori) {
                SubKategoriPengaduan::create([
                    'kategori_id' => $kategoriModel->id,
                    'nama_sub_kategori' => $subKategori,
                ]);
            }
        }
    }
}
