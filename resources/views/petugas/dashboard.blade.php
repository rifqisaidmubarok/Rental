@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<div class="page-header">
    <div>
        <h1>Dashboard Petugas</h1>
        <p>Informasi operasional rental kendaraan</p>
    </div>
</div>


<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">🚗</div>
        <div>
            <span>Total Kendaraan</span>
            <strong>{{ $totalVehicles }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div>
            <span>Tersedia</span>
            <strong>{{ $availableVehicles }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🔑</div>
        <div>
            <span>Sedang Disewa</span>
            <strong>{{ $rentedVehicles }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🔧</div>
        <div>
            <span>Servis</span>
            <strong>{{ $serviceVehicles }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div>
            <span>Customer</span>
            <strong>{{ $totalCustomers }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div>
            <span>Total Rental</span>
            <strong>{{ $totalRentals }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div>
            <span>Rental Aktif</span>
            <strong>{{ $activeRentals }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⚠️</div>
        <div>
            <span>Terlambat</span>
            <strong>{{ $lateRentals }}</strong>
        </div>
    </div>

</div>


<div class="card">

    <div class="card-header">

        <h3>Rental Terbaru</h3>

       <a
    href="{{ route('rentals.index') }}"
    class="btn btn-primary"
    style="color: white;"
>
    Kelola Rental
</a>
    </div>

    <div class="table-wrapper">

        <table class="data-table">

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Tanggal Rental</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($recentRentals as $rental)

                    <tr>

                        <td>
                            {{ $rental->rental_code }}
                        </td>

                        <td>
                            {{ $rental->customer->name ?? '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}
                        </td>

                        <td>
                            Rp {{ number_format($rental->total, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="badge badge-{{ $rental->status }}">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </td>

                        <td>
                            <a
                                href="{{ route('rentals.show', $rental) }}"
                                class="btn btn-sm btn-primary"
                            >
                                Detail
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada rental.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="revenue-card">

    <div>
        <span>Total Pembayaran Lunas</span>

        <h2>
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h2>
    </div>

    <div>

        <a
            href="{{ route('reports.payments') }}"
            class="btn btn-success"
        >
            Laporan Pembayaran
        </a>

    </div>

</div>

@endsection