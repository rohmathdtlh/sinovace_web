<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>@yield('title') | SINOVACE</title>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (Jika belum ada) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <link rel="icon" href="data:,">

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
          <a href="{{ Auth::guard('user')->check() ? url('beranda') : url('') }}" class="d-flex align-items-center">
              <img src="{{ asset('/img/Logo-disdik.png') }}" alt="Logo Disdik Depok" class="img-fluid" style="max-width: 70px;">
              <!-- Text next to logo -->
              <div class="ms-2">
                  <h3 class="mb-0 text-white">DISDIK</h3>
                  <h4 class="mb-0 kota-depok text-white">Kota Depok</h4>
              </div>
          </a>
        </div>

        <div class="col-auto d-flex align-items-center">
            @guest('user')
                @if(!in_array(request()->route()->getName(), ['login', 'user.registration']))
                    <a href="{{ route('login') }}" class="btn btn-outline-warning me-2">Masuk</a>
                    <a href="{{ route('user.registration') }}" class="btn btn-outline-warning">Daftar</a>
                @endif
            @endguest

           <!-- ...existing code... -->
            @auth('user')
                @if(request()->routeIs('home2'))
                    <!-- Dropdown untuk Profil dan Logout -->
                    <div class="dropdown">
                        <button class="btn btn-outline-warning dropdown-toggle p-2" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-3"></i> <!-- Ikon Profil -->
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profil') }}">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-start">
                                        <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            @endauth
<!-- ...existing code... -->
        </div>
    </div>

    <!-- Main content section -->
    <div class="mt-5">
        @yield('content')
    </div>
</div>

<!-- Bootstrap JS & Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>