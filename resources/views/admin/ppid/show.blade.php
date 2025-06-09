@extends('main-admin')
@section('title', 'PPID')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Detail Data Layanan PPID</span></h4>

        <div class="row">
            <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0"><i class='bx bx-chevrons-right' style="font-size: 1.5rem;"></i>Data Diri</h5>
                </div>
                <div class="card-body" style="margin-left: 1.5rem;">
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-8">
                            {{ ': ' . $ppid->nama }}
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Nomor Handphone/WhatsApp</label>
                        </div>
                        <div class="col-md-8">
                            {{ ': ' . $ppid->no_hp }}
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>E-mail</label>
                        </div>
                        <div class="col-md-8">
                            {{ ': ' . $ppid->email }}
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Alamat</label>
                        </div>
                        <div class="col-md-8">
                            {{ ': ' . $ppid->alamat }}
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center justify-content-between mt-0">
                    <h5 class="fw-bold mb-0"><i class='bx bx-chevrons-right' style="font-size: 1.5rem;"></i>Berkas Pendukung</h5>
                </div>
                <div class="card-body" style="margin-left: 1.5rem;">
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Dokumen Pendukung</label>
                        </div>
                        <div class="col-md-8">
                            @if($ppid->file_upload)
                                <span>:</span>
                                <a href="{{ asset($ppid->file_upload) }}" target="_blank">Lihat File</a>
                            @else
                                <span>:</span>
                                <span>Tidak ada file</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center justify-content-between mt-0">
                    <h5 class="fw-bold mb-0"><i class='bx bx-chevrons-right' style="font-size: 1.5rem;"></i>Status</h5>
                </div>
                <div class="card-body" style="margin-left: 1.5rem;">
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Status</label>
                        </div>
                        <div class="col-md-8">
                            {{ ': ' . $ppid->status }}
                        </div>
                    </div>
                </div>
                <div class="divider d-flex justify-content-end align-items-end">
                    <a href="{{ route('admin.ppid.index') }}" class="btn btn-outline-secondary me-4">Kembali</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection