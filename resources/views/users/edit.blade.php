@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Edit Pengguna</h1>
        <p>Perbarui data akun pengguna.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h3>Edit: {{ $user->name }}</h3>
    </div>

    <form
        action="{{ route('users.update', $user) }}"
        method="POST"
        style="padding: 25px;"
    >

        @csrf
        @method('PUT')

        @if($errors->any())

            <div class="alert alert-danger">

                <ul style="margin:0; padding-left:20px;">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="form-group">

            <label for="name">
                Nama Pengguna
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label for="role">
                Role
            </label>

            <select
                id="role"
                name="role"
                class="form-control"
                required
            >

                <option
                    value="admin"
                    {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="petugas"
                    {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}
                >
                    Petugas
                </option>

            </select>

        </div>

        <div class="form-group">

            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Kosongkan jika tidak ingin mengubah password"
            >

            <small style="color:#777;">
                Kosongkan jika password tidak ingin diubah.
            </small>

        </div>

        <div class="form-group">

            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password baru"
            >

        </div>

        <div class="form-actions">

            <a
                href="{{ route('users.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection