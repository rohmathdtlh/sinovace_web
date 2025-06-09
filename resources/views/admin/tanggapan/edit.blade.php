@extends('main-admin')
@section('title', 'Edit Tanggapan')
@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="fw-bold mb-3" style="color: white">Edit Tanggapan</h3>
    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.tanggapan.update', $tanggapan->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="tanggapan" class="form-label">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control" rows="3" required>{{ $tanggapan->tanggapan }}</textarea>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label">Lampiran (Opsional)</label>
            <input type="file" name="file" id="file" class="form-control">
            @if ($tanggapan->file_path)
              <small class="text-muted">Lampiran saat ini: <a href="{{ Storage::url($tanggapan->file_path) }}" target="_blank">Lihat</a></small>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection