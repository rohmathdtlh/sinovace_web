@extends('main-admin')
@section('title', 'PPID')
@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif
      <h3 class="fw-bold mb-3" style="color: white">Data Layanan PPID</h3>
        <!-- Search and Filter Container -->
        <div class="d-flex align-items-center">
          <!-- Search -->
          <div class="navbar-nav align-items-left me-2" style="width: 75%;">
            <form action="{{ route('admin.ppid.index') }}" method="GET">
              <div class="nav-item divider d-flex align-items-center" style="border-radius: 20px;height: 40px;background-color: rgb(255, 255, 255, 0.1);">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <button type="submit" class="d-inline-block bg-primary rounded-circle border-0" aria-label="Search" style="padding: 0.5rem;">
                    <i class="bx bx-search fs-4 lh-0 text-white"></i>
                  </button>
                </div>
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <input
                  type="text"
                  id="search" 
                  name="search"
                  class="form-control border-0 text-white text-sm"
                  placeholder="Search..."
                  aria-label="Search..."
                  autocomplete="off"
                  style="background-color: rgba(0, 0, 0, 0);"
                  value="{{ request('search') }}"
                />
              </div>
            </form>
          </div>
          <!-- /Search -->

          <!-- Filter -->
          <div class="navbar-nav align-items-left" style="width: 25%">
            <div class="nav-item divider d-flex align-items-center" style="border-radius: 20px;height: 40px;background-color: rgb(255, 255, 255, 0.1);">
              <button class="btn d-flex align-items-center" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 20px; padding: 0; margin: 0; width: 100%;">
                <i class="bx bx-filter-alt fs-4 lh-0 text-white me-2 bg-primary rounded-circle" style="padding: 0.6rem;"></i>
                <span style="margin: 0; padding: 0;color: rgba(255, 255, 255, 0.5)">Filter by Status</span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li>
                  <label class="dropdown-item">
                    <input type="checkbox" class="status-checkbox" value="Diterima"> Diterima
                  </label>
                </li>
                <li>
                  <label class="dropdown-item">
                    <input type="checkbox" class="status-checkbox" value="Sedang Diproses"> Sedang Diproses
                  </label>
                </li>
                <li>
                  <label class="dropdown-item">
                    <input type="checkbox" class="status-checkbox" value="Ditindaklanjuti"> Ditindaklanjuti
                  </label>
                </li>
                <li>
                  <label class="dropdown-item">
                    <input type="checkbox" class="status-checkbox" value="Selesai"> Selesai
                  </label>
                </li>
                <li class="dropdown-item">
                  <button id="applyFilter" class="btn btn-primary btn-sm">Apply Filter</button>
                </li>
              </ul>
            </div>
          </div>
          <!-- /Filter -->
        </div>
        <!-- /Search and Filter Container -->
        <!-- Bordered Table -->
        <div class="divider d-flex justify-content-center align-items-center mt-0">
          <form method="GET" action="{{ route('admin.ppid.index') }}">
            <div class="d-flex align-items-center me-2">
              <label for="entriesPerPage" class="text-white me-2">Entries per page:</label>
              <select name="entries_per_page" id="entriesPerPage" class="form-select" style="width: 70px; height: 35px" onchange="this.form.submit()">
                <option value="10" {{ $entriesPerPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $entriesPerPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $entriesPerPage == 50 ? 'selected' : '' }}>50</option>
              </select>
              <input type="hidden" name="search" value="{{ $search ?? '' }}">
            </div>
          </form>
          <a href="{{ url('admin/ppid/excel') }}" class="btn rounded-pill btn-primary mx-1">Excel</a>
          <a href="{{ url('admin/ppid/pdf') }}" class="btn rounded-pill btn-secondary mx-1">PDF</a>
          <a href="{{ route('admin.ppid.create') }}" class="btn rounded-pill btn-primary mx-1">
            <i class="bx bx-plus"></i>Tambah Data
          </a>
        </div>
        <div class="card">
          <ul class="nav nav-tabs">
              <li class="nav-item">
                  <a class="nav-link {{ $jenis == 'permohonan' ? 'active' : '' }}" href="{{ route('admin.ppid.index', ['jenis' => 'permohonan']) }}">Permohonan</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ $jenis == 'keberatan' ? 'active' : '' }}" href="{{ route('admin.ppid.index', ['jenis' => 'keberatan']) }}">Keberatan</a>
              </li>
          </ul>
          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered">
                <thead>
                  <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>No. HP/WA</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Aksi</th>
                  </tr>
              </thead>              
                <tbody id="tbody">                         
                  @foreach($ppid as $item)
                    <tr>
                      <td>{{ $loop->index + $ppid->firstItem() }}</td>
                      <td>{{ $item->nama }}</td>
                      <td>{{ $item->no_hp }}</td>
                      <td>{{ $item->email }}</td>
                      <td>
                        @php
                            $badgeClass = '';
                            switch ($item->status) {
                                case 'Diterima':
                                    $badgeClass = 'bg-label-success';
                                    break;
                                case 'Sedang Diproses':
                                    $badgeClass = 'bg-label-info';
                                    break;
                                case 'Ditindaklanjuti':
                                    $badgeClass = 'bg-label-warning';
                                    break;
                                case 'Selesai':
                                    $badgeClass = 'bg-label-secondary';
                                    break;
                                default:
                                    $badgeClass = 'bg-label-success';
                                    break;
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }} me-1">{{ $item->status }}</span>
                      </td>
                      <td>
                        <a href="{{ url('admin/ppid/edit/' . $item->id) }}" class="btn btn-secondary btn-sm">
                          <i class="bx bx-edit-alt me-1"></i>
                        </a>
                        <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                          <i class="bx bx-trash me-1"></i>
                        </button>

                        <!-- Modal Bootstrap -->
                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content text-center p-4">
                              <i class="bi bi-exclamation-circle-fill text-danger" style="font-size: 85px; margin-top: -15px;margin-bottom: -10px"></i>
                              <p class="mt-0 mb-3">Apakah Anda yakin ingin menghapus data ini?</p>
                              <div class="d-flex justify-content-center gap-3 mb-2">
                                <button type="button" class="btn btn-secondary bg-primary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ url('admin/ppid/delete/' . $item->id) }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <a href="{{ url('admin/ppid/show/' . $item->id) }}" class="btn btn-dark btn-sm">Detail
                            <i class="bx bx-right-arrow-alt"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end mt-2">
              {{ $ppid->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
        <!--/ Bordered Table -->
  </div>
</div>
<style>
    .nav-tabs .nav-link {
        background-color: white;
        color: #0d6efd;
        border: 1px solid #dee2e6;
        border-bottom: none;
    }

    .nav-tabs .nav-link.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd #0d6efd white;
    }
</style>


<script>
  $(document).ready(function(){
    $('#applyFilter').on('click', function(){
      var selectedStatuses = [];

      $('.status-checkbox:checked').each(function(){
        selectedStatuses.push($(this).val());
      });

      $.ajax({
        url: "{{ route('admin.ppid.filter') }}",
        type: "GET",
        data: { statuses: selectedStatuses },
        success: function(data) {
          var filteredStatuses = data.statuses;
          var html = '';
          
          if (filteredStatuses.length > 0) {
            for (let i = 0; i < filteredStatuses.length; i++) {
              var badgeClass = '';
              switch (filteredStatuses[i].status) {
                case 'Diterima':
                  badgeClass = 'bg-label-success'; 
                  break;
                case 'Sedang Diproses':
                  badgeClass = 'bg-label-info'; 
                  break;
                case 'Ditindaklanjuti':
                  badgeClass = 'bg-label-warning'; 
                  break;
                case 'Selesai':
                  badgeClass = 'bg-label-secondary'; 
                  break;
                default:
                  badgeClass = 'bg-label-success';
              }

              html += `<tr>
                <td>${i + 1}</td>
                <td>${filteredStatuses[i].nama}</td>
                <td>${filteredStatuses[i].no_hp}</td>
                <td>${filteredStatuses[i].email ?? '-'}</td>
                <td>
                  <span class="badge ${badgeClass} me-1">${filteredStatuses[i].status}</span>
                </td>
                <td>
                  <a href="/admin/ppid/edit/${filteredStatuses[i].id}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-edit-alt me-1"></i>
                  </a>
                  <form action="/admin/ppid/delete/${filteredStatuses[i].id}" method="POST" class="d-inline">
                    @method("delete")
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                      <i class="bx bx-trash me-1"></i>
                    </button>
                  </form>
                  <a href="/admin/ppid/show/${filteredStatuses[i].id}" class="btn btn-dark btn-sm">Detail
                    <i class="bx bx-right-arrow-alt"></i>
                  </a>
                </td>
              </tr>`;
            }
          } else {
            html += '<tr><td colspan="6">Tidak Ada Data</td></tr>';
          }

          $("#tbody").html(html);
        }
      });
    });
  });
</script>

@endsection