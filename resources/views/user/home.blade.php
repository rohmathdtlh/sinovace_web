<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Disdik Depok</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher+Grypen:wght@400;700&display=swap');

        .kota-depok {
            font-family: 'Qwitcher Grypen', cursive;
        }
    </style>
</head>
<body class="min-vh-100 d-flex flex-column" style="
    background-image: url('img/bg-image.png'); 
    background-size: cover; 
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    ">

    <div class="container mt-4 flex-grow-1">
        <!-- Membungkus logo, teks, dan tombol dalam div flexbox -->
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Logo Disdik -->
                <img src="img/Logo-disdik.png" alt="Logo Disdik Depok" class="img-fluid" style="width: 50px; height: auto;">
                <!-- Teks Disdik dan Kota Depok -->
                <div class="ms-3">
                    <h3 class="mb-0 text-white">DISDIK</h3>
                    <h4 class="mb-0 kota-depok text-white">Kota Depok</h4>
                </div>
            </div>
            <!-- Tombol Masuk dan Daftar atau Logout -->
            <div>
                @guest
                    <!-- Jika pengguna belum login, tampilkan tombol Masuk dan Daftar -->
                    <a href="{{ route('login') }}" class="btn btn-outline-warning">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-warning ms-3">Daftar</a>
                @endguest

                @auth
                    <!-- Jika pengguna sudah login, tampilkan tombol Logout -->
                    <span class="me-3 text-white">Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning">Logout</button>
                    </form>
                @endauth
            </div>
        </div>

        <!-- Judul dan Deskripsi Sistem -->
        <div class="text-center text-white mt-5">
            <h1>SINOVACE</h1>
            <p>Sistem Inovasi Pelayanan Pendidikan Via Online Gratis dan Cepat</p>
        </div>

        <!-- Kartu Layanan -->
        <div class="row mt-5 g-4">
            <!-- Kartu SD -->
            <div class="col-12 col-md-4">
                <div class="card h-100 bg-warning text-dark position-relative">
                    @guest
                        <a href="{{ route('login') }}" class="text-dark ms-auto"
                           onclick="return confirm('Silakan login terlebih dahulu untuk melanjutkan.');">
                           <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @else
                        <a href="#" class="text-dark ms-auto">
                            <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @endguest
                    <div class="card-body d-flex justify-content-between align-items-center position-relative">
                        <div>
                            <h2 class="card-title mb-1">SD</h2>
                            <p class="card-text">Sekolah Dasar</p>
                        </div>
                        <img src="img/Logo_SD.png" alt="Logo SD" style="width: 20%;" class="img-fluid">
                    </div>
                </div>
            </div>
            <!-- Kartu SMP -->
            <div class="col-12 col-md-4">
                <div class="card h-100 bg-warning text-dark position-relative">
                    @guest
                        <a href="{{ route('login') }}" class="text-dark ms-auto"
                           onclick="return confirm('Silakan login terlebih dahulu untuk melanjutkan.');">
                           <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @else
                        <a href="#" class="text-dark ms-auto">
                            <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @endguest
                    <div class="card-body d-flex justify-content-between align-items-center position-relative">
                        <div>
                            <h2 class="card-title mb-1">SMP</h2>
                            <p class="card-text">Sekolah Menengah Pertama</p>
                        </div>
                        <img src="img/Logo SMP.png" alt="Logo SMP" style="width: 20%;" class="img-fluid">
                    </div>
                </div>
            </div>
            <!-- Kartu SEKRETARIAT -->
            <div class="col-12 col-md-4">
                <div class="card h-100 bg-warning text-dark position-relative">
                    @guest
                        <a href="{{ route('login') }}" class="text-dark ms-auto"
                           onclick="return confirm('Silakan login terlebih dahulu untuk melanjutkan.');">
                           <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @else
                        <a href="{{ route('msekretariat') }}" class="text-dark ms-auto">
                            <i class="bi bi-arrow-right-short text-end p-2 fs-1 fw-bold text-dark"></i>
                        </a>
                    @endguest
                    <div class="card-body d-flex justify-content-between align-items-center position-relative">
                        <div>
                            <h2 class="card-title mb-1">SEKRETARIAT</h2>
                            <p class="card-text">Administrasi Disdik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
