@extends('layouts.app')

@section('title', 'Laporan Rental')

@section('content')

<div class="page-header">

    <div>

        <h1>Laporan Rental</h1>

        <p>
            Laporan transaksi rental kendaraan
        </p>

    </div>

</div>


{{-- =========================================================
    FILTER
========================================================= --}}

<div class="card">

    <form
        method="GET"
        action="{{ route('reports.rentals') }}"
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

            <label>Status Rental</label>

            <select name="status">

                <option value="">
                    Semua Status
                </option>

                @foreach([
                    'menunggu',
                    'disewa',
                    'selesai',
                    'terlambat',
                    'dibatalkan'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        @selected(request('status') === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                🔍 Filter
            </button>


            <a
                href="{{ route('reports.rentals') }}"
                class="btn btn-secondary"
            >
                Reset
            </a>

        </div>

    </form>

</div>


{{-- =========================================================
    STATISTIK
========================================================= --}}

<div class="stats-grid">


    {{-- SUBTOTAL --}}

    <div class="stat-card">

        <div>

            <span>Total Subtotal</span>

            <strong>
                Rp {{ number_format(
                    $totalSubtotal,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>

    </div>


    {{-- DENDA --}}

    <div class="stat-card">

        <div>

            <span>Total Denda</span>

            <strong>
                Rp {{ number_format(
                    $totalLateFee,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>

    </div>


    {{-- TOTAL RENTAL --}}

    <div class="stat-card">

        <div>

            <span>Total Nilai Rental</span>

            <strong>
                Rp {{ number_format(
                    $totalRevenue,
                    0,
                    ',',
                    '.'
                ) }}
            </strong>

        </div>

    </div>


    {{-- SUDAH DIBAYAR --}}

    <div class="stat-card">

        <div>

            <span>Total Sudah Dibayar</span>

            <strong style="color:#16a34a;">

                Rp {{ number_format(
                    $totalPaid,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>

    </div>


    {{-- BELUM DIBAYAR --}}

    <div class="stat-card">

        <div>

            <span>Total Belum Dibayar</span>

            <strong style="color:#dc2626;">

                Rp {{ number_format(
                    $totalOutstanding,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>

    </div>


</div>


{{-- =========================================================
    KETERANGAN SINKRONISASI
========================================================= --}}

<div
    class="card"
    style="
        margin-bottom:20px;
        background:#f8fafc;
    "
>

    <div style="
        display:flex;
        gap:10px;
        align-items:flex-start;
    ">

        <div style="
            font-size:20px;
        ">
            ℹ️
        </div>

        <div>

            <strong>
                Informasi Pembayaran
            </strong>

            <p style="
                margin:5px 0 0;
                color:#64748b;
                font-size:13px;
            ">

                Total sudah dibayar pada laporan ini adalah
                pembayaran berstatus
                <strong>lunas</strong>
                yang terhubung dengan rental yang ditampilkan.

                Total belum dibayar adalah selisih antara
                nilai rental dan pembayaran yang sudah diterima.

            </p>

        </div>

    </div>

</div>


{{-- =========================================================
    TABEL RENTAL
========================================================= --}}

<div class="card">

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Kode Rental</th>

                    <th>Customer</th>

                    <th>Kendaraan</th>

                    <th>Tanggal Rental</th>

                    <th>Tanggal Kembali</th>

                    <th>Total Rental</th>

                    <th>Sudah Dibayar</th>

                    <th>Sisa</th>

                    <th>Status Pembayaran</th>

                    <th>Status Rental</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                @forelse($rentals as $rental)


                    @php

                        $paidAmount = $rental->payments
                            ->where('status', 'lunas')
                            ->sum('amount');

                        $remainingAmount = max(
                            0,
                            $rental->total - $paidAmount
                        );

                    @endphp


                    <tr>


                        {{-- NO --}}

                        <td>

                            {{
                                $rentals->firstItem()
                                + $loop->index
                            }}

                        </td>


                        {{-- KODE --}}

                        <td>

                            <strong>
                                {{ $rental->rental_code }}
                            </strong>

                        </td>


                        {{-- CUSTOMER --}}

                        <td>

                            {{ $rental->customer->name ?? '-' }}

                        </td>


                        {{-- KENDARAAN --}}

                        <td>

                            @forelse(
                                $rental->details
                                as $detail
                            )

                                <div style="
                                    margin-bottom:4px;
                                ">

                                    {{ $detail->vehicle->name ?? '-' }}

                                </div>

                            @empty

                                -

                            @endforelse

                        </td>


                        {{-- TANGGAL RENTAL --}}

                        <td>

                            {{
                                \Carbon\Carbon::parse(
                                    $rental->rental_date
                                )->format('d/m/Y')
                            }}

                        </td>


                        {{-- TANGGAL KEMBALI --}}

                        <td>

                            @if(
                                $rental->actual_return_date
                            )

                                {{
                                    \Carbon\Carbon::parse(
                                        $rental->actual_return_date
                                    )->format('d/m/Y')
                                }}

                            @else

                                {{
                                    \Carbon\Carbon::parse(
                                        $rental->return_date
                                    )->format('d/m/Y')
                                }}

                            @endif

                        </td>


                        {{-- TOTAL RENTAL --}}

                        <td>

                            <strong>

                                Rp {{
                                    number_format(
                                        $rental->total,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </strong>

                        </td>


                        {{-- SUDAH DIBAYAR --}}

                        <td>

                            <span style="
                                color:#16a34a;
                                font-weight:600;
                            ">

                                Rp {{
                                    number_format(
                                        $paidAmount,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </span>

                        </td>


                        {{-- SISA --}}

                        <td>

                            @if($remainingAmount > 0)

                                <span style="
                                    color:#dc2626;
                                    font-weight:600;
                                ">

                                    Rp {{
                                        number_format(
                                            $remainingAmount,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </span>

                            @else

                                <span style="
                                    color:#16a34a;
                                    font-weight:600;
                                ">

                                    Rp 0

                                </span>

                            @endif

                        </td>


                        {{-- STATUS PEMBAYARAN --}}

                        <td>

                            @if($paidAmount >= $rental->total)

                                <span
                                    class="badge badge-success"
                                >
                                    Lunas
                                </span>

                            @elseif($paidAmount > 0)

                                <span
                                    class="badge badge-warning"
                                >
                                    Sebagian
                                </span>

                            @else

                                <span
                                    class="badge badge-danger"
                                >
                                    Belum Dibayar
                                </span>

                            @endif

                        </td>


                        {{-- STATUS RENTAL --}}

                        <td>

                            <span
                                class="badge badge-{{ $rental->status }}"
                            >

                                {{ ucfirst(
                                    $rental->status
                                ) }}

                            </span>

                        </td>


                        {{-- DETAIL --}}

                        <td>

                            <a
                                href="{{
                                    route(
                                        'rentals.show',
                                        $rental
                                    )
                                }}"
                                class="btn btn-sm btn-primary"
                            >
                                Detail
                            </a>

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="12"
                            class="text-center"
                        >

                            Data rental tidak ditemukan.

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