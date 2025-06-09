@extends('main-admin')
@section('title', 'Edit PPID')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Formulir Ubah Data PPID</span></h4>

        <div class="row">
            <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-2">Data PPID</h5>
                </div>
                <div class="card-body ms-4 me-4">
                    <form action="{{ url('admin/ppid/edit/' . $ppid->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama..." value="{{ $ppid->nama }}" autofocus/>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_hp">No. HP/WA</label>
                            <div class="col-sm-10">
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ $ppid->no_hp }}" autofocus/>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">E-mail</label>
                            <div class="col-sm-10">
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" value="{{ $ppid->email }}" autofocus/>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Masukkan alamat lengkap...">{{ $ppid->alamat }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="file_upload">Dokumen Pendukung</label>
                            <div class="col-sm-10">
                                <input type="file" id="file_upload" name="file_upload" class="form-control @error('file_upload') is-invalid @enderror" />
                                <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                                @error('file_upload')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($ppid->file_upload)
                                    <p class="mt-2">File saat ini: <a href="{{ asset($ppid->file_upload) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="output">Output</label>
    <div class="col-sm-10">
        <input type="file" id="output" name="output" class="form-control @error('output') is-invalid @enderror" />
        <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
        @error('output')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if ($ppid->output)
            <p class="mt-2">File saat ini: <a href="{{ asset($ppid->output) }}" target="_blank">Lihat File</a></p>
        @endif
    </div>
</div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-select">
                                    <option value="Diterima" {{ $ppid->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Sedang Diproses" {{ $ppid->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Ditindaklanjuti" {{ $ppid->status == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                    <option value="Selesai" {{ $ppid->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('admin.ppid.index') }}" class="btn btn-outline-secondary">Kembali</a>
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