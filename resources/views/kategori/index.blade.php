@extends('main-admin')

@section('title', 'Manajemen Kategori dan Sub Kategori')

@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header dan Breadcrumb -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Manajemen /</span> Kategori & Sub Kategori
          </h4>
        </div>
      </div>
    </div>

    <!-- Alert Notification -->
    @if(session('success') || session('status'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        {{ session('success') ?? session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Card Utama -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Kategori</h5>
        <div class="d-flex">
          <a href="{{ route('kategori.create') }}" class="btn btn-primary me-2">
            <i class="bx bx-plus me-1"></i> Tambah Kategori
          </a>
          <a href="{{ route('kategori.create.sub') }}" class="btn btn-outline-secondary">
            <i class="bx bx-plus me-1"></i> Tambah Sub Kategori
          </a>
        </div>
      </div>
      
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th>Nama Kategori</th>
                <th>Sub Kategori</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse($kategoris as $kategori)
                <tr>
                  <td><strong>{{ $loop->iteration }}</strong></td>
                  <td>
                    <span class="fw-medium">{{ $kategori->nama_kategori }}</span>
                  </td>
                  <td>
                    @if($kategori->subKategori->isEmpty())
                      <span class="badge bg-label-secondary">Tidak ada sub kategori</span>
                    @else
                      <div class="d-flex flex-wrap gap-2">
                        @foreach($kategori->subKategori as $sub)
                          <span class="badge bg-label-primary">{{ $sub->nama_sub_kategori }}</span>
                        @endforeach
                      </div>
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('kategori.edit', $kategori->id) }}">
                          <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin menghapus kategori ini?')">
                            <i class="bx bx-trash me-1"></i> Hapus
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4">Tidak ada data kategori</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection