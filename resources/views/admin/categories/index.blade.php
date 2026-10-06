@extends('layouts.app')

@section('title', 'Kategori Kendaraan')

@section('page-title', 'Kategori Kendaraan')

@section('content')

    <div class="card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Data Kategori Kendaraan
                </div>

                <div class="card-description">
                    Kelola kategori kendaraan rental.
                </div>
            </div>

           <a
    href="{{ route('admin.categories.create') }}"
    class="btn btn-primary btn-add-category"
>
    <span>＋</span>
    <span>Tambah Kategori</span>
</a>

        </div>


        @if($categories->count() > 0)

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="150">Jumlah Kendaraan</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($categories as $category)

                            <tr>

                                <td>
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $category->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $category->description ?: '-' }}
                                </td>

                                <td>
                                    <span class="badge badge-blue">
                                        {{ $category->vehicles_count }}
                                        kendaraan
                                    </span>
                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                {{ $categories->links() }}
            </div>

        @else

            <div class="empty-state">
                <div class="empty-icon">
                    🏷️
                </div>

                <h3>
                    Belum ada kategori
                </h3>

                <p>
                    Silakan tambahkan kategori kendaraan.
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

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .data-table th {
        background: #f9fafb;
        color: #374151;
        font-weight: bold;
        text-align: left;
        padding: 13px;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table td {
        padding: 13px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-buttons {
        display: flex;
        gap: 7px;
    }

    .btn-edit,
    .btn-delete {
        border: none;
        padding: 7px 10px;
        border-radius: 6px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
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
   TOMBOL TAMBAH KATEGORI
   ========================================================= */

.btn-add-category {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;

    min-width: 172px !important;
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

.btn-add-category span {
    color: #ffffff !important;
}

.btn-add-category:hover {
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

.btn-add-category:active {
    transform: translateY(0);
}

</style>

@endpush