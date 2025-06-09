@extends('main-admin')
@section('title', 'Notifikasi')
@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Notifikasi Pengajuan Baru</h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="container mt-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Semua Notifikasi</h2>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.notifications.read') }}" class="btn btn-primary">
                                    Tandai Sudah Dibaca
                                </a>
                                <a href="{{ route('admin.notifications.deleteRead') }}" class="btn btn-danger">
                                    Hapus yang Sudah Dibaca
                                </a>
                            </div>
                        </div>
                        
                        
                        <!-- Kelompokkan Notifikasi Berdasarkan Tanggal -->
                        @php
                            $notifications = $notifications->groupBy(function ($notification) {
                                return $notification->created_at->format('d M Y');
                            });
                        @endphp
                        <!-- Loop Tanggal -->
                        @forelse ($notifications as $date => $group)
                            <h5 class="mt-2 text-primary">{{ $date }}</h5>
                                <!-- Loop Notifikasi -->
                                @foreach ($group as $notification)
                                    <div class="notification-item {{ $notification->read_at ? 'read' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <!-- Icon -->
                                            <div class="icon text-primary me-3">
                                                @if (isset($notification->data['icon']))
                                                    {!! $notification->data['icon'] !!}
                                                @else
                                                    📄 <!-- Default Icon -->
                                                @endif
                                            </div>
                                            <!-- Konten Notifikasi -->
                                            <div>
                                                <strong>{{ $notification->data['title'] ?? 'Notifikasi' }}</strong>
                                                <p class="mb-0">{{ $notification->data['message'] }}</p>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $notification->created_at->format('H:i') }}</small>
                                    </div>
                                @endforeach
                        @empty
                            <!-- Jika Tidak Ada Notifikasi -->
                            <p class="text-muted">Belum ada notifikasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.notification-item {
        background-color: #f3f4fe;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eaeaea;
    }
    .notification-item .icon {
        font-size: 20px;
        margin-right: 10px;
    }
    .notification-item.read {
        background-color: #e2e2e2; /* Warna untuk notifikasi yang sudah dibaca */
    }
</style>
@endsection
