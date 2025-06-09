@extends('main-admin')

@section('title', 'Tambah Kategori/Sub Kategori')

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="fw-bold mb-4">
      @if($mode == 'kategori')
        Tambah Kategori
      @else
        Tambah Sub Kategori
      @endif
    </h3>

    <div class="card">
      <div class="card-body">
        <form action="{{ $mode == 'kategori' ? route('kategori.store') : route('kategori.store.sub') }}" method="POST">
          @csrf
          @if($mode == 'sub')
            <div class="mb-3">
              <label for="kategori_id" class="form-label">Kategori</label>
              <select class="form-select" id="kategori_id" name="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                  <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
          @endif

          <div class="mb-3">
            <label for="nama" class="form-label">
              @if($mode == 'kategori')
                Nama Kategori
              @else
                Nama Sub Kategori
              @endif
            </label>
            <input type="text" class="form-control" id="nama" name="{{ $mode == 'kategori' ? 'nama_kategori' : 'nama_sub_kategori' }}" required>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection