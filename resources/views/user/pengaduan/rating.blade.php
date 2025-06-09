@extends('main-user')

@section('title', 'Beri Rating Pengaduan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Beri Rating Pengaduan #{{ $pengaduan->id }}</h5>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h6>Detail Pengaduan:</h6>
                        <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
                        <p><strong>Admin Penanggung Jawab:</strong> {{ $admin->name ?? 'Tidak diketahui' }}</p>
                    </div>

                    <form method="POST" action="{{ route('user.pengaduan.rating.store', $pengaduan->id) }}">
                        @csrf
                        <input type="hidden" name="admin_id" value="{{ $admin->id ?? '' }}">

                        <div class="form-group">
                            <label for="rating" class="font-weight-bold">Seberapa puas Anda dengan penanganan pengaduan ini?</label>
                            <div class="rating-container text-center my-4">
                                <div class="rating-stars d-flex justify-content-center flex-row-reverse">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}" title="{{ $i }} bintang">&#9733;</label>
                                    @endfor
                                </div>
                                <div class="rating-labels mt-2">
                                    <span class="text-muted">Tidak puas</span>
                                    <span class="text-muted ml-auto">Sangat puas</span>
                                </div>
                            </div>
                            @error('rating')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <i class="fas fa-star mr-2"></i> Kirim Penilaian
                            </button>
                            <a href="{{ route('user.pengaduan.index') }}" 
                               class="btn btn-outline-secondary btn-block mt-2">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .rating-stars {
        direction: rtl;
        font-size: 2rem;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars label {
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
        transition: color 0.2s;
    }

    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107;
    }
</style>
@endsection
