@extends('main-admin')
@section('title', 'Izin Penelitian')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4"><span class="text-muted fw-light">Detail Data Layanan Izin Penelitian</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
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
                            {{': ' . $izin_penelitian->nama }}
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Nomor Handphone/WhatsApp<i style="color:red">*</i></label>
                        </div>
                        <div class="col-md-8">
                            {{': ' . $izin_penelitian->no_hp }}
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-4">
                            <label>E-mail<i style="color:red">*</i></label>
                        </div>
                        <div class="col-md-8">
                            {{': ' . $izin_penelitian->email }}
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center justify-content-between mt-0">
                    <h5 class="fw-bold mb-0"><i class='bx bx-chevrons-right' style="font-size: 1.5rem;"></i>Berkas Persyaratan</h5>
                </div>
                <div class="card-body" style="margin-left: 1.5rem;">
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Surat Rekomendasi dari KESBANGPOL</label>
                        </div>
                        <div class="col-md-8">
                            @if($izin_penelitian->sr_kesbangpol)
                            <span>:</span>
                            <a href="{{ asset($izin_penelitian->sr_kesbangpol) }}" target="_blank">Lihat File</a>
                            @else
                                <span>:</span>
                                <span>File tersedia</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Surat Pengantar Kampus/Lembaga</label>
                        </div>
                        <div class="col-md-8">
                            @if($izin_penelitian->sip_kampus_lembaga)
                            <span>:</span>
                            <a href="{{ asset($izin_penelitian->sip_kampus_lembaga) }}" target="_blank">Lihat File</a>
                            @else
                                <span>:</span>
                                <span>File tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center justify-content-between mt-0">
                    <h5 class="fw-bold mb-0"><i class='bx bx-chevrons-right' style="font-size: 1.5rem;"></i>Tanggapan</h5>
                </div>
                <div class="card-body" style="margin-left: 1.5rem;">
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Output</label>
                        </div>
                        <div class="col-md-8">
                            @if($izin_penelitian->output)
                            <span>:</span>
                            <a href="{{ asset($izin_penelitian->output) }}" target="_blank">Lihat File</a>
                            @else
                                <span>:</span>
                                <span>File tersedia</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="form-group row mb-1">
                        <div class="col-md-4">
                            <label>Status</label>
                        </div>
                        <div class="col-md-8">
                            {{': ' . $izin_penelitian->status }}
                        </div>
                    </div>
                </div>
                <div class="divider d-flex justify-content-end align-items-end">
                    <a href="{{ url('admin/izin_penelitian') }}" class="btn btn-outline-secondary me-4">Kembali</a>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
@endsection