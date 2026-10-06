@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('page-title', 'Edit Kendaraan')

@section('content')

    <div class="card form-card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Edit Kendaraan
                </div>

                <div class="card-description">
                    Perbarui informasi kendaraan.
                </div>
            </div>

        </div>


        <form
            action="{{ route('vehicles.update', $vehicle) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Kategori <span class="required">*</span>
                    </label>

                    <select
                        name="category_id"
                        class="form-input @error('category_id') input-error @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $vehicle->category_id) == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Kode Kendaraan <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $vehicle->code) }}"
                        class="form-input @error('code') input-error @enderror"
                        required
                    >

                    @error('code')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Nama Kendaraan <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $vehicle->name) }}"
                        class="form-input @error('name') input-error @enderror"
                        required
                    >

                    @error('name')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Merek <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="brand"
                        value="{{ old('brand', $vehicle->brand) }}"
                        class="form-input @error('brand') input-error @enderror"
                        required
                    >

                    @error('brand')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Nomor Plat <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="plate_number"
                        value="{{ old('plate_number', $vehicle->plate_number) }}"
                        class="form-input @error('plate_number') input-error @enderror"
                        required
                    >

                    @error('plate_number')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Tahun <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="year"
                        value="{{ old('year', $vehicle->year) }}"
                        min="1900"
                        max="{{ date('Y') }}"
                        class="form-input @error('year') input-error @enderror"
                        required
                    >

                    @error('year')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Harga Sewa / Hari <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="price_per_day"
                        value="{{ old('price_per_day', $vehicle->price_per_day) }}"
                        min="0"
                        step="1000"
                        class="form-input @error('price_per_day') input-error @enderror"
                        required
                    >

                    @error('price_per_day')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        Status <span class="required">*</span>
                    </label>

                    <select
                        name="status"
                        class="form-input"
                        required
                    >

                        <option
                            value="tersedia"
                            {{ old('status', $vehicle->status) === 'tersedia' ? 'selected' : '' }}
                        >
                            Tersedia
                        </option>

                        <option
                            value="disewa"
                            {{ old('status', $vehicle->status) === 'disewa' ? 'selected' : '' }}
                        >
                            Disewa
                        </option>

                        <option
                            value="servis"
                            {{ old('status', $vehicle->status) === 'servis' ? 'selected' : '' }}
                        >
                            Servis
                        </option>

                    </select>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="form-input"
                >{{ old('description', $vehicle->description) }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('vehicles.index') }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

@endsection


@push('styles')

<style>

    .form-card {
        max-width: 1000px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        font-size: 13px;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-input {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 14px;
        background: white;
    }

    .form-input:focus {
        border-color: #2563eb;
    }

    .input-error {
        border-color: #dc2626;
    }

    .field-error {
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-secondary {
        display: inline-block;
        text-decoration: none;
        background: #e5e7eb;
        color: #374151;
        padding: 10px 15px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
    }

    .btn-primary {
        border: none;
        background: #2563eb;
        color: white;
        padding: 10px 15px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

</style>

@endpush