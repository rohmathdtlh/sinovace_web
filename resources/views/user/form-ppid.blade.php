{{-- filepath: resources/views/user/form-ppid.blade.php --}}
@extends('main-user')

@section('title', 'Layanan PPID - Disdik Depok')

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
                <h2>Layanan PPID</h2>
                <p>
                    Ajukan permohonan informasi (PPID) secara online dengan proses yang cepat, mudah, dan efisien.
                </p>
            </div>
           <div style="border: 1px solid #0174BE; background-color: #E0F0FF; padding: 20px; border-radius: 8px;">
                <h3>PERSYARATAN</h3>
                <ol>
                    <li>Isi data diri dengan benar dan lengkap</li>
                    <li>Unggah dokumen persyaratan</li>
                </ol>
            </div>
            <div style="background-color: #E9EFEC; padding: px; border-radius: 8px; margin-top: 10px;">
                <p class="text-danger text-center fw-semibold mb-3">
                    Permohonan akan diproses dalam waktu <strong>10 hari kerja</strong>. Hasil permohonan dapat diambil secara online maupun offline di Gedung Dibaleka 2 Lantai 4.
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Tab Navigasi -->
            <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="permohonan-tab" data-bs-toggle="tab" data-bs-target="#permohonan" type="button" role="tab">Permohonan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="keberatan-tab" data-bs-toggle="tab" data-bs-target="#keberatan" type="button" role="tab">Keberatan</button>
                </li>
            </ul>

            <div class="tab-content" id="formTabsContent">
                <!-- Form Permohonan -->
                <div class="tab-pane fade show active" id="permohonan" role="tabpanel">
                    <div class="card p-4 bg-light">
                        <h3 class="text-center">Formulir Permohonan PPID</h3>
                        <p class="text-center text-muted">Lengkapi data berikut untuk mengajukan permohonan informasi publik.</p>

                        <!-- Formulir -->
                        <form action="{{ route('user.ppid.store') }}" method="POST" enctype="multipart/form-data" id="form-permohonan">
                            @csrf
                            <input type="hidden" name="jenis" value="permohonan">
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
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ old('no_hp') }}"/>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input 
                                    type="email" 
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

                            <!-- Alamat -->
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Dokumen Pendukung -->
                            <div class="form-group mb-3">
                                <label for="file"> File Permohonan PPID </label>
                                <small style="color:gray">
                                    <p>Template Permohonan PPID:
                                        <a href="{{ asset('template/FORM-PERMOHONAN-PPID.docx') }}" download>Downlnoad
                                        </a>
                                    </p>
                                </small>
                                <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror" />
                                <small style="color:gray"><p>File: pdf, docx. Maksimal 5MB.</p></small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary mb-2" form="form-permohonan">Simpan</button>
                                <a href="{{ route('home2') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Form Keberatan -->
                <div class="tab-pane fade" id="keberatan" role="tabpanel">
                    <div class="card p-4 bg-light">
                        <h3 class="text-center">Formulir Keberatan Atas Pemberian Informasi</h3>
                        <p class="text-center text-muted">Lengkapi data berikut untuk mengajukan permohonan informasi publik.</p>

                        <!-- Formulir -->
                        <form action="{{ route('user.ppid.store') }}" method="POST" enctype="multipart/form-data" id="form-keberatan">
                            @csrf
                            <input type="hidden" name="jenis" value="keberatan">
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
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ old('no_hp') }}"/>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input 
                                    type="email" 
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

                            <!-- Alamat -->
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Dokumen Pendukung -->
                            <div class="form-group mb-3">
                                <label for="file"> File Keberatan Pemberian Informasi </label>
                                <small style="color:gray">
                                    <p>Template Keberatan:
                                        <a href="{{ asset('template/FORM-KEBERATAN-PPID.docx') }}" download>Downlnoad
                                        </a>
                                    </p>
                                </small>
                                <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror" />
                                <small style="color:gray"><p>File: pdf, docx. Maksimal 5MB.</p></small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary mb-2" form="form-keberatan">Simpan</button>
                                <a href="{{ route('home2') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection