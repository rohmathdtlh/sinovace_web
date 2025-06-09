@extends('main-admin')

@section('title', 'Tambah Admin Baru')

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Admin Baru</h5>
            <a href="{{ route('admin.akun_admin') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar Admin
            </a>
          </div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Terdapat masalah dengan input Anda:
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form id="formTambahAdmin" action="{{ route('admin.registration.post') }}" method="POST">
              @csrf

              <div class="row mb-3">
                <div class="col-md-6 mb-3">
                  <label for="kategori_id" class="form-label">Kategori Tugas <span class="text-danger">*</span></label>
                  <select name="kategori_id" id="kategori_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoriList as $kategori)
                      <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                  </select>
                </div>
              </div>


              <div class="row mb-3">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email valid" required>
                </div>
              </div>
              
              <div class="row mb-3">
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                      <i class="bx bx-hide"></i>
                    </button>
                  </div>
                  <div class="form-text">Gunakan kombinasi huruf, angka, dan simbol</div>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                      <i class="bx bx-hide"></i>
                    </button>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-user-plus me-1"></i> Tambah Admin
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Password Strength Meter -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="passwordStrengthToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Kekuatan Password</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <div class="progress mb-2" style="height: 5px">
        <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
      </div>
      <small id="passwordStrengthText">Password belum dimasukkan</small>
    </div>
  </div>
</div>

<style>
  .toggle-password:hover {
    background-color: #f1f1f1;
  }
  .progress-bar {
    transition: width 0.3s ease;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
      button.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const icon = this.querySelector('i');
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.replace('bx-hide', 'bx-show');
        } else {
          input.type = 'password';
          icon.classList.replace('bx-show', 'bx-hide');
        }
      });
    });

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');
    const strengthToast = new bootstrap.Toast(document.getElementById('passwordStrengthToast'));

    passwordInput.addEventListener('focus', function() {
      strengthToast.show();
    });

    passwordInput.addEventListener('blur', function() {
      setTimeout(() => strengthToast.hide(), 1000);
    });

    passwordInput.addEventListener('input', function() {
      const password = this.value;
      let strength = 0;
      
      if (password.length >= 8) strength += 25;
      if (password.length >= 12) strength += 15;
      if (/[A-Z]/.test(password)) strength += 15;
      if (/[0-9]/.test(password)) strength += 15;
      if (/[^A-Za-z0-9]/.test(password)) strength += 15;
      if (!/(password|123456|admin)/i.test(password)) strength += 15;
      
      strength = Math.min(100, strength);
      strengthBar.style.width = `${strength}%`;
      
      if (strength < 40) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthText.textContent = 'Lemah';
      } else if (strength < 70) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthText.textContent = 'Sedang';
      } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthText.textContent = 'Kuat';
      }
    });
  });
</script>
@endsection
