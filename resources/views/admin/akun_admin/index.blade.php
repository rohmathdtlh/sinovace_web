@extends('main-admin')
@section('title', 'Akun Admin')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-0">
                        <h4>Daftar Admin</h4>
                        <a href="{{ route('admin.registration') }}" class="btn rounded-pill btn-sm btn-primary">
                          <i class="bx bx-plus"></i> Tambah Akun
                        </a>
                      </div>                      
                      <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Nama</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Rating</th>
                              <th>Aksi</th> <!-- Tambah kolom aksi -->
                            </tr>
                          </thead>                          
                          <tbody id="tbody">                         
                            @foreach($akun_admin as $item)
                              <tr>
                                <td>{{ $loop->iteration + $akun_admin->firstItem() - 1 }}</td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->email }}</td>
                                <td>
                                  @if($item->kategori_id)
                                    <span class="badge bg-info text-start" style="white-space: normal;">
                                      Operator<br>
                                      <small class="text-white">{{ $item->kategori->nama_kategori ?? '-' }}</small>
                                    </span>
                                  @else
                                    <span class="badge bg-primary">Admin</span>
                                  @endif
                                </td>
                                <td>
                                  @if($item->ratings_avg_rating)
                                    ⭐ {{ number_format($item->ratings_avg_rating, 1) }} / 5 <br>
                                    <small class="text-muted">dari {{ $item->ratings_count }} pengguna</small>
                                  @else
                                    <span class="text-muted">Belum ada rating</span>
                                  @endif
                                </td>
                                <td>
                                  @if(auth()->user()->kategori_id === null && auth()->user()->id !== $item->id)
                                    <form action="{{ route('admin.akun_admin.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                      @csrf
                                      @method('DELETE')
                                      <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="bx bx-trash"></i>
                                      </button>
                                    </form>
                                  @else
                                    <span class="text-muted">-</span>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="mt-2">
                        {{ $akun_admin->links() }}
                      </div>
                    </div>
                  </div>
                  <!--/ Bordered Table -->
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>

@endsection
