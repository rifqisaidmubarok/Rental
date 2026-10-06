@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Login Log</h1>
        <p>Riwayat aktivitas login pengguna sistem.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h3>Filter Login Log</h3>
    </div>

    <form
        action="{{ route('login-logs.index') }}"
        method="GET"
        class="filter-form"
        style="padding: 20px;"
    >

        <div class="form-group">

            <label for="date_from">
                Dari Tanggal
            </label>

            <input
                type="date"
                id="date_from"
                name="date_from"
                value="{{ request('date_from') }}"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label for="date_to">
                Sampai Tanggal
            </label>

            <input
                type="date"
                id="date_to"
                name="date_to"
                value="{{ request('date_to') }}"
                class="form-control"
            >

        </div>

        <div class="form-group">

            <label for="user_id">
                Pengguna
            </label>

            <select
                id="user_id"
                name="user_id"
                class="form-control"
            >

                <option value="">
                    Semua Pengguna
                </option>

                @foreach($users as $user)

                    <option
                        value="{{ $user->id }}"
                        {{ request('user_id') == $user->id ? 'selected' : '' }}
                    >
                        {{ $user->name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                class="form-control"
            >

                <option value="">
                    Semua Status
                </option>

                <option
                    value="berhasil"
                    {{ request('status') === 'berhasil' ? 'selected' : '' }}
                >
                    Berhasil
                </option>

                <option
                    value="gagal"
                    {{ request('status') === 'gagal' ? 'selected' : '' }}
                >
                    Gagal
                </option>

            </select>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Filter
            </button>

            <a
                href="{{ route('login-logs.index') }}"
                class="btn btn-secondary"
            >
                Reset
            </a>

        </div>

    </form>

</div>


<div class="card" style="margin-top: 20px;">

    <div class="card-header">
        <h3>Riwayat Login</h3>
    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Waktu Login</th>
                    <th>IP Address</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($logs as $log)

                    <tr>

                        <td>
                            {{ $logs->firstItem() + $loop->index }}
                        </td>

                        <td>
                            @if($log->user)
                                <strong>{{ $log->user->name }}</strong>
                            @else
                                <span style="color:#777;">
                                    Tidak diketahui
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $log->user->email ?? '-' }}
                        </td>

                        <td>
                            {{ $log->login_time->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ $log->ip_address ?? '-' }}
                        </td>

                        <td>

                            @if($log->status === 'berhasil')

                                <span class="badge badge-success">
                                    Berhasil
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Gagal
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data Login Log.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div style="padding: 20px;">
        {{ $logs->links() }}
    </div>

</div>

@endsection