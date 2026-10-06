@extends('layouts.app')

@section('title', 'Data Customer')
@section('page-title', 'Data Customer')

@section('content')

<div class="content-card">

    <div class="card-header-custom">
        <div>
            <h3>Data Customer</h3>
            <p>Kelola data pelanggan rental kendaraan</p>
        </div>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            + Tambah Customer
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('customers.index') }}" class="search-form">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari NIK, nama, nomor HP, atau SIM..."
            class="form-control"
        >

        <button type="submit" class="btn btn-secondary">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('customers.index') }}" class="btn btn-light">
                Reset
            </a>
        @endif

    </form>

    <div class="table-responsive">

        <table class="table-custom">

            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>No. SIM</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($customers as $customer)

                    <tr>

                        <td>
                            {{ $customers->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $customer->nik }}
                        </td>

                        <td>
                            <strong>{{ $customer->name }}</strong>
                        </td>

                        <td>
                            {{ $customer->phone }}
                        </td>

                        <td>
                            {{ $customer->address }}
                        </td>

                        <td>
                            {{ $customer->driver_license }}
                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('customers.edit', $customer) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('customers.destroy', $customer) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus customer ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data customer.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $customers->links() }}
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

    .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
    }

    .card-header-custom h3 {
        margin: 0 0 5px;
    }

    .card-header-custom p {
        margin: 0;
        color: #777;
    }

    .search-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-form .form-control {
        flex: 1;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
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
        vertical-align: middle;
    }

    .table-custom th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 7px;
        border: none;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #374151;
        color: white;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-light {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-sm {
        padding: 7px 10px;
        font-size: 13px;
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

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .text-center {
        text-align: center !important;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

</style>
@endpush