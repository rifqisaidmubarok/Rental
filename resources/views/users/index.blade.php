@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Pengguna</h1>
        <p>Kelola akun pengguna sistem rental kendaraan.</p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        + Tambah Pengguna
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3>Daftar Pengguna</h3>
    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role === 'admin')

                                <span class="badge badge-danger">
                                    Admin
                                </span>

                            @else

                                <span class="badge badge-primary">
                                    Petugas
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <td>

                            <div style="display:flex; gap:8px;">

                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                @if($user->id !== auth()->id())

                                    <form
                                        action="{{ route('users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada pengguna.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div style="padding: 20px;">
        {{ $users->links() }}
    </div>

</div>

@endsection