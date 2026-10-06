@extends('layouts.app')

@section('title', 'Pembayaran Rental')
@section('page-title', 'Pembayaran Rental')

@section('content')

<div class="content-card">

    <div class="card-header-custom">

        <div>

            <h3>Pembayaran Rental</h3>

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


    <div class="info-grid">

        <div class="info-item">

            <span>Customer</span>

            <strong>
                {{ $rental->customer->name }}
            </strong>

        </div>

        <div class="info-item">

            <span>Kode Rental</span>

            <strong>
                {{ $rental->rental_code }}
            </strong>

        </div>

        <div class="info-item">

            <span>Status Rental</span>

            <strong>
                {{ ucfirst($rental->status) }}
            </strong>

        </div>

    </div>


    <div class="payment-total">

        <span>Total yang Harus Dibayar</span>

        <strong>
            Rp {{ number_format($rental->total, 0, ',', '.') }}
        </strong>

    </div>


    <form
        action="{{ route('rentals.payment.process', $rental) }}"
        method="POST"
    >

        @csrf


        <div class="form-group">

            <label>
                Metode Pembayaran
            </label>


            <div class="payment-options">

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="cash"
                        {{ old('payment_method') === 'cash' ? 'checked' : '' }}
                        required
                    >

                    <div>
                        <strong>Cash</strong>

                        <small>
                            Pembayaran tunai
                        </small>
                    </div>

                </label>


                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="transfer"
                        {{ old('payment_method') === 'transfer' ? 'checked' : '' }}
                    >

                    <div>
                        <strong>Transfer</strong>

                        <small>
                            Transfer bank
                        </small>
                    </div>

                </label>


                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment_method"
                        value="qris"
                        {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                    >

                    <div>
                        <strong>QRIS</strong>

                        <small>
                            Pembayaran QRIS
                        </small>
                    </div>

                </label>

            </div>

        </div>


        <div class="form-group">

            <label for="notes">
                Catatan Pembayaran
            </label>

            <textarea
                name="notes"
                id="notes"
                rows="4"
                class="form-control"
                placeholder="Catatan pembayaran (opsional)"
            >{{ old('notes') }}</textarea>

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
                Konfirmasi Pembayaran
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
        max-width: 850px;
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

    .payment-total {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .payment-total span {
        font-weight: 600;
    }

    .payment-total strong {
        color: #2563eb;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group > label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .payment-option {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 9px;
        cursor: pointer;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .payment-option:has(input:checked) {
        border: 2px solid #2563eb;
        background: #eff6ff;
    }

    .payment-option input {
        margin-top: 3px;
    }

    .payment-option strong,
    .payment-option small {
        display: block;
    }

    .payment-option small {
        color: #777;
        margin-top: 4px;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
        font-family: inherit;
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

    @media(max-width: 700px) {

        .info-grid,
        .payment-options {
            grid-template-columns: 1fr;
        }

        .payment-total {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

    }

</style>
@endpush