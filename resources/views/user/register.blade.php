@extends('main-user')

@section('title', 'Register - Disdik Depok')

@section('content')
<!-- Menampilkan Pesan Sukses -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Menampilkan Pesan Kesalahan -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid vh-100 d-flex justify-content-center align-items-center mb-5">
    <div class="row w-100 m-0 justify-content-center">
        <!-- Bagian Form Kiri -->
        <div class="col-12 col-md-8 col-lg-5 d-flex justify-content-center align-items-center p-0 mb-4 mb-lg-0">
            <div class="bg-white p-5 shadow" style="backdrop-filter: blur(10px); opacity: 0.9; width: 100%; border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                <h3 class="text-center">Daftar</h3>
                {{-- <form action="{{ route('user.register.post') }}" method="POST"> --}}
                <form >
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: #0C356A">Daftar</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>

        <!-- Bagian Gambar Kanan -->
        <div class="col-12 col-md-8 col-lg-5 d-none d-md-flex justify-content-center align-items-center p-0" style="background-color: #009ADE; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
            <img src="img/MERDEKA 1.png" alt="Gambar" class="img-fluid" style="width: 100%; height: auto;">
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f0f0f0;
    }

    .bg-white {
        border: 2px solid white;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    @media (max-width: 768px) {
        .bg-white {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .col-md-8, .col-lg-5 {
            max-width: 90%;
        }
    }
</style>
@endsection
