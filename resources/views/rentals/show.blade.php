@extends('layouts.app')

@section('title', 'Detail Rental')
@section('page-title', 'Detail Rental')

@section('content')

<div class="content-card">

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="detail-header">

        <div>

            <h3>
                {{ $rental->rental_code }}
            </h3>

            <p>
                Detail transaksi rental kendaraan
            </p>

        </div>

        <div>

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

            @else

                <span class="badge badge-yellow">
                    {{ ucfirst($rental->status) }}
                </span>

            @endif

        </div>

    </div>


    {{-- INFORMASI RENTAL --}}

    <div class="info-grid">

        <div class="info-item">

            <span>Customer</span>

            <strong>
                {{ $rental->customer->name }}
            </strong>

        </div>

        <div class="info-item">

            <span>NIK</span>

            <strong>
                {{ $rental->customer->nik }}
            </strong>

        </div>

        <div class="info-item">

            <span>No. HP</span>

            <strong>
                {{ $rental->customer->phone }}
            </strong>

        </div>

        <div class="info-item">

            <span>Tanggal Rental</span>

            <strong>
                {{ $rental->rental_date->format('d-m-Y') }}
            </strong>

        </div>

        <div class="info-item">

            <span>Tanggal Kembali</span>

            <strong>
                {{ $rental->return_date->format('d-m-Y') }}
            </strong>

        </div>

        <div class="info-item">

            <span>Dibuat Oleh</span>

            <strong>
                {{ $rental->createdBy->name ?? '-' }}
            </strong>

        </div>

    </div>


    {{-- DETAIL KENDARAAN --}}

    <h4 class="section-heading">
        Detail Kendaraan
    </h4>

    <div class="table-responsive">

        <table class="table-custom">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>No. Polisi</th>
                    <th>Harga / Hari</th>
                    <th>Durasi</th>
                    <th>Subtotal</th>
                </tr>

            </thead>

            <tbody>

                @foreach($rental->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            <strong>
                                {{ $detail->vehicle->name }}
                            </strong>

                            <br>

                            <small>
                                {{ $detail->vehicle->code }}
                            </small>

                        </td>

                        <td>
                            {{ $detail->vehicle->plate_number }}
                        </td>

                        <td>
                            Rp
                            {{ number_format($detail->price_per_day, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $detail->duration }} hari
                        </td>

                        <td>
                            <strong>
                                Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </strong>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- TOTAL --}}

    <div class="total-section">

        <div>
            <span>Subtotal</span>

            <strong>
                Rp {{ number_format($rental->subtotal, 0, ',', '.') }}
            </strong>
        </div>

        <div>
            <span>Denda Keterlambatan</span>

            <strong>
                Rp {{ number_format($rental->late_fee, 0, ',', '.') }}
            </strong>
        </div>

        <div class="grand-total">

            <span>Total</span>

            <strong>
                Rp {{ number_format($rental->total, 0, ',', '.') }}
            </strong>

        </div>

    </div>


    @if($rental->notes)

        <div class="notes">

            <strong>Catatan:</strong>

            <p>
                {{ $rental->notes }}
            </p>

        </div>

    @endif

    {{-- INFORMASI PEMBAYARAN --}}

<h4 class="section-heading">
    Informasi Pembayaran
</h4>

@if($rental->payments->count() > 0)

    @foreach($rental->payments as $payment)

        <div class="payment-card">

            <div>

                <span>Status Pembayaran</span>

                @if($payment->status === 'lunas')

                    <strong class="payment-status-lunas">
                        LUNAS
                    </strong>

                @else

                    <strong class="payment-status-pending">
                        PENDING
                    </strong>

                @endif

            </div>


            <div>

                <span>Jumlah</span>

                <strong>
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </strong>

            </div>


            <div>

                <span>Metode</span>

                <strong>
                    {{ strtoupper($payment->payment_method) }}
                </strong>

            </div>


            <div>

                <span>Tanggal</span>

                <strong>
                    {{ $payment->payment_date->format('d-m-Y H:i') }}
                </strong>

            </div>

        </div>

    @endforeach

@else

    <div class="no-payment">
        Belum ada pembayaran.
    </div>

@endif


    <div class="form-actions">

    @if(in_array($rental->status, ['disewa', 'terlambat']))

        <a
            href="{{ route('rentals.return', $rental) }}"
            class="btn btn-warning"
        >
            ↩ Kembalikan Kendaraan
        </a>

    @endif


    @if(
        in_array($rental->status, ['selesai', 'terlambat'])
        &&
        !$rental->payments->where('status', 'lunas')->count()
    )

        <a
            href="{{ route('rentals.payment', $rental) }}"
            class="btn btn-success"
        >
            💳 Bayar Rental
        </a>

    @endif


    <a
        href="{{ route('rentals.index') }}"
        class="btn btn-light"
    >
        Kembali
    </a>

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

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .detail-header h3 {
        margin: 0 0 5px;
    }

    .detail-header p {
        margin: 0;
        color: #777;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .info-item {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
    }

    .info-item span {
        display: block;
        color: #777;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .info-item strong {
        display: block;
    }

    .section-heading {
        margin-bottom: 15px;
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
    }

    .table-custom th {
        background: #f8f9fa;
    }

    .total-section {
        margin-top: 25px;
        margin-left: auto;
        max-width: 450px;
    }

    .total-section > div {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .grand-total {
        font-size: 20px;
        border-bottom: none !important;
        padding-top: 15px !important;
    }

    .grand-total strong {
        color: #2563eb;
    }

    .notes {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        margin-top: 25px;
    }

    .notes p {
        margin-bottom: 0;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 7px;
        text-decoration: none;
    }

    .btn-light {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-success {
        background: #16a34a;
        color: white;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
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

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .payment-card {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        background: #f8fafc;
        padding: 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .payment-card span {
        display: block;
        color: #777;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .payment-status-lunas {
        color: #15803d;
    }

    .payment-status-pending {
        color: #ca8a04;
    }

    .no-payment {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        color: #777;
        margin-bottom: 20px;
    }

    @media(max-width: 800px) {
        .payment-card {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 800px) {

        .info-grid {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media(max-width: 600px) {

        .info-grid {
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush