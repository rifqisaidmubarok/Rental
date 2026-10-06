@extends('layouts.app')

@section('title', 'Kendaraan')

@section('page-title', 'Data Kendaraan')

@section('content')

    <div class="card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Data Kendaraan
                </div>

                <div class="card-description">
                    Kelola seluruh kendaraan rental.
                </div>
            </div>

            <a
    href="{{ route('vehicles.create') }}"
    class="btn btn-primary btn-add-vehicle"
>
    <span>＋</span>
    <span>Tambah Kendaraan</span>
</a>

        </div>


        <form
            action="{{ route('vehicles.index') }}"
            method="GET"
            class="search-form"
        >

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari kode, nama, merek, atau plat..."
                class="search-input"
            >

            <button
                type="submit"
                class="btn-search"
            >
                Cari
            </button>

            @if($search)

                <a
                    href="{{ route('vehicles.index') }}"
                    class="btn-reset"
                >
                    Reset
                </a>

            @endif

        </form>


        @if($vehicles->count() > 0)

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Kendaraan</th>
                            <th>Kategori</th>
                            <th>Plat Nomor</th>
                            <th>Tahun</th>
                            <th>Harga/Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($vehicles as $vehicle)

                            <tr>

                                <td>
                                    {{ $vehicles->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    <strong>
                                        {{ $vehicle->name }}
                                    </strong>

                                    <div class="vehicle-code">
                                        {{ $vehicle->code }}
                                    </div>

                                    <div class="vehicle-brand">
                                        {{ $vehicle->brand }}
                                    </div>

                                </td>

                                <td>
                                    {{ $vehicle->category->name ?? '-' }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $vehicle->plate_number }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $vehicle->year }}
                                </td>

                                <td>
                                    Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                </td>

                                <td>

                                    @if($vehicle->status === 'tersedia')

                                        <span class="badge badge-green">
                                            Tersedia
                                        </span>

                                    @elseif($vehicle->status === 'disewa')

                                        <span class="badge badge-orange">
                                            Disewa
                                        </span>

                                    @else

                                        <span class="badge badge-red">
                                            Servis
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="{{ route('vehicles.edit', $vehicle) }}"
                                            class="btn-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('vehicles.destroy', $vehicle) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="pagination">
                {{ $vehicles->links() }}
            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    🚗
                </div>

                <h3>
                    Data kendaraan tidak ditemukan
                </h3>

                <p>
                    @if($search)
                        Tidak ada kendaraan yang cocok dengan pencarian.
                    @else
                        Belum ada data kendaraan.
                    @endif
                </p>

            </div>

        @endif

    </div>

@endsection


@push('styles')

<style>

    .btn-primary {
        display: inline-block;
        text-decoration: none;
        background: #2563eb;
        color: white;
        padding: 10px 15px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .search-form {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .search-input {
        flex: 1;
        max-width: 500px;
        padding: 10px 13px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
    }

    .search-input:focus {
        border-color: #2563eb;
    }

    .btn-search,
    .btn-reset {
        padding: 10px 15px;
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
    }

    .btn-search {
        background: #2563eb;
        color: white;
    }

    .btn-reset {
        background: #e5e7eb;
        color: #374151;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table th {
        background: #f9fafb;
        color: #374151;
        text-align: left;
        padding: 13px 10px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table td {
        padding: 13px 10px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .vehicle-code {
        color: #2563eb;
        font-size: 11px;
        margin-top: 3px;
    }

    .vehicle-brand {
        color: #6b7280;
        font-size: 11px;
        margin-top: 2px;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .badge-green {
        background: #dcfce7;
        color: #166534;
    }

    .badge-orange {
        background: #ffedd5;
        color: #c2410c;
    }

    .badge-red {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .btn-edit,
    .btn-delete {
        border: none;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 11px;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-edit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .pagination {
        margin-top: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 45px;
        margin-bottom: 15px;
    }

/* =========================================================
   TOMBOL TAMBAH KENDARAAN
   ========================================================= */

.btn-add-vehicle {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;

    min-width: 175px !important;
    height: 42px !important;

    padding: 0 18px !important;

    background: linear-gradient(
        135deg,
        #2563eb,
        #4f46e5
    ) !important;

    color: #ffffff !important;

    border: none !important;
    border-radius: 10px !important;

    font-size: 13px !important;
    font-weight: 700 !important;

    text-decoration: none !important;

    box-shadow:
        0 5px 14px rgba(37, 99, 235, 0.22);

    white-space: nowrap;
}

.btn-add-vehicle span {
    color: #ffffff !important;
}

.btn-add-vehicle:hover {
    color: #ffffff !important;

    background: linear-gradient(
        135deg,
        #1d4ed8,
        #4338ca
    ) !important;

    transform: translateY(-2px);

    box-shadow:
        0 8px 18px rgba(37, 99, 235, 0.28);
}

.btn-add-vehicle:active {
    transform: translateY(0);
}
</style>

@endpush