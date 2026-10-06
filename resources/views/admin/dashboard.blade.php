@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="page-header">
    <div>
        <h1>Dashboard Admin</h1>
        <p>Ringkasan sistem rental kendaraan</p>
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
            <span>Kendaraan Tersedia</span>
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
            <span>Total Customer</span>
            <strong>{{ $totalCustomers }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📋</div>
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


<div class="dashboard-grid">

    <div class="card">

        <div class="card-header">
            <h3>Rental Terbaru</h3>

            <a
                href="{{ route('rentals.index') }}"
                class="btn btn-primary"
                 style="color: white;"
            >
                Lihat Semua
            </a>
        </div>

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentRentals as $rental)

                        <tr>

                            <td>
                                <a
                                    href="{{ route('rentals.show', $rental) }}"
                                >
                                    {{ $rental->rental_code }}
                                </a>
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

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada transaksi rental.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <div class="card">

        <div class="card-header">
            <h3>Pembayaran Terbaru</h3>

            <a
                href="{{ route('reports.payments') }}"
                class="btn btn-primary"
                 style="color: white;"
            >
                Laporan
            </a>
        </div>

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Rental</th>
                        <th>Customer</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentPayments as $payment)

                        <tr>

                            <td>
                                {{ $payment->rental->rental_code ?? '-' }}
                            </td>

                            <td>
                                {{ $payment->rental->customer->name ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ strtoupper($payment->payment_method) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada pembayaran.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="card">

    <div class="card-header">
        <h3>Aktivitas Terbaru</h3>

        <a
            href="{{ route('activity-logs.index') }}"
            class="btn btn-secondary"
        >
            Activity Log
        </a>
    </div>

    <div class="table-wrapper">

        <table class="data-table">

            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($recentActivities as $activity)

                    <tr>

                        <td>
                            {{ $activity->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            {{ $activity->user->name ?? 'System' }}
                        </td>

                        <td>
                            {{ $activity->activity }}
                        </td>

                        <td>
                            {{ $activity->description ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada aktivitas.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="revenue-card">

    <div>
        <span>Total Pendapatan</span>

        <h2>
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </h2>
    </div>

    <div>
        <a
            href="{{ route('reports.payments') }}"
            class="btn btn-success"
        >
            Lihat Laporan Pembayaran
        </a>
    </div>

</div>

@endsection