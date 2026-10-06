@extends('layouts.app')

@section('title', 'Rental Baru')
@section('page-title', 'Rental Baru')

@section('content')

<div class="content-card">

    <div class="card-header-custom">

        <div>
            <h3>Transaksi Rental Baru</h3>
            <p>Pilih customer, tanggal rental, dan kendaraan</p>
        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Periksa kembali data berikut:</strong>

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

    <form
        action="{{ route('rentals.store') }}"
        method="POST"
        id="rentalForm"
    >

        @csrf

        {{-- CUSTOMER --}}

        <div class="form-group">

            <label for="customer_id">
                Customer
            </label>

            <select
                name="customer_id"
                id="customer_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Customer --
                </option>

                @foreach($customers as $customer)

                    <option
                        value="{{ $customer->id }}"
                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                    >
                        {{ $customer->name }}
                        - {{ $customer->nik }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- TANGGAL --}}

        <div class="date-grid">

            <div class="form-group">

                <label for="rental_date">
                    Tanggal Rental
                </label>

                <input
                    type="date"
                    name="rental_date"
                    id="rental_date"
                    value="{{ old('rental_date', date('Y-m-d')) }}"
                    class="form-control"
                    required
                >

            </div>


            <div class="form-group">

                <label for="return_date">
                    Tanggal Kembali
                </label>

                <input
                    type="date"
                    name="return_date"
                    id="return_date"
                    value="{{ old('return_date', date('Y-m-d')) }}"
                    class="form-control"
                    required
                >

            </div>

        </div>


        {{-- DURASI --}}

        <div class="duration-info">

            Durasi rental:
            <strong>
                <span id="durationText">1</span> hari
            </strong>

        </div>


        {{-- KENDARAAN --}}

        <div class="vehicle-section">

            <div class="section-title">

                <div>
                    <h4>Pilih Kendaraan</h4>
                    <p>
                        Hanya kendaraan dengan status
                        <strong>tersedia</strong>
                        yang ditampilkan.
                    </p>
                </div>

            </div>

            @if($vehicles->count() > 0)

                <div class="vehicle-grid">

                    @foreach($vehicles as $vehicle)

                        <label
                            class="vehicle-card"
                            for="vehicle_{{ $vehicle->id }}"
                        >

                            <input
                                type="checkbox"
                                name="vehicle_ids[]"
                                value="{{ $vehicle->id }}"
                                id="vehicle_{{ $vehicle->id }}"
                                class="vehicle-checkbox"
                                data-price="{{ $vehicle->price_per_day }}"
                                {{ in_array($vehicle->id, old('vehicle_ids', [])) ? 'checked' : '' }}
                            >

                            <div class="vehicle-info">

                                <div class="vehicle-name">
                                    {{ $vehicle->name }}
                                </div>

                                <div class="vehicle-code">
                                    {{ $vehicle->code }}
                                    •
                                    {{ $vehicle->plate_number }}
                                </div>

                                <div class="vehicle-category">
                                    {{ $vehicle->category->name ?? '-' }}
                                </div>

                                <div class="vehicle-price">

                                    Rp
                                    {{ number_format($vehicle->price_per_day, 0, ',', '.') }}

                                    <small>
                                        / hari
                                    </small>

                                </div>

                            </div>

                        </label>

                    @endforeach

                </div>

            @else

                <div class="empty-vehicle">

                    Tidak ada kendaraan yang tersedia
                    untuk disewa.

                </div>

            @endif

        </div>


        {{-- TOTAL --}}

        <div class="total-box">

            <span>
                Total Rental
            </span>

            <strong id="totalText">
                Rp 0
            </strong>

        </div>


        {{-- CATATAN --}}

        <div class="form-group">

            <label for="notes">
                Catatan
            </label>

            <textarea
                name="notes"
                id="notes"
                class="form-control"
                rows="4"
                placeholder="Catatan tambahan (opsional)"
            >{{ old('notes') }}</textarea>

        </div>


        {{-- BUTTON --}}

        <div class="form-actions">

            <a
                href="{{ route('rentals.index') }}"
                class="btn btn-light"
            >
                Kembali
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Transaksi
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
        max-width: 1100px;
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

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        font-family: inherit;
    }

    .date-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .duration-info {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .vehicle-section {
        margin-top: 20px;
    }

    .section-title {
        margin-bottom: 15px;
    }

    .section-title h4 {
        margin: 0 0 5px;
    }

    .section-title p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .vehicle-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .vehicle-card {
        display: block;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        cursor: pointer;
        transition: .2s;
    }

    .vehicle-card:hover {
        border-color: #2563eb;
    }

    .vehicle-card:has(.vehicle-checkbox:checked) {
        border: 2px solid #2563eb;
        background: #eff6ff;
    }

    .vehicle-checkbox {
        margin-bottom: 12px;
        width: 18px;
        height: 18px;
    }

    .vehicle-name {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .vehicle-code {
        color: #666;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .vehicle-category {
        display: inline-block;
        background: #f3f4f6;
        color: #374151;
        padding: 4px 8px;
        border-radius: 5px;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .vehicle-price {
        font-weight: 700;
        color: #2563eb;
    }

    .vehicle-price small {
        color: #777;
        font-weight: normal;
    }

    .empty-vehicle {
        padding: 25px;
        text-align: center;
        background: #f9fafb;
        border-radius: 8px;
        color: #777;
    }

    .total-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 10px;
        margin: 25px 0;
    }

    .total-box span {
        font-size: 17px;
        font-weight: 600;
    }

    .total-box strong {
        font-size: 24px;
        color: #2563eb;
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

    @media(max-width: 800px) {

        .vehicle-grid {
            grid-template-columns: 1fr 1fr;
        }

    }

    @media(max-width: 600px) {

        .date-grid,
        .vehicle-grid {
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush


@push('scripts')
<script>

    const rentalDate =
        document.getElementById('rental_date');

    const returnDate =
        document.getElementById('return_date');

    const durationText =
        document.getElementById('durationText');

    const totalText =
        document.getElementById('totalText');

    const checkboxes =
        document.querySelectorAll('.vehicle-checkbox');


    function calculateRental()
    {
        const start = new Date(
            rentalDate.value + 'T00:00:00'
        );

        const end = new Date(
            returnDate.value + 'T00:00:00'
        );

        let duration = 1;

        if (
            rentalDate.value &&
            returnDate.value &&
            !isNaN(start) &&
            !isNaN(end)
        ) {

            const difference =
                end.getTime() - start.getTime();

            duration =
                Math.floor(
                    difference / (1000 * 60 * 60 * 24)
                ) + 1;

            if (duration < 1) {
                duration = 1;
            }

        }

        durationText.textContent = duration;

        let total = 0;

        checkboxes.forEach(function (checkbox) {

            if (checkbox.checked) {

                const price =
                    parseFloat(
                        checkbox.dataset.price
                    ) || 0;

                total += price * duration;

            }

        });

        totalText.textContent =
            'Rp ' +
            new Intl.NumberFormat('id-ID').format(total);
    }


    rentalDate.addEventListener(
        'change',
        calculateRental
    );

    returnDate.addEventListener(
        'change',
        calculateRental
    );

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            calculateRental
        );

    });


    document
        .getElementById('rentalForm')
        .addEventListener('submit', function (event) {

            const selected =
                document.querySelectorAll(
                    '.vehicle-checkbox:checked'
                );

            if (selected.length === 0) {

                event.preventDefault();

                alert(
                    'Silakan pilih minimal satu kendaraan.'
                );

            }

        });


    calculateRental();

</script>
@endpush