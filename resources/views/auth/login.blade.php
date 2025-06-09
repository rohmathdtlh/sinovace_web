@extends('main-user')

@section('title', 'Login')

@section('content')
<div class="container-fluid vh-100 d-flex justify-content-center align-items-center mb-0">
    <div class="row w-100 m-0 justify-content-center"> <!-- Centered row -->
        <!-- Bagian Form Kiri -->
        <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center p-0 mb-lg-0">
            <div class="bg-white p-4 shadow" style="backdrop-filter: blur(10px); opacity: 0.9; width: 100%; border-top-left-radius: 10px; border-bottom-left-radius: 10px; max-width: 100%;">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <h4 class="mb-2 d-flex justify-content-center align-items-center">Selamat Datang! 👋</h4>
                    <p class="mb-3">Silahkan masukkan email dan password Anda</p>
                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Masukkan email" required/>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group input-group-merge">
                            <input
                            type="password"
                            id="password"
                            class="form-control mt-1"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password"
                            />
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="captcha">Captcha</label><br>
                        {!! captcha_img() !!}
                        <input type="text" name="captcha" id="captcha" class="form-control mt-1" required>
                        @error('captcha')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <!-- Submit Button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary" style="background-color: #0C356A">Masuk</button>
                    </div>
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="{{ route('user.registration') }}">Buat Akun</a></p>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    {{-- <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p> --}}
                </div>
            </div>
        </div>

        <!-- Bagian Gambar Kanan -->
        <div class="col-12 col-lg-5 d-none d-lg-flex justify-content-center align-items-center p-0" style="background-color: #009ADE; border-top-right-radius: 10px; border-bottom-right-radius: 10px; max-width: 100%;">
            <img src="img/MERDEKA 1.png" alt="Gambar" class="img-fluid" style="width: 100%; height: auto; object-fit: cover; border-radius: 0 10px 10px 0;">
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
        max-width: 100%;
    }

    @media (max-width: 768px) {
        .bg-white {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .col-lg-5 {
            max-width: 90%;
        }
    }
</style>
{{-- <script>
    document.getElementById('refresh-captcha').addEventListener('click', function() {
        fetch('{{ route("refresh.captcha") }}?preset=flat')
            .then(response => response.json())
            .then(data => {
                document.getElementById('captcha-img').innerHTML = data.captcha;
            });
    });
</script> --}}

@endsection
