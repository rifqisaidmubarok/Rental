@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Tambah Pengguna</h1>
        <p>Tambahkan akun pengguna baru.</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h3>Form Pengguna</h3>
    </div>

    <form
        action="{{ route('users.store') }}"
        method="POST"
        style="padding: 25px;"
    >

        @csrf

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
                value="{{ old('name') }}"
                class="form-control"
                placeholder="Masukkan nama pengguna"
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
                value="{{ old('email') }}"
                class="form-control"
                placeholder="contoh@email.com"
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

                <option value="">
                    -- Pilih Role --
                </option>

                <option
                    value="admin"
                    {{ old('role') === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="petugas"
                    {{ old('role') === 'petugas' ? 'selected' : '' }}
                >
                    Petugas
                </option>

            </select>

        </div>

        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Minimal 6 karakter"
                required
            >

        </div>

        <div class="form-group">

            <label for="password_confirmation">
                Konfirmasi Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required
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
                Simpan Pengguna
            </button>

        </div>

    </form>

</div>

@endsection