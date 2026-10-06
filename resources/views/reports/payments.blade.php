@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')

<div class="page-header">

    <div>

        <h1>Laporan Pembayaran</h1>

        <p>
            Laporan transaksi pembayaran rental
        </p>

    </div>

</div>


{{-- =========================================================
    FILTER
========================================================= --}}

<div class="card">

    <form
        method="GET"
        action="{{ route('reports.payments') }}"
        class="filter-form"
    >

        <div class="form-group">

            <label>Dari Tanggal Pembayaran</label>

            <input
                type="date"
                name="date_from"
                value="{{ request('date_from') }}"
            >

        </div>


        <div class="form-group">

            <label>Sampai Tanggal Pembayaran</label>

            <input
                type="date"
                name="date_to"
                value="{{ request('date_to') }}"
            >

        </div>


        <div class="form-group">

            <label>Metode</label>

            <select name="payment_method">

                <option value="">
                    Semua Metode
                </option>

                <option
                    value="cash"
                    @selected(
                        request('payment_method')
                        === 'cash'
                    )
                >
                    Cash
                </option>

                <option
                    value="transfer"
                    @selected(
                        request('payment_method')
                        === 'transfer'
                    )
                >
                    Transfer
                </option>

                <option
                    value="qris"
                    @selected(
                        request('payment_method')
                        === 'qris'
                    )
                >
                    QRIS
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>Status</label>

            <select name="status">

                <option value="">
                    Semua Status
                </option>

                <option
                    value="lunas"
                    @selected(
                        request('status')
                        === 'lunas'
                    )
                >
                    Lunas
                </option>

                <option
                    value="pending"
                    @selected(
                        request('status')
                        === 'pending'
                    )
                >
                    Pending
                </option>

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
                href="{{ route('reports.payments') }}"
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


    {{-- TOTAL LUNAS --}}

    <div class="stat-card">

        <div class="stat-icon">
            💰
        </div>

        <div>

            <span>
                Total Pembayaran Lunas
            </span>

            <strong style="color:#16a34a;">

                Rp {{
                    number_format(
                        $totalPayment,
                        0,
                        ',',
                        '.'
                    )
                }}

            </strong>

        </div>

    </div>


    {{-- TOTAL PENDING --}}

    <div class="stat-card">

        <div class="stat-icon">
            ⏳
        </div>

        <div>

            <span>
                Total Pembayaran Pending
            </span>

            <strong style="color:#d97706;">

                Rp {{
                    number_format(
                        $totalPending,
                        0,
                        ',',
                        '.'
                    )
                }}

            </strong>

        </div>

    </div>


    {{-- TOTAL SEMUA --}}

    <div class="stat-card">

        <div class="stat-icon">
            📊
        </div>

        <div>

            <span>
                Total Semua Pembayaran
            </span>

            <strong>

                Rp {{
                    number_format(
                        $totalAllPayment,
                        0,
                        ',',
                        '.'
                    )
                }}

            </strong>

        </div>

    </div>


</div>


{{-- =========================================================
    INFO
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

                Total pembayaran lunas dihitung langsung
                dari transaksi pembayaran dengan status
                <strong>lunas</strong>.

                Data ini terhubung langsung dengan
                kode rental dan customer.

            </p>

        </div>

    </div>

</div>


{{-- =========================================================
    TABEL PEMBAYARAN
========================================================= --}}

<div class="card">

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Tanggal</th>

                    <th>Kode Rental</th>

                    <th>Customer</th>

                    <th>Total Rental</th>

                    <th>Jumlah Pembayaran</th>

                    <th>Metode</th>

                    <th>Status</th>

                    <th>Catatan</th>

                </tr>

            </thead>


            <tbody>

                @forelse($payments as $payment)


                    <tr>


                        {{-- NO --}}

                        <td>

                            {{
                                $payments->firstItem()
                                + $loop->index
                            }}

                        </td>


                        {{-- TANGGAL --}}

                        <td>

                            {{
                                $payment->payment_date
                                    ->format(
                                        'd/m/Y H:i'
                                    )
                            }}

                        </td>


                        {{-- KODE RENTAL --}}

                        <td>

                            <a
                                href="{{
                                    route(
                                        'rentals.show',
                                        $payment->rental
                                    )
                                }}"
                                style="
                                    color:#2563eb;
                                    font-weight:700;
                                    text-decoration:none;
                                "
                            >

                                {{
                                    $payment
                                        ->rental
                                        ->rental_code
                                    ?? '-'
                                }}

                            </a>

                        </td>


                        {{-- CUSTOMER --}}

                        <td>

                            {{
                                $payment
                                    ->rental
                                    ->customer
                                    ->name
                                ?? '-'
                            }}

                        </td>


                        {{-- TOTAL RENTAL --}}

                        <td>

                            Rp {{
                                number_format(
                                    $payment
                                        ->rental
                                        ->total
                                    ?? 0,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}

                        </td>


                        {{-- JUMLAH PEMBAYARAN --}}

                        <td>

                            <strong
                                style="
                                    color:#16a34a;
                                "
                            >

                                Rp {{
                                    number_format(
                                        $payment->amount,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            </strong>

                        </td>


                        {{-- METODE --}}

                        <td>

                            {{ strtoupper(
                                $payment->payment_method
                            ) }}

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if(
                                $payment->status
                                === 'lunas'
                            )

                                <span
                                    class="badge badge-success"
                                >
                                    Lunas
                                </span>

                            @else

                                <span
                                    class="badge badge-warning"
                                >
                                    Pending
                                </span>

                            @endif

                        </td>


                        {{-- CATATAN --}}

                        <td>

                            {{
                                $payment->notes
                                ?? '-'
                            }}

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="9"
                            class="text-center"
                        >

                            Data pembayaran tidak ditemukan.

                        </td>

                    </tr>


                @endforelse

            </tbody>

        </table>

    </div>


    <div class="pagination-wrapper">

        {{ $payments->links() }}

    </div>

</div>

@endsection