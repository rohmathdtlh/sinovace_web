@extends('main-admin')

@section('title', 'Akun User')

@section('content')
<div class="content">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4">Daftar Akun User</h4>

                        {{-- @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif --}}

                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($akun_user as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $akun_user->firstItem() - 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <form action="{{ route('admin.akun_user.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                        <i class="bx bx-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada akun user.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $akun_user->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection
