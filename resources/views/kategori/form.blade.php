@extends('main-admin')

@section('title', $mode === 'create' ? 'Tambah Kategori/Sub Kategori' : 'Edit Kategori/Sub Kategori')

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="fw-bold mb-3">
      {{ $mode === 'create' ? 'Tambah Kategori/Sub Kategori' : 'Edit Kategori/Sub Kategori' }}
    </h3>

    @if ($mode === 'create' || $mode === 'edit')
      <!-- Form Kategori -->
      <form action="{{ $mode === 'create' ? route('kategori.store') : route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @if ($mode === 'edit')
          @method('PUT')
        @endif
        <div class="mb-3">
          <label for="nama_kategori" class="form-label">Nama Kategori</label>
          <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $mode === 'edit' ? $kategori->nama_kategori : '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">
          {{ $mode === 'create' ? 'Simpan Kategori' : 'Update Kategori' }}
        </button>
      </form>
    @endif

    @if ($mode === 'create' || $mode === 'edit-sub')
      <!-- Form Sub Kategori -->
      <form action="{{ $mode === 'create' ? route('kategori.sub.store') : route('kategori.sub.update', $subKategori->id) }}" method="POST" class="mt-4">
        @csrf
        @if ($mode === 'edit-sub')
          @method('PUT')
        @endif
        <div class="mb-3">
          <label for="kategori_id" class="form-label">Kategori</label>
          <select class="form-control" id="kategori_id" name="kategori_id" required>
            @foreach($kategoris as $kategori)
              <option value="{{ $kategori->id }}" {{ $mode === 'edit-sub' && $subKategori->kategori_id == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="nama_sub_kategori" class="form-label">Nama Sub Kategori</label>
          <input type="text" class="form-control" id="nama_sub_kategori" name="nama_sub_kategori" value="{{ $mode === 'edit-sub' ? $subKategori->nama_sub_kategori : '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">
          {{ $mode === 'create' ? 'Simpan Sub Kategori' : 'Update Sub Kategori' }}
        </button>
      </form>
    @endif
  </div>
</div>
@endsection