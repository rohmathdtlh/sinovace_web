@extends('main-admin')
@section('title', 'Izin Penelitian')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Formulir Ubah Data Izin Penelitian</span></h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-2">Data Izin Penelitian</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/izin_penelitian/edit/' . $izin_penelitian->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan nama anda..." value="{{ $izin_penelitian->nama }}" autofocus/>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_hp">No. HP/WA</label>
                            <div class="col-sm-10">
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="081234567890" value="{{ $izin_penelitian->no_hp }}" autofocus/>
                                @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">E-mail</label>
                            <div class="col-sm-10">
                                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" value="{{ $izin_penelitian->email }}" autofocus/>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="sr_kesbangpol">Surat Rekomendasi dari KESBANGPOL</label>
                            <div class="col-sm-10">
                                <input type="file" id="sr_kesbangpol" name="sr_kesbangpol" class="form-control @error('sr_kesbangpol') is-invalid @enderror" value="{{$izin_penelitian->sr_kesbangpol }}" />
                                <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                                @error('sr_kesbangpol')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if (old('sr_kesbangpol') || $izin_penelitian->sr_kesbangpol)
                                <p class="mt-2">File saat ini: <a href="{{asset($izin_penelitian->sr_kesbangpol) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="sip_kampus_lembaga">Surat Izin Penelitian dari Kampus/Lembaga</label>
                            <div class="col-sm-10">
                                <input type="file" id="sip_kampus_lembaga" name="sip_kampus_lembaga" class="form-control @error('sip_kampus_lembaga') is-invalid @enderror" value="{{$izin_penelitian->sip_kampus_lembaga }}" />
                                <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                                @error('sip_kampus_lembaga')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($izin_penelitian->sip_kampus_lembaga)
                                <p class="mt-2">File saat ini: <a href="{{asset($izin_penelitian->sip_kampus_lembaga) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>
                        </div>
                        <hr class="my-5 mb-3" />
                        <h5 class="fw-bold">Tanggapan</h5>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="output">Output</label>
                            <div class="col-sm-10">
                                <input type="file" id="output" name="output" class="form-control @error('output') is-invalid @enderror" value="{{($izin_penelitian->output) }}" />
                                <small style="color:gray"><p>File: pdf, jpg, jpeg, png, doc, docx.</p></small>
                                @error('output')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($izin_penelitian->output)
                                <p class="mt-2">File saat ini: <a href="{{asset($izin_penelitian->output) }}" target="_blank">Lihat File</a></p>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-select">
                                        <option value="Diterima" {{ $izin_penelitian->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Sedang Diproses" {{ $izin_penelitian->status == 'Sedang Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Ditindaklanjuti" {{ $izin_penelitian->status == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                                        <option value="Selesai" {{ $izin_penelitian->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ url('admin/izin_penelitian') }}" class="btn btn-outline-secondary">Kembali</a>

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