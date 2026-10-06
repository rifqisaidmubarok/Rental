@extends('layouts.app')

@section('title', 'Transaksi Rental')
@section('page-title', 'Transaksi Rental')

@section('content')

<div class="content-card">

    <div class="card-header-custom">

        <div>
            <h3>Transaksi Rental</h3>
            <p>Daftar transaksi penyewaan kendaraan</p>
        </div>

        <a
            href="{{ route('rentals.create') }}"
            class="btn btn-primary"
        >
            + Rental Baru
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

    <form
        method="GET"
        action="{{ route('rentals.index') }}"
        class="search-form"
    >

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Cari kode rental atau nama customer..."
        >

        <button
            type="submit"
            class="btn btn-secondary"
        >
            Cari
        </button>

        @if(request('search'))
            <a
                href="{{ route('rentals.index') }}"
                class="btn btn-light"
            >
                Reset
            </a>
        @endif

    </form>

    <div class="table-responsive">

        <table class="table-custom">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kode Rental</th>
                    <th>Customer</th>
                    <th>Tanggal Rental</th>
                    <th>Tanggal Kembali</th>
                    <th>Kendaraan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($rentals as $rental)

                    <tr>

                        <td>
                            {{ $rentals->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <strong>
                                {{ $rental->rental_code }}
                            </strong>
                        </td>

                        <td>
                            {{ $rental->customer->name }}
                        </td>

                        <td>
                            {{ $rental->rental_date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $rental->return_date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $rental->details->count() }} kendaraan
                        </td>

                        <td>
                            Rp {{ number_format($rental->total, 0, ',', '.') }}
                        </td>

                        <td>

                            @if($rental->status === 'disewa')

                                <span class="badge badge-blue">
                                    Disewa
                                </span>

                            @elseif($rental->status === 'selesai')

                                <span class="badge badge-green">
                                    Selesai
                                </span>

                            @elseif($rental->status === 'terlambat')

                                <span class="badge badge-red">
                                    Terlambat
                                </span>

                            @elseif($rental->status === 'dibatalkan')

                                <span class="badge badge-gray">
                                    Dibatalkan
                                </span>

                            @else

                                <span class="badge badge-yellow">
                                    {{ ucfirst($rental->status) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('rentals.show', $rental) }}"
                                class="btn btn-info btn-sm"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center"
                        >
                            Belum ada transaksi rental.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $rentals->links() }}
    </div>

</div>

@endsection

@push('styles')
<style>

    .content-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .card-header-custom h3 {
        margin: 0 0 5px;
    }

    .card-header-custom p {
        margin: 0;
        color: #777;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .search-form .form-control {
        flex: 1;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th,
    .table-custom td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
        vertical-align: middle;
    }

    .table-custom th {
        background: #f8f9fa;
    }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #374151;
        color: white;
    }

    .btn-light {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-info {
        background: #0891b2;
        color: white;
    }

    .btn-sm {
        padding: 7px 10px;
        font-size: 13px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-green {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #a16207;
    }

    .badge-gray {
        background: #e5e7eb;
        color: #374151;
    }

    .text-center {
        text-align: center !important;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

</style>
@endpush