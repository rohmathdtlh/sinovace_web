@extends('main-admin')

@section('title', 'Daftar Tanggapan - ' . (isset($kategori) && $kategori ? $kategori->nama_kategori : 'Semua'))

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold py-3 mb-4 text-white">
        {{ isset($kategori) && $kategori ? $kategori->nama_kategori : 'Semua Laporan' }}
      </h4>
    </div>

    <div class="card">
      <div class="card-body p-0">
        @forelse ($lapors as $lapor)
          @php
            $status = strtolower($lapor->status);
            $badgeClass = match($status) {
              'selesai' => 'success',
              'diproses' => 'warning',
              'pending' => 'secondary',
              'ditutup' => 'danger',
              default => 'light',
            };
          @endphp

          <div class="p-4 border-bottom" id="pengaduan-{{ $lapor->id }}">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <h5 class="mb-1">{{ $lapor->judul }}</h5>
                <small class="text-muted">
                  Oleh: {{ $lapor->user->name }} • 
                  {{ $lapor->created_at->format('d M Y H:i') }} • 
                  <span class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }}">
                    {{ ucfirst($lapor->status) }}
                  </span>
                </small>
              </div>
              @if($status !== 'selesai' && $status !== 'ditutup')
                <div class="dropdown">
                  @if($lapor->tanggapans->isEmpty() || $lapor->tanggapans->first()->user_id === auth()->id())
                  <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                      <i class="bx bx-cog"></i>
                  </button>
              @endif
              
                  <ul class="dropdown-menu">
                    @php
                  $bolehTanggapanBaru = in_array($lapor->status, ['pending', 'diproses']) && $lapor->tanggapans->isEmpty();
                @endphp

                @if($bolehTanggapanBaru)
                  <li>
                      <button class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#formTanggapan{{ $lapor->id }}">
                          <i class="bx bx-edit me-1"></i> Beri Tanggapan
                      </button>
                  </li>
                @endif


                    @if($status === 'diproses')
                      <li>
                        <form action="{{ route('admin.lapor.update', $lapor->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="status" value="selesai">
                          <button type="submit" class="dropdown-item">
                            <i class="bx bx-check-circle me-1"></i> Tandai Selesai
                          </button>
                        </form>
                      </li>
                    @endif
                  </ul>
                </div>
              @endif
            </div>

            <div class="mb-3">
                <p class="mb-2" style="white-space: pre-wrap;">{{ $lapor->deskripsi }}</p>
                @if($lapor->lampiranPengaduan->isNotEmpty())
                <div class="mt-3">
                    <h6 class="mb-2">Lampiran:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($lapor->lampiranPengaduan as $lampiran)
                        <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                            <i class="bx bx-paperclip me-1"></i> Lampiran
                        </a>
                        @endforeach                
                    </div>
                </div>
                @endif
            </div>

            @if($status !== 'selesai' && $status !== 'ditutup' && $lapor->tanggapans->isEmpty())
              <div class="collapse mb-4" id="formTanggapan{{ $lapor->id }}">
                <div class="card card-body bg-light-subtle">
                  <form action="{{ route('admin.tanggapan.store', $lapor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Tanggapan</label>
                      <textarea name="tanggapan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Lampiran (Opsional)</label>
                      <input type="file" name="file" class="form-control">
                      <small class="text-muted">Format: pdf, jpg, jpeg, png, doc, docx (Max: 2MB)</small>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                      <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#formTanggapan{{ $lapor->id }}">Batal</button>
                      <button type="submit" class="btn btn-sm btn-dark">Kirim Tanggapan</button>
                    </div>
                  </form>
                </div>
              </div>
            @endif

            @if($lapor->tanggapans->isNotEmpty())
              <div class="mt-4">
                <h6 class="fw-bold mb-3">Riwayat Diskusi</h6>
                @foreach($lapor->tanggapans as $tanggapan)
                  <div class="mb-4 ps-3 border-start border-2 border-dark">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="d-flex align-items-center">
                        <div class="bg-dark text-white rounded-circle p-2 me-2" style="width:32px;height:32px;line-height:1;">
                          <i class="bx bx-user"></i>
                        </div>
                        <strong>Admin</strong>
                      </div>
                      <small class="text-muted">{{ $tanggapan->created_at->format('d M Y H:i') }}</small>
                    </div>
                    <div class="mb-2">
                     <p class="mb-2" style="white-space: pre-wrap;">{{ $tanggapan->tanggapan }}</p>
                      @if($tanggapan->file_path)
                        <a href="{{ Storage::url($tanggapan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                          <i class="bx bx-paperclip me-1"></i> Lampiran
                        </a>
                      @endif
                    </div>
                    @if($tanggapan->user_id === auth()->id())
                    <div class="d-flex gap-2">
                      <a href="{{ route('admin.tanggapan.edit', $tanggapan->id) }}" class="btn btn-sm btn-outline-dark"><i class="bx bx-edit"></i></a>
                      <form action="{{ route('admin.tanggapan.destroy', $tanggapan->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
                      </form>
                    </div>
                    @endif
                    
                    @foreach($tanggapan->komentars as $komentar)
                      <div class="mt-3 ms-3 ps-3 border-start border-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <div class="d-flex align-items-center">
                            <div class="{{ $komentar->user->role === 'admin' ? 'bg-dark' : 'bg-secondary' }} text-white rounded-circle p-2 me-2" style="width:32px;height:32px;line-height:1;">
                              <i class="bx bx-user"></i>
                            </div>
                            <div>
                              <strong>{{ $komentar->user->name }}</strong>
                              <small class="text-muted">({{ $komentar->user->role === 'admin' ? 'Admin' : 'User' }})</small>
                            </div>
                          </div>
                          <small class="text-muted">{{ $komentar->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="mb-2">
                          <p class="mb-2" style="white-space: pre-wrap;">{{ $komentar->komentar }}</p>
                          @if($komentar->file_path)
                            <a href="{{ Storage::url($komentar->file_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                              <i class="bx bx-paperclip me-1"></i> Lampiran
                            </a>
                          @endif

                        </div>

                        @php 
                          $adminLogin = auth()->id();
                          $hasAdminReply = false;
                          foreach($tanggapan->komentars as $k) {
                            if($k->parent_id == $komentar->id && $k->user->role === 'admin') {
                              $hasAdminReply = true;
                              break;
                            }
                          }
                        @endphp

                        @if($komentar->user->role === 'admin')
                        <div class="d-flex gap-2">
                          @if($lapor->status !== 'ditutup')
                            <a href="{{ route('admin.komentar.edit', $komentar->id) }}" class="btn btn-sm btn-outline-dark"><i class="bx bx-edit"></i></a>
                          @endif
                          <form action="{{ route('admin.komentar.destroy', $komentar->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
                          </form>
                        </div>
                        @elseif($lapor->status !== 'selesai' && $lapor->status !== 'ditutup' && $tanggapan->user_id === $adminLogin && !$hasAdminReply)
                          <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#formBalasan{{ $komentar->id }}"><i class="bx bx-reply me-1"></i> Balas</button>
                          <div class="collapse mt-2" id="formBalasan{{ $komentar->id }}">
                            <form action="{{ route('admin.komentar.store', $tanggapan->id) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                              <div class="mb-2">
                                <textarea name="komentar" class="form-control" rows="2" placeholder="Tulis balasan..." required></textarea>
                              </div>
                              <div class="mb-2">
                                <input type="file" name="lampiran" class="form-control form-control-sm">
                                <small class="text-muted">Format: pdf, jpg, jpeg, png, doc, docx (Max: 2MB)</small>
                              </div>
                              <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#formBalasan{{ $komentar->id }}">Batal</button>
                                <button type="submit" class="btn btn-sm btn-dark">Kirim</button>
                              </div>
                            </form>
                          </div>
                        @endif
                      </div>
                    @endforeach

                  </div>
                @endforeach
              </div>
            @endif
          </div>
        @empty
          <div class="text-center py-5">
            <i class="bx bx-message-alt-error bx-lg text-muted mb-3"></i>
            <p class="text-muted">Belum ada laporan yang perlu ditanggapi</p>
          @if(isset($kategori) && $kategori)
            <a href="{{ route('admin.tanggapan.index') }}" class="btn btn-sm btn-outline-dark">
              <i class="bx bx-arrow-back me-1"></i> Lihat Semua Laporan
            </a>
          @endif
          </div>
        @endforelse

        @if($lapors->hasPages())
          <div class="d-flex justify-content-center p-4">
            {{ $lapors->links('pagination::bootstrap-5') }}
          </div>
        @endif

      </div>
    </div>
  </div>
</div>

<style>
  .border-1 { border-width: 1px !important; }
  .border-2 { border-width: 2px !important; }
  .bg-light-subtle { background-color: #f8f9fa; }
  .dropdown-toggle::after { display: none; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
  .card-body .dropdown-menu { position: absolute; }
  .text-white { color: #fff !important; }
</style>
@section('scripts')
@parent
@if(request()->has('highlight'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const element = document.getElementById('pengaduan-{{ request('highlight') }}');
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.classList.add('highlight-pengaduan');
    }
});
</script>
<style>
  @keyframes highlight {
    from {
      background-color: rgb(167, 216, 232);
    }
    to {
      background-color: transparent;
    }
  }

  .highlight-pengaduan {
    animation: highlight 2s ease-out;
    border-left: 4px solid #3490dc;
    padding-left: 10px;
  }
</style>
@endif
@endsection
@endsection