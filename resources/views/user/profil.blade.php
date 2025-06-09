@extends('main-user')

@section('title', 'Profil - Disdik Depok')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <h2 class="text-center mb-5 text-white fw-bold">Profil Pengguna</h2>

    <!-- Card Informasi Pengguna -->
    <div class="card shadow-lg border-0 mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i> Informasi Pengguna</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-3">
                        <strong><i class="bi bi-person me-2"></i>Nama Lengkap:</strong>
                        {{ Auth::user()->name }}
                    </p>
                    <p class="mb-3">
                        <strong><i class="bi bi-envelope me-2"></i>Email:</strong>
                        {{ Auth::user()->email }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-3">
                        <strong><i class="bi bi-check-circle me-2"></i>Status Pengguna:</strong>
                        <span class="badge bg-success">Aktif</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Status Izin Penelitian & PPID -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i> Riwayat Pengajuan</h5>
        </div>
        <div class="card-body">

            {{-- Izin Penelitian --}}
            <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-text me-2"></i> Izin Penelitian</h6>
            @if ($izin_penelitian->isEmpty())
                <div class="alert alert-warning text-center">
                    Anda belum mengajukan izin penelitian.
                </div>
            @else
                <table class="table table-hover align-middle text-center mb-5" style="table-layout: fixed; width: 100%;">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 35%;">Nama</th>
                            <th style="width: 25%;">Status</th>
                            <th style="width: 40%;">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izin_penelitian as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @if ($item->status == 'Diterima')
                                        <span class="badge bg-warning text-dark">Diterima</span>
                                    @elseif ($item->status == 'Sedang Diproses')
                                        <span class="badge bg-info text-white">Sedang Diproses</span>
                                    @elseif ($item->status == 'Ditindaklanjuti')
                                        <span class="badge bg-primary text-white">Ditindaklanjuti</span>
                                    @elseif ($item->status == 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->output)
                                        <a href="{{ Storage::url($item->output) }}" target="_blank" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-arrow-down-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Belum ada balasan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- PPID --}}
            <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-info-circle me-2"></i> PPID</h6>
            @if ($ppid->isEmpty())
                <div class="alert alert-warning text-center">
                    Anda belum mengajukan PPID.
                </div>
            @else
                <table class="table table-hover align-middle text-center" style="table-layout: fixed; width: 100%;">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 35%;">Nama</th>
                            <th style="width: 25%;">Status</th>
                            <th style="width: 40%;">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ppid as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @if ($item->status == 'Diterima')
                                        <span class="badge bg-warning text-dark">Diterima</span>
                                    @elseif ($item->status == 'Sedang Diproses')
                                        <span class="badge bg-info text-white">Sedang Diproses</span>
                                    @elseif ($item->status == 'Ditindaklanjuti')
                                        <span class="badge bg-primary text-white">Ditindaklanjuti</span>
                                    @elseif ($item->status == 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->output)
                                        <a href="{{ Storage::url($item->output) }}" target="_blank" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-arrow-down-circle"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Belum ada balasan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="mt-4">
                <a href="{{ route('home2') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
        vertical-align: middle !important;
        word-break: break-word;
    }
</style>
@endsection