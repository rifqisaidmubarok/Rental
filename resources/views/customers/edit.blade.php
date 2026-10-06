@extends('layouts.app')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('content')

<div class="content-card">

    <div class="card-header-custom">
        <div>
            <h3>Edit Customer</h3>
            <p>Perbarui data pelanggan</p>
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

    <form
        action="{{ route('customers.update', $customer) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="nik">
                NIK
            </label>

            <input
                type="text"
                id="nik"
                name="nik"
                value="{{ old('nik', $customer->nik) }}"
                class="form-control"
                maxlength="50"
                required
            >

        </div>

        <div class="form-group">

            <label for="name">
                Nama Lengkap
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $customer->name) }}"
                class="form-control"
                required
            >

        </div>

        <div class="form-group">

            <label for="phone">
                Nomor HP
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone', $customer->phone) }}"
                class="form-control"
                maxlength="20"
                required
            >

        </div>

        <div class="form-group">

            <label for="address">
                Alamat
            </label>

            <textarea
                id="address"
                name="address"
                class="form-control"
                rows="4"
                required
            >{{ old('address', $customer->address) }}</textarea>

        </div>

        <div class="form-group">

            <label for="driver_license">
                Nomor SIM
            </label>

            <input
                type="text"
                id="driver_license"
                name="driver_license"
                value="{{ old('driver_license', $customer->driver_license) }}"
                class="form-control"
                maxlength="50"
                required
            >

        </div>

        <div class="form-actions">

            <a
                href="{{ route('customers.index') }}"
                class="btn btn-light"
            >
                Kembali
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Customer
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
        max-width: 900px;
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

</style>
@endpush