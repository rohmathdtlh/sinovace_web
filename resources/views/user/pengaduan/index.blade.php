@extends('main-user')

@section('title', 'Layanan Pengaduan - Disdik Depok')

@section('content')
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showModal("{{ session('success') }}");
        });
    </script>
@endif

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex flex-column p-4 rounded shadow" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="text-white fw-bold mb-0">
                <i class="bi bi-house-door me-2"></i>Layanan Pengaduan
            </h3>

        @auth('user')
        <div class="text-end d-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2">
            <button class="btn btn-light fw-semibold me-0 mb-2 mb-sm-0">
                <i class="bi bi-person-circle me-2"></i>
                {{ Auth::guard('user')->user()->name }}
            </button>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger fw-semibold">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
        @else
            <div class="text-end">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('user.registration') }}" class="btn btn-secondary">Daftar</a>
            </div>
        @endauth

        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills gap-2 justify-content-start mt-3" id="pengaduanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active tab-button" id="ajukan-tab" data-bs-toggle="tab" 
                    data-bs-target="#ajukan" type="button" role="tab" aria-controls="ajukan" 
                    aria-selected="true">
                    <i class="bi bi-pencil-square me-2"></i>Buat Pengaduan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link tab-button" id="balasan-tab" data-bs-toggle="tab" 
                    data-bs-target="#balasan" type="button" role="tab" aria-controls="balasan" 
                    aria-selected="false">
                    <i class="bi bi-chat-left-text me-2"></i>Kotak Masuk
                </button>
            </li>
        </ul>
    </div>

    <!-- Warning -->
    <div class="alert alert-danger d-flex flex-column mt-4 shadow animate__animated animate__fadeIn" role="alert">
  <div class="d-flex align-items-center mb-2">
    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
    <div>
      <strong>Perhatian:</strong> Pelayanan Pengaduan Masyarakat akan diproses dan diterbitkan setelah 5 hari kerja.
    </div>
  </div>
    </div>


    <!-- Card Tab -->
    <div class="card border-0 shadow rounded mt-4 animate__animated animate__fadeInUp mb-4">
        <div class="card-body">
            <div class="tab-content mt-3">
                <!-- Tab: Ajukan Pengaduan -->
                <div class="tab-pane fade show active" id="ajukan" role="tabpanel" aria-labelledby="ajukan-tab">
                    <form action="{{ isset($pengaduan) ? route('user.pengaduan.update', $pengaduan->id) : route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($pengaduan))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul Pengaduan</label>
                            <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control shadow-sm" placeholder="Masukkan Judul Laporan" value="{{ old('judul', $pengaduan->judul ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label fw-semibold">Kategori</label>
                            <span class="text-danger">*</span></label>
                            <select id="kategori" name="kategori_or_subkategori_id" class="form-control shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoriPengaduan as $kategori)
                                    <option value="kategori-{{ $kategori->id }}" {{ isset($pengaduan) && $pengaduan->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }} (Kategori)
                                    </option>
                                    @foreach ($kategori->subKategori as $sub)
                                        <option value="sub-{{ $sub->id }}" {{ isset($pengaduan) && $pengaduan->sub_kategori_id == $sub->id ? 'selected' : '' }}>
                                            — {{ $sub->nama_sub_kategori }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="lokasi_kejadian" class="form-label fw-semibold">Lokasi Kejadian <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi_kejadian" class="form-control shadow-sm" 
                                       placeholder="Contoh: Jl. Merdeka No. 10, RT 05/RW 02"
                                       value="{{ old('lokasi_kejadian', $pengaduan->lokasi_kejadian ?? '') }}" required>
                                <div class="invalid-feedback">Harap isi lokasi kejadian</div>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_kejadian" class="form-label fw-semibold">Tanggal Kejadian <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kejadian" class="form-control shadow-sm" 
                                       value="{{ old('tanggal_kejadian', $pengaduan->tanggal_kejadian ?? '') }}" required>
                                <div class="invalid-feedback">Harap pilih tanggal kejadian</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Pengaduan</label>
                            <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control shadow-sm" rows="4" placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('deskripsi', $pengaduan->deskripsi ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="lampiran" class="form-label fw-semibold">Lampiran (Opsional)</label>
                            <input type="file" id="lampiran" name="lampiran" class="form-control shadow-sm">
                            @if(isset($pengaduan) && $pengaduan->lampiran)
                                <small class="text-muted">Lampiran saat ini: 
                                    <a href="{{ Storage::url($pengaduan->lampiran) }}" target="_blank">Lihat</a>
                                </small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none;">
                            <i class="bi bi-send me-2"></i>{{ isset($pengaduan) ? 'Update Pengaduan' : 'Kirim Pengaduan' }}
                        </button>
                    </form>
                </div>
                <div class="tab-pane fade" id="balasan" role="tabpanel" aria-labelledby="balasan-tab">
                    <div class="alert alert-info shadow-sm mb-4">
                        <i class="bi bi-info-circle"></i> Anda dapat melihat tanggapan di sini setelah pengaduan diproses.
                    </div>
                
                    @if(auth('user')->check())
                        <form method="GET" action="{{ route('user.pengaduan.index') }}" class="mb-4">
                            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control shadow-sm" placeholder="Cari judul pengaduan...">
                        </form>
                
                        @foreach ($lapors as $lapor)
                         @php
                        $isClosed = in_array($lapor->status, ['ditutup', 'selesai']);
                        
                        // Tambahkan class badge sesuai status
                        $badgeClass = 'bg-primary'; // default
                        if ($lapor->status === 'selesai') {
                            $badgeClass = 'bg-success';
                        } elseif ($lapor->status === 'selesai') {
                            $badgeClass = 'bg-success';
                        } elseif ($lapor->status === 'diproses') {
                            $badgeClass = 'bg-warning text-dark';
                        }
                         @endphp
                    
                        <div class="card mb-4 shadow-sm border-0 {{ $isClosed ? 'bg-light text-muted' : '' }}" 
                            style="border-left: 5px solid {{ $isClosed ? 'gray' : '#007bff' }};">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title fw-bold">{{ $lapor->judul }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="bi bi-geo-alt"></i> {{ $lapor->lokasi_kejadian }}
                                        </h6>
                                    </div>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($lapor->status) }}
                                    </span>
                                </div>
                                
                                <p class="card-text mt-3" style="white-space: pre-wrap; line-height: 1.6;">{{ $lapor->deskripsi }}</p>
                                
                               @if($lapor->lampiranPengaduan && $lapor->lampiranPengaduan->count())
                                    <div class="mt-2">
                                        @foreach($lapor->lampiranPengaduan as $lampiran)
                                            <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="bi bi-file-earmark-arrow-down"></i> Lampiran Pengaduan
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                    <hr>
                
                                    <h6 class="fw-bold mb-3"><i class="bi bi-chat-dots"></i> Tanggapan </h6>
                
                                    @if ($lapor->tanggapans->isNotEmpty())
                                        <div class="timeline">
                                            @foreach ($lapor->tanggapans as $tanggapan)
                                                <div class="timeline-item admin">
                                                    <div class="timeline-item admin">
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <span class="badge bg-primary">
                                                                <i class="bi bi-person-badge me-1"></i> Admin
                                                            </span>
                                                            <small class="text-muted">
                                                                {{ $tanggapan->created_at->format('d M Y, H:i') }}
                                                            </small>
                                                        </div>
                                                        
                                                        <div class="card bg-light p-3 mb-2">
                                                            <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $tanggapan->tanggapan }}</p>
                                                        </div>
                                                        
                                                        @if ($tanggapan->file_path)
                                                            <div class="mt-2">
                                                                <a href="{{ Storage::url($tanggapan->file_path) }}" 
                                                                target="_blank" 
                                                                class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Lampiran
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    </div>
                                                </div>
                
                                                @foreach ($tanggapan->komentars as $komentar)
                                                    <div class="timeline-item {{ $komentar->user->role === 'admin' ? 'admin' : 'user' }} mb-3">
                                                        <div class="timeline-content">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="badge {{ $komentar->user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                                                                    <i class="bi bi-{{ $komentar->user->role === 'admin' ? 'person-badge' : 'person' }} me-1"></i>
                                                                    {{ $komentar->user->role === 'admin' ? 'Admin' : ($komentar->user_id === auth('user')->id() ? 'Anda' : $komentar->user->name) }}
                                                                </span>
                                                                <small class="text-muted">
                                                                    {{ $komentar->created_at->format('d M Y, H:i') }}
                                                                </small>
                                                            </div>
                                                            
                                                            <div class="card {{ $komentar->user->role === 'admin' ? 'bg-light' : 'bg-white border' }} p-3 mb-2">
                                                                <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $komentar->komentar }}</p>
                                                            </div>
                                                            
                                                            @if ($komentar->file_path)
                                                                <div class="mt-2">
                                                                    <a href="{{ Storage::url($komentar->file_path) }}" 
                                                                    target="_blank" 
                                                                    class="btn btn-sm {{ $komentar->user->role === 'admin' ? 'btn-outline-primary' : 'btn-outline-success' }}">
                                                                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat Lampiran
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                
                                                @if (!$isClosed)
                                                <div class="mt-4">
                                                    <!-- Tombol Balas -->
                                                    <button class="btn btn-outline-primary rounded-pill d-flex align-items-center" 
                                                            type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#formBalasan{{ $tanggapan->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="formBalasan{{ $tanggapan->id }}">
                                                        <i class="bi bi-reply me-2"></i> Balas
                                                    </button>

                                                    <!-- Form Balasan -->
                                                    <div class="collapse mt-3" id="formBalasan{{ $tanggapan->id }}">
                                                        <div class="card border-0 shadow-sm">
                                                            <div class="card-body p-3">
                                                                <form action="{{ route('user.komentar.store', $tanggapan->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <!-- Field Komentar -->
                                                                    <div class="mb-3">
                                                                        <label for="komentar{{ $tanggapan->id }}" class="form-label fw-semibold small">Balasan Anda</label>
                                                                        <textarea name="komentar" id="komentar{{ $tanggapan->id }}" class="form-control form-control-sm" 
                                                                                rows="3" placeholder="Tulis balasan Anda..." required></textarea>
                                                                    </div>
                                                                    
                                                                    <!-- Field Upload File -->
                                                                    <div class="mb-3">
                                                                        <label for="lampiran{{ $tanggapan->id }}" class="form-label fw-semibold small d-block">
                                                                            <i class="bi bi-paperclip me-1"></i> Lampiran (Opsional)
                                                                        </label>
                                                                        <input type="file" name="lampiran" id="lampiran{{ $tanggapan->id }}" class="form-control form-control-sm">
                                                                        <div class="form-text small">Maks. 2MB (PDF, JPG, PNG, DOC, DOCX)</div>
                                                                    </div>
                                                                    
                                                                    <!-- Tombol Aksi -->
                                                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                                                        <button type="button" 
                                                                            class="btn btn-sm btn-outline-secondary rounded-pill px-3" 
                                                                            onclick="bootstrap.Collapse.getOrCreateInstance(document.getElementById('formBalasan{{ $tanggapan->id }}')).hide();"
                                                                            aria-label="Batal">
                                                                        Batal
                                                                        </button>
                                                                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">
                                                                            <i class="bi bi-send me-1"></i> Kirim
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="bi bi-info-circle"></i> Belum ada tanggapan
                                        </div>
                                    @endif
                
                                    @if(in_array($lapor->status, ['selesai', 'ditutup']))
                                    <hr>
                                    <div class="rating-section mt-3">
                                        <h6 class="fw-bold"><i class="bi bi-star-fill text-warning"></i> Penilaian Pelayanan</h6>

                                        @if($lapor->ratings->where('user_id', auth('user')->id())->count() > 0)
                                            <div class="rating-display">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $lapor->ratings->first()->rating)
                                                        <i class="bi bi-star-fill text-warning fs-4"></i>
                                                    @else
                                                        <i class="bi bi-star text-secondary fs-4"></i>
                                                    @endif
                                                @endfor
                                                <p class="mt-2 d-inline-block ms-2">{{ $lapor->ratings->first()->rating }} Bintang</p>
                                                @if($lapor->ratings->first()->komentar)
                                                    <div class="mt-2">
                                                        <p class="mb-1"><strong>Komentar Anda:</strong></p>
                                                        <p class="text-muted">{{ $lapor->ratings->first()->komentar }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <button class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#ratingModal"
                                                data-pengaduan-id="{{ $lapor->id }}"
                                                data-admin-id="{{ $lapor->tanggapans->first()->user_id ?? '' }}"
                                                data-action="{{ route('user.pengaduan.rating.store', $lapor->id) }}">
                                                <i class="bi bi-star-fill me-1"></i>Beri Rating
                                            </button>
                                        @endif
                                    </div>
                                    @endif

                                    <hr>
                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{-- Tombol Edit hanya muncul jika belum ada tanggapan --}}
                                            @if ($lapor->tanggapans->isEmpty())
                                                <a href="{{ route('user.pengaduan.edit', $lapor->id) }}" class="btn btn-warning btn-sm me-2">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            @endif
                                    
                                            {{-- Tombol Tutup hanya muncul jika sudah ada tanggapan --}}
                                            @if (!$isClosed && !$lapor->tanggapans->isEmpty())
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                                    data-bs-target="#confirmCloseModal" data-action="{{ route('user.pengaduan.tutup', $lapor->id) }}">
                                                    <i class="bi bi-lock-fill"></i> Tutup
                                                </button>
                                            @endif
                                        </div>
                                        
                                        {{-- Tombol Hapus selalu muncul --}}
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" data-id="{{ $lapor->id }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $lapors->links('pagination::bootstrap-5') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Penutupan Pengaduan -->
    <div class="modal fade" id="confirmCloseModal" tabindex="-1" aria-labelledby="confirmCloseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCloseModalLabel">Konfirmasi Penutupan Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menutup pengaduan ini? Pengaduan yang ditutup tidak dapat dibalas atau diubah.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="closeForm" method="POST" action="">
                        @csrf
                        <button type="submit" class="btn btn-danger">Ya, Tutup Pengaduan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pengaduan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="successModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close" onclick="closeModal()">&times;</span>
            <p id="successMessage"></p>
        </div>
    </div>
    <div class="mt-4 mb-3">
        <a href="{{ route('home2') }}" class="btn text-white fw-semibold"
        style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    </div>
<!-- CSS untuk Tab Button -->

<style>
    .card {
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
}

.badge {
    font-size: 0.9rem;
    padding: 5px 10px;
}

button {
    transition: all 0.3s ease-in-out;
}

.btn-close-pengaduan {
    background: linear-gradient(135deg, #dc3545, #ff6b6b);
    color: white;
    border: none;
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-close-pengaduan:hover {
    background: linear-gradient(135deg, #c82333, #ff4d4d);
    transform: scale(1.1);
}

    .tab-button {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    .tab-button:hover {
        background: linear-gradient(135deg, #1b355f 0%, #234b85 100%);
    }
    .tab-button.active {
        background: linear-gradient(135deg, #162c54 0%, #1f4173 100%);
    }
    <style>
    .timeline {
        position: relative;
        padding-left: 20px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        width: 2px;
        height: 100%;
        background: #dee2e6;
    }
    
    .timeline-item:last-child:before {
        height: 0;
    }
    
    .timeline-item.admin:after {
        content: '';
        position: absolute;
        left: -25px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #0d6efd;
        border: 2px solid white;
    }
    
    .timeline-item.user:after {
        content: '';
        position: absolute;
        left: -25px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #198754;
        border: 2px solid white;
    }
    
    .timeline-content {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .timeline-item.admin .timeline-content {
        border-left: 3px solid #0d6efd;
    }
    
    .timeline-item.user .timeline-content {
        border-left: 3px solid #198754;
    }
    .custom-modal {
    display: none;
    position: fixed;
    z-index: 1050; /* Lebih tinggi untuk memastikan di atas elemen lain */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); /* Sedikit lebih gelap */
}

.custom-modal-content {
    background-color: #fff;
    margin: 15vh auto; /* Menggunakan vh untuk centering lebih baik */
    padding: 25px;
    width: 85%;
    max-width: 400px;
    border-radius: 10px; /* Sedikit lebih rounded */
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Shadow lebih halus */
    border-top: 4px solid #3490dc; /* Tambahan aksen biru di atas */
    position: relative;
    animation: fadeIn 0.3s ease-out; /* Animasi halus */
}

.custom-modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #777;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s;
}

.custom-modal-close:hover {
    color: #333;
    transform: scale(1.1); /* Efek zoom kecil saat hover */
}

/* Animasi sederhana */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</style>

<!-- JavaScript untuk Mengambil Sub Kategori -->
<script>
    // ==================== FUNGSI UTAMA SAAT HALAMAN DIMUAT ====================
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Fungsi untuk dropdown kategori dan sub kategori
        initKategoriDropdown();
        
        // 2. Fungsi untuk modal hapus pengaduan
        initDeleteModal();
        
        // 3. Fungsi untuk modal konfirmasi penutupan pengaduan
        initCloseModal();
        
        // 4. Fungsi untuk modal rating
        initRatingModal();
        
        // 5. Pulihkan posisi scroll setelah halaman dimuat
        restoreScrollPosition();
    });

    // ==================== FUNGSI INISIALISASI ====================

    // 1. Dropdown Kategori dan Sub Kategori
    function initKategoriDropdown() {
        const kategoriSelect = document.getElementById('kategori');
        if (kategoriSelect) {
            kategoriSelect.addEventListener('change', function() {
                const kategoriId = this.value;
                const subKategoriSelect = document.getElementById('sub_kategori_id');

                // Kosongkan dropdown sub kategori
                subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';

                if (kategoriId) {
                    // Ambil data sub kategori berdasarkan kategori_id
                    fetch(`/get-sub-kategoris/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(subKategori => {
                                const option = document.createElement('option');
                                option.value = subKategori.id;
                                option.textContent = subKategori.nama_sub_kategori;
                                subKategoriSelect.appendChild(option);
                            });
                        });
                }
            });
        }
    }

    // 2. Modal Hapus Pengaduan
    function initDeleteModal() {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            const deleteForm = document.getElementById('deleteForm');
            
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const pengaduanId = button.getAttribute('data-id');
                const action = "{{ route('user.pengaduan.destroy', ':id') }}".replace(':id', pengaduanId);
                deleteForm.setAttribute('action', action);
            });
        }
    }

    // 3. Modal Konfirmasi Penutupan Pengaduan
    function initCloseModal() {
        const confirmCloseModal = document.getElementById('confirmCloseModal');
        if (confirmCloseModal) {
            const closeForm = document.getElementById('closeForm');
            
            confirmCloseModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const actionUrl = button.getAttribute('data-action');
                closeForm.setAttribute('action', actionUrl);
            });
        }
    }

    // 4. Modal Rating
    function initRatingModal() {
        const ratingModal = document.getElementById('ratingModal');
        if (ratingModal) {
            ratingModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const pengaduanId = button.getAttribute('data-pengaduan-id');
                const adminId = button.getAttribute('data-admin-id');
                const actionUrl = button.getAttribute('data-action');
                
                const form = ratingModal.querySelector('#ratingForm');
                form.setAttribute('action', actionUrl);
                document.getElementById('adminIdInput').value = adminId;
            });

            document.querySelectorAll('[data-bs-target]').forEach(button => {
                button.addEventListener('click', function () {
                    const target = document.querySelector(this.getAttribute('data-bs-target'));
                    if (target) {
                        target.classList.toggle('show');
                    }
                });
            });

            // Fungsi rating bintang
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    
                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.remove('text-secondary');
                            s.classList.add('text-warning');
                        } else {
                            s.classList.remove('text-warning');
                            s.classList.add('text-secondary');
                        }
                    });
                });
            });
        }
    }
    function showModal(message) {
        const modal = document.getElementById('successModal');
        const messageElement = document.getElementById('successMessage');
        messageElement.textContent = message;
        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'none';
    }

    // Optional: Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('successModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal Rating -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Beri Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ratingForm" method="POST" action="">
                @csrf
                <input type="hidden" name="admin_id" id="adminIdInput" value="">
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <label for="rating" class="form-label">Rating</label>
                        <div id="starRating" class="d-flex justify-content-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star text-secondary fs-3 star" data-value="{{ $i }}" style="cursor: pointer;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection