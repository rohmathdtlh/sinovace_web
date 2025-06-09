@extends('main-user')

@section('title', 'Layanan Izin Penelitian - Disdik Depok')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Bagian Deskripsi Kiri -->
        <div class="col-md-6">
            <div class="text-white">
                <h2>Layanan Izin Penelitian</h2>
                <p>
                    Ajukan izin penelitian Anda secara online dengan proses yang cepat, mudah, dan efisien.
                </p>
            </div>
            <div style="border: 1px solid #0174BE; background-color: #E0F0FF; padding: 20px; border-radius: 8px;">
                <h3>PERSYARATAN</h3>
                <ol>
                    <li>Surat Rekomendasi dari Kesbangpol Depok</li>
                    <li>Surat Izin Penelitian dari Kampus/Lembaga</li>
                </ol>
            </div>
            <div class="mb-3" style="background-color: #E9EFEC; padding: 10px; border-radius: 8px; margin-top: 10px;">
                <p class="text-danger text-center fw-semibold">
                    Permohonan akan diproses dalam waktu <strong>7 hari kerja</strong>. Pengambilan hasil dapat dilakukan secara online maupun offline di Gedung Dibaleka 2 Lantai 4.
                </p>
            </div>
        </div>

        <!-- Bagian Form Kanan -->
        <div class="col-md-6">
            <div class="card p-4 bg-light">
                <h3 class="text-center">Formulir Izin Penelitian</h3>
                <p class="text-center text-muted">Lengkapi data berikut untuk mengajukan permohonan.</p>

                <!-- Formulir -->
                <form action="{{ route('user.izin_penelitian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama anda..." value="{{ old('nama') }}" autofocus/>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- No. Telepon -->
                    <div class="form-group mb-3">
                        <label for="no_hp">No. Telepon</label>
                        <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ old('no_hp') }}" autofocus/>
                        @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ Auth::guard('user')->user()->email }}" 
                            readonly
                        />
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Surat Rekomendasi dari Kesbangpol -->
                    <div class="form-group mb-3">
                        <label for="sr_kesbangpol">Surat Rekomendasi dari Kesbangpol Depok</label>
                        <input type="file" id="sr_kesbangpol" name="sr_kesbangpol" class="form-control @error('sr_kesbangpol') is-invalid @enderror" />
                        <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                          @error('sr_kesbangpol')
                        <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                    </div>

                    <!-- Surat Izin Penelitian -->
                    <div class="form-group mb-3">
                        <label for="sip_kampus_lembaga">Surat Izin Penelitian dari Kampus/Lembaga</label>
                        <input type="file" id="sip_kampus_lembaga" name="sip_kampus_lembaga" class="form-control @error('sip_kampus_lembaga') is-invalid @enderror" />
                        <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                          @error('sip_kampus_lembaga')
                        <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                        <a href="{{ route('home2') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
