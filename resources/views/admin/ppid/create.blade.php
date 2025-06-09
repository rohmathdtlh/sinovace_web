@extends('main-admin')
@section('title', 'Tambah PPID')
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Formulir Tambah Layanan PPID</span></h4>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Layanan PPID</h5>
                    </div>
                    <div class="card-body ms-4 me-4">
                        <form action="{{ route('admin.ppid.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 d-flex">
                                <label class="col-sm-2 col-form-label" for="jenis">Jenis</label>
                                <div class="col-sm-10">
                                    <select name="jenis" id="jenis" class="form-select">
                                        <option value="permohonan" {{ old('jenis', 'permohonan') == 'permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                                        <option value="keberatan" {{ old('jenis', 'keberatan') == 'keberatan' ? 'selected' : '' }}>Keberatan Pemberian Informasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama..." value="{{ old('nama') }}" autofocus/>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                                <div class="col-sm-10">
                                    <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ old('no_hp') }}"/>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" value="{{ old('email') }}"/>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label for="file_upload" class="col-sm-2 col-form-label">Dokumen Pendukung</label>
                                <div class="col-sm-10">
                                    <input type="file" id="file_upload" name="file_upload" class="form-control @error('file_upload') is-invalid @enderror" />
                                    <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                                    @error('file_upload')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-select">
                                        <option value="Diterima" {{ old('status', 'Diterima') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Sedang Diproses" {{ old('status', 'Diterima') == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="Ditindaklanjuti" {{ old('status', 'Diterima') == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                        <option value="Selesai" {{ old('status', 'Diterima') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ route('admin.ppid.index') }}" class="btn btn-outline-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection