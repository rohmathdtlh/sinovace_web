@extends('main-admin')
@section('title', 'Izin Penelitian')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Formulir Tambah Layanan Izin Penelitian</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Layanan Izin Penelitian</h5>
                </div>
                <div class="card-body">
                <form action="{{ route('admin.izin_penelitian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 d-flex">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama anda..." value="{{ old('nama') }}" autofocus/>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                        <div class="col-sm-10">
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ old('no_hp') }}" autofocus/>
                            @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" value="{{ old('email') }}" autofocus/>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="sr_kesbangpol" class="col-sm-2 col-form-label">Surat Rekomendasi dari KESBANGPOL</label>
                        <div class="col-sm-10">
                            <input type="file" id="sr_kesbangpol" name="sr_kesbangpol" class="form-control @error('sr_kesbangpol') is-invalid @enderror" />
                            <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                              @error('sr_kesbangpol')
                            <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="sip_kampus_lembaga" class="col-sm-2 col-form-label">Surat Izin Penelitian dari Kampus/Lembaga</label>
                        <div class="col-sm-10">
                            <input type="file" id="sip_kampus_lembaga" name="sip_kampus_lembaga" class="form-control @error('sip_kampus_lembaga') is-invalid @enderror" />
                            <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                              @error('sip_kampus_lembaga')
                            <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label class="col-sm-2 col-form-label" for="status">Status</label>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <select name="status" id="status" class="form-select">
                                    <option value="Diterima" {{ old('status', 'Diterima') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Sedang Diproses" {{ old('status', 'Diterima') == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Ditindaklanjuti" {{ old('status', 'Diterima') == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                    <option value="Selesai" {{ old('status', 'Diterima') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('admin.izin_penelitian') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
@endsection