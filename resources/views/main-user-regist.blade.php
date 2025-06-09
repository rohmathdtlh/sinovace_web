<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | SINOVACE</title>

    @vite(['resources/js/app.js']) <!-- Laravel Vite -->

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Qwitcher Grypen Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher+Grypen:wght@400;700&display=swap');

        .kota-depok {
            font-family: 'Qwitcher Grypen', cursive;
        }
    </style>
</head>
<body class="min-vh-100 d-flex flex-column" style="
background-image: url('{{ asset('img/bg-image.png') }}'); 
background-size: cover; 
background-repeat: no-repeat;
background-attachment: fixed;
background-position: center;
">
@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="container">
    <!-- Header Section -->
    <div class="row align-items-center mt-4 d-flex justify-content-between">
        <div class="col-auto d-flex align-items-center">
          <!-- Logo -->
          <a href="{{ url('') }}" class="d-flex align-items-center">
              <img src="{{ asset('/img/Logo-disdik.png') }}" alt="Logo Disdik Depok" class="img-fluid" style="max-width: 70px;">
              <!-- Text next to logo -->
              <div class="ms-2">
                  <h3 class="mb-0 text-white">DISDIK</h3>
                  <h4 class="mb-0 kota-depok text-white">Kota Depok</h4>
              </div>
          </a>
        </div>

        <div class="col-auto d-flex align-items-center">
        
            @guest('user') <!-- Tampilkan jika user belum login -->
                <a href="{{ route('login') }}" class="btn btn-outline-warning me-2">Masuk</a>
                <a href="{{ route('user.registration') }}" class="btn btn-outline-warning">Daftar</a>
            @endguest

            @auth('user') <!-- Tampilkan jika user sudah login -->
                <div class="dropdown">
                    <button class="btn btn-outline-warning dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profil') }}">
                                <i class="bi bi-person me-2"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i>Log Out
                            </a>
                        </li>
                    </ul>
                </div>
            @endauth
        
        
        </div>
    </div>

    <!-- Main content section -->
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
            </div>
    
    
            <div class="col-md-6 mb-4 text-center">
                <a href="{{ route('user.mutasi_siswa.create') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-arrows-move me-2"></i> Mutasi Siswa (Sisi)</a>
            </div>
    
            <!-- Baris kedua -->
            <div class="col-md-6 mb-4 text-center">
                <a href="{{ route('user.legalisir_piagam.create') }}" class="btn btn-custom w-100 py-3"><i class="bi bi-award me-2"></i> Legalisir Piagam Penghargaan</a>
            </div>
        </div>
    </div>
</div>

<!-- Optional Bootstrap JS -->
<!-- Optional Bootstrap JS --><!-- Optional Bootstrap JS -->
</body>
</html>
