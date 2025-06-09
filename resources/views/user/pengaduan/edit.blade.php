@extends('main-user')

@section('title', 'Edit Pengaduan - Disdik Depok')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>Edit Pengaduan</h4>
                </div>
                
                <div class="card-body">
                    <!-- Notifikasi -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form Edit Pengaduan -->
                    <form action="{{ route('user.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Kategori/Subkategori -->
                        <div class="mb-4">
                            <label for="kategori" class="form-label fw-semibold">Kategori Pengaduan</label>
                            <select id="kategori" name="kategori_or_subkategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori atau Subkategori --</option>
                                @foreach ($kategoriPengaduan as $kategori)
                                    <option value="kategori-{{ $kategori->id }}" {{ $pengaduan->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }} (Kategori)
                                    </option>
                                    @foreach ($kategori->subKategori as $sub)
                                        <option value="sub-{{ $sub->id }}" {{ $pengaduan->sub_kategori_id == $sub->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;{{ $sub->nama_sub_kategori }} (Subkategori)
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            <small class="text-muted">Pilih kategori yang paling sesuai dengan laporan Anda</small>
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="judul" class="form-label fw-semibold">Judul Laporan</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul', $pengaduan->judul) }}" placeholder="Masukkan judul laporan" required>
                        </div>

                        <!-- Lokasi dan Tanggal -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="lokasi_kejadian" class="form-label fw-semibold">Lokasi Kejadian</label>
                                <input type="text" name="lokasi_kejadian" class="form-control" value="{{ old('lokasi_kejadian', $pengaduan->lokasi_kejadian) }}" placeholder="Contoh: SDN Depok 1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_kejadian" class="form-label fw-semibold">Tanggal Kejadian</label>
                                <input type="date" name="tanggal_kejadian" class="form-control" value="{{ old('tanggal_kejadian', $pengaduan->tanggal_kejadian) }}" required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Lengkap</label>
                            <textarea name="deskripsi" class="form-control" rows="5" placeholder="Jelaskan kejadian secara detail (siapa, apa, kapan, dimana, bagaimana)" required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-4">
                            <label for="lampiran" class="form-label fw-semibold">Lampiran Pendukung</label>
                            <input type="file" name="lampiran" class="form-control" accept="image/*,.pdf,.doc,.docx">
                            
                            @if($pengaduan->lampiran)
                                <div class="mt-2">
                                    <small class="text-muted">Lampiran saat ini:</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <i class="fas fa-paperclip me-2"></i>
                                        <a href="{{ Storage::url($pengaduan->lampiran) }}" target="_blank" class="text-decoration-none">
                                            Lihat Lampiran
                                        </a>
                                        <a href="#" class="text-danger ms-3" data-bs-toggle="modal" data-bs-target="#hapusLampiranModal">
                                            <i class="fas fa-trash-alt me-1"></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <small class="text-muted">Format: JPG, PNG, PDF, DOC (Maks. 5MB)</small>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Lampiran -->
@if($pengaduan->lampiran)
<div class="modal fade" id="hapusLampiranModal" tabindex="-1" aria-labelledby="hapusLampiranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="hapusLampiranModalLabel">Konfirmasi Hapus Lampiran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus lampiran ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('user.pengaduan.hapusLampiran', $pengaduan->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection