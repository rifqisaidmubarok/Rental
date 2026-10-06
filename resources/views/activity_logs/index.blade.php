@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')

<div class="page-header">
    <div>
        <h1>Activity Log</h1>
        <p>Riwayat aktivitas Admin dan Petugas</p>
    </div>
</div>

<div class="card">

    <form
        method="GET"
        action="{{ route('activity-logs.index') }}"
        class="filter-form"
    >

        <div class="form-group">
            <label>Dari Tanggal</label>

            <input
                type="date"
                name="date_from"
                value="{{ request('date_from') }}"
            >
        </div>

        <div class="form-group">
            <label>Sampai Tanggal</label>

            <input
                type="date"
                name="date_to"
                value="{{ request('date_to') }}"
            >
        </div>

        <div class="form-group">
            <label>Aktivitas</label>

            <input
                type="text"
                name="activity"
                placeholder="Cari aktivitas..."
                value="{{ request('activity') }}"
            >
        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-primary"
            >
                🔍 Filter
            </button>

            <a
                href="{{ route('activity-logs.index') }}"
                class="btn btn-secondary"
            >
                Reset
            </a>
        </div>

    </form>

</div>


<div class="card">

    <div class="table-wrapper">

        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                </tr>
            </thead>

            <tbody>

                @forelse($logs as $log)

                    <tr>

                        <td>
                            {{ $logs->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>

                        <td>
                            {{ $log->user->name ?? 'System' }}

                            @if($log->user)
                                <br>
                                <small>
                                    {{ ucfirst($log->user->role) }}
                                </small>
                            @endif
                        </td>

                        <td>
                            <strong>
                                {{ $log->activity }}
                            </strong>
                        </td>

                        <td>
                            {{ $log->description ?? '-' }}
                        </td>

                        <td>
                            {{ $log->ip_address ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada activity log.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $logs->links() }}
    </div>

</div>

@endsection