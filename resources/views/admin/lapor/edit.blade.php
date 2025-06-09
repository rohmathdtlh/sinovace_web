@extends('main-admin')
@section('title', 'Edit Status Pengaduan')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-3" style="color: white">Edit Status Pengaduan</h3>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.lapor.update', $lapor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" value="{{ $lapor->judul }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Lokasi Kejadian</label>
                        <input type="text" class="form-control" value="{{ $lapor->lokasi_kejadian }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kejadian</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($lapor->tanggal_kejadian)->format('d-m-Y') }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="ditinjau" {{ $lapor->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $lapor->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $lapor->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="selesai" {{ $lapor->status == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.lapor.index') }}" class="btn btn-secondary">Kembali</a>
                        <input type="hidden" name="from" value="edit">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection