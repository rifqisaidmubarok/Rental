@extends('layouts.app')

@section('title', 'Pengembalian Kendaraan')
@section('page-title', 'Pengembalian Kendaraan')

@section('content')

<div class="content-card">

    <div class="card-header-custom">

        <div>
            <h3>Pengembalian Kendaraan</h3>

            <p>
                {{ $rental->rental_code }}
            </p>
        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Periksa kembali:</strong>

            <ul>

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- INFORMASI CUSTOMER --}}

    <div class="info-grid">

        <div class="info-item">

            <span>Customer</span>

            <strong>
                {{ $rental->customer->name }}
            </strong>

        </div>

        <div class="info-item">

            <span>Tanggal Rental</span>

            <strong>
                {{ $rental->rental_date->format('d-m-Y') }}
            </strong>

        </div>

        <div class="info-item">

            <span>Jatuh Tempo</span>

            <strong>
                {{ $rental->return_date->format('d-m-Y') }}
            </strong>

        </div>

    </div>


    {{-- KENDARAAN --}}

    <h4 class="section-heading">
        Kendaraan yang Dikembalikan
    </h4>

    <div class="table-responsive">

        <table class="table-custom">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>No. Polisi</th>
                </tr>

            </thead>

            <tbody>

                @foreach($rental->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $detail->vehicle->name }}
                        </td>

                        <td>
                            {{ $detail->vehicle->plate_number }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    {{-- FORM PENGEMBALIAN --}}

    <form
        action="{{ route('rentals.return.process', $rental) }}"
        method="POST"
        id="returnForm"
    >

        @csrf

        <div class="form-group">

            <label for="actual_return_date">
                Tanggal Pengembalian Aktual
            </label>

            <input
                type="date"
                name="actual_return_date"
                id="actual_return_date"
                value="{{ old('actual_return_date', date('Y-m-d')) }}"
                class="form-control"
                required
            >

        </div>


        <div
            class="calculation-box"
            id="calculationBox"
        >

            <div>
                <span>Keterlambatan</span>

                <strong>
                    <span id="lateDays">0</span> hari
                </strong>
            </div>

            <div>
                <span>Denda</span>

                <strong id="lateFee">
                    Rp 0
                </strong>
            </div>

        </div>


        <div class="warning-box">

            <strong>Perhatian:</strong>

            <p>
                Setelah pengembalian diproses, semua kendaraan
                dalam transaksi ini akan berubah menjadi
                <strong>tersedia</strong>.
            </p>

        </div>


        <div class="form-actions">

            <a
                href="{{ route('rentals.show', $rental) }}"
                class="btn btn-light"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Proses Pengembalian
            </button>

        </div>

    </form>

</div>

@endsection


@push('styles')
<style>

    .content-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
        max-width: 1000px;
    }

    .card-header-custom {
        margin-bottom: 25px;
    }

    .card-header-custom h3 {
        margin: 0 0 5px;
    }

    .card-header-custom p {
        margin: 0;
        color: #777;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
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

    .form-group {
        margin-top: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .calculation-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 18px;
        margin-top: 20px;
    }

    .calculation-box > div {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }

    .calculation-box strong {
        color: #dc2626;
    }

    .warning-box {
        background: #fff7ed;
        color: #9a3412;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .warning-box p {
        margin: 5px 0 0;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-light {
        background: #e5e7eb;
        color: #111827;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    @media(max-width: 600px) {

        .info-grid {
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush


@push('scripts')
<script>

    const returnDate =
        document.getElementById('actual_return_date');

    const lateDaysElement =
        document.getElementById('lateDays');

    const lateFeeElement =
        document.getElementById('lateFee');

    const plannedDate =
        new Date(
            '{{ $rental->return_date->format("Y-m-d") }}T00:00:00'
        );


    function calculateLateFee()
    {
        if (!returnDate.value) {
            return;
        }

        const actualDate =
            new Date(
                returnDate.value + 'T00:00:00'
            );

        let lateDays = 0;

        if (actualDate > plannedDate) {

            const difference =
                actualDate.getTime() -
                plannedDate.getTime();

            lateDays =
                Math.floor(
                    difference /
                    (1000 * 60 * 60 * 24)
                );
        }

        const fee =
            lateDays * 100000;

        lateDaysElement.textContent =
            lateDays;

        lateFeeElement.textContent =
            'Rp ' +
            new Intl.NumberFormat('id-ID')
                .format(fee);
    }


    returnDate.addEventListener(
        'change',
        calculateLateFee
    );

    calculateLateFee();

</script>
@endpush