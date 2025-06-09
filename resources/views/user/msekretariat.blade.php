@extends('main-user')

@section('title', 'Beranda')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp


<div class="text-center text-white mt-5">
    <h1 class="display-4">SINOVACE</h1>
    <p class="lead">Sistem Inovasi Pelayanan Pendidikan Via Online Gratis dan Cepat</p>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Izin Penelitian -->
        <div class="col-md-6 mb-4 text-center">
            <a href="{{ route('user.izin_penelitian.create') }}" class="btn btn-custom w-100 py-3">
                <i class="bi bi-chat-left-text me-2"></i> Izin Penelitian
            </a>  
            {{-- @auth
                <!-- Menampilkan layanan jika sudah login -->
                <a href="{{ route('user.izin_penelitian.create') }}" class="btn btn-custom w-100 py-3">
                    <i class="bi bi-chat-left-text me-2"></i> Izin Penelitian
                </a>                
            @else
            <!-- Menampilkan tombol login jika belum login -->
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3">
                    <i class="bi bi-chat-left-text me-2"></i> Izin Penelitian
                </a>
            @endauth --}}
        </div>
        
        
        <div class="col-md-6 mb-4 text-center">
            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-arrows-move me-2"></i> Layanan Pengaduan Pendidikan </a>
            {{-- @auth
            <a href="{{ route('user.form_mutasi.create') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-arrows-move me-2"></i> Mutasi Siswa (Sisi)</a>
            @else
            <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-arrows-move me-2"></i> Mutasi Siswa (Sisi)</a>
            @endauth --}}
        </div>
        
        {{-- <!-- Layanan Pengaduan -->
        <div class="col-md-6 mb-4 text-center">
           @auth
               <!-- Menampilkan layanan jika sudah login -->
               <a href="{{ route('form-pengaduan') }}" class="btn btn-custom w-100 py-3">
                   <i class="bi bi-chat-left-text me-2"></i> Layanan Pengaduan (Ladu)
               </a>
           @else
               <!-- Menampilkan tombol login jika belum login -->
               <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3">
                   <i class="bi bi-chat-left-text me-2"></i> Layanan Pengaduan (Ladu)
               </a>
               @endauth
           </div>  --}}
           {{-- <div class="col-md-6 mb-4 text-center">
            <a href="{{ route('user.legalisir_piagam.create') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-award me-2"></i> Layanan Pengaduan</a>
            </div> --}}

           <div class="col-md-6 mb-4 text-center">
               <a href="{{ route('user.ppid.create') }}" class="btn btn-custom w-100 py-3">
                <i class="bi bi-info-circle me-2"></i> Permohonan Informasi (PPID)
            </a>  
               {{-- @auth
                   <a href="{{ route('user.form_legalisir_piagam.create') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-award me-2"></i> Legalisir Piagam Penghargaan</a>
               @else
                   <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-award me-2"></i> Legalisir Piagam Penghargaan</a>
               @endauth --}}
           </div>
           
        <!-- Baris pertama -->
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
            <a href="#" class="btn btn-custom w-100 py-3"><i class="bi bi-pencil-square me-2"></i> Izin Memimpin PAUD</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-pencil-square me-2"></i> Izin Memimpin PAUD</a>
            @endauth
        </div>
        <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="#" class="btn btn-custom w-100 py-3"><i class="bi bi-building me-2"></i> Izin Operasional PAUD</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-building me-2"></i> Izin Operasional PAUD</a>
            @endauth
        </div>
        <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="#" class="btn btn-custom w-100 py-3"><i class="bi bi-briefcase me-2"></i> Izin Operasional SMP</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-briefcase me-2"></i> Izin Operasional SMP</a>
            @endauth
        </div> --}}

        <!-- Baris kedua -->
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="{{ route('form-legalisir') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-file-earmark-text me-2"></i> Legalisir Fotokopi Ijazah/STTB (Lezat)</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-file-earmark-text me-2"></i> Legalisir Fotokopi Ijazah/STTB (Lezat)</a>
            @endauth
        </div> --}}

        <!-- Baris ketiga -->
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="{{ route('form-pelayanan-dapodik') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-bar-chart me-2"></i> Pelayanan Data Pokok Pendidikan (DAPODIK)</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-bar-chart me-2"></i> Pelayanan Data Pokok Pendidikan (DAPODIK)</a>
            @endauth
        </div> --}}
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="{{ route('form-bos') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-cash me-2"></i> Pengelolaan Bantuan Operasional Sekolah (BOS)</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-cash me-2"></i> Pengelolaan Bantuan Operasional Sekolah (BOS)</a>
            @endauth
        </div> --}}
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="{{ route('form-pengganti-ijazah') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-exclamation-triangle me-2"></i> Surat Keterangan Pengganti Ijazah/STTB yang Hilang (SUKIJAH)</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-exclamation-triangle me-2"></i> Surat Keterangan Pengganti Ijazah/STTB yang Hilang (SUKIJAH)</a>
            @endauth
        </div> --}}
        {{-- <div class="col-md-6 mb-4 text-center">
            @auth
                <a href="#" class="btn btn-custom w-100 py-3"><i class="bi bi-file-earmark-text me-2"></i> Surat Keterangan Ralat Ijazah/STTB</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-file-earmark-text me-2"></i> Surat Keterangan Ralat Ijazah/STTB</a>
            @endauth
        </div> --}}
    </div>
</div>

<!-- Style -->
<style>
    .btn-custom {
        background: linear-gradient(45deg, #f1c40f, #f39c12); /* Kuning dan oranye terang */
        border: none;
        color: white;
        font-size: 1.1rem;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 50px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-custom:hover {
        background: linear-gradient(45deg, #f39c12, #e67e22); /* Sedikit lebih gelap saat hover */
        transform: translateY(-2px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
    }

    .bi {
        font-size: 1.5rem;
    }

    /* Mengubah ukuran teks judul */
    h1.display-4 {
        font-size: 3rem;
        font-weight: bold;
    }

    /* Mengubah jarak antar elemen */
    .row > div {
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
@endsection
