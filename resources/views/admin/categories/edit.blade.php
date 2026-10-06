@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('page-title', 'Edit Kategori')

@section('content')

    <div class="card form-card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Edit Kategori Kendaraan
                </div>

                <div class="card-description">
                    Perbarui informasi kategori.
                </div>
            </div>

        </div>


        <form
            action="{{ route('admin.categories.update', $category) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="form-group">

                <label>
                    Nama Kategori
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
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
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="form-input"
                >{{ old('description', $category->description) }}</textarea>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('admin.categories.index') }}"
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
        max-width: 800px;
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

</style>

@endpush