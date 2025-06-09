@extends('main-admin')

@section('title', 'Edit Kategori dan Sub Kategori')

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="fw-bold mb-4">
      Edit Kategori dan Sub Kategori
    </h3>

    <div class="card">
      <div class="card-body">
        <form action="{{ route('kategori.update.gabungan', $kategori->id) }}" method="POST">
          @csrf
          @method('PUT')
        
          <!-- Edit Nama Kategori -->
          <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
          </div>
        
          <hr>
        
          <h5>Edit Sub Kategori</h5>
          @forelse($kategori->subKategori as $index => $sub)
            <div class="mb-3 d-flex align-items-center gap-2">
              <input type="hidden" name="sub_ids[]" value="{{ $sub->id }}">
              <input type="text" class="form-control" name="sub_nama[]" value="{{ $sub->nama_sub_kategori }}" required>

              <!-- Tombol hapus -->
              <a href="#" class="btn btn-danger btn-sm"
                 onclick="event.preventDefault(); if(confirm('Yakin hapus?')) document.getElementById('delete-sub-{{ $sub->id }}').submit();">
                Hapus
              </a>
            </div>
          @empty
            <p class="text-muted">Belum ada sub kategori untuk kategori ini.</p>
          @endforelse

          <button type="submit" class="btn btn-primary">Update Semua</button>
          <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>

        <!-- Pindahkan semua form hapus ke sini (di luar form utama) -->
        @foreach($kategori->subKategori as $sub)
          <form id="delete-sub-{{ $sub->id }}" action="{{ route('kategori.destroy.sub', $sub->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>
        @endforeach

      </div>
    </div>
  </div>
</div>
@endsection
