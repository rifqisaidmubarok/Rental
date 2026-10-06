<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Helpers\ActivityLogger;

class CustomerController extends Controller
{
    /**
     * Menampilkan semua customer.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('driver_license', 'like', "%{$search}%");
            });
        }

        $customers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    /**
     * Form tambah customer.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan customer baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'max:50',
                'unique:customers,nik',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'address' => [
                'required',
                'string',
            ],
            'driver_license' => [
                'required',
                'string',
                'max:50',
                'unique:customers,driver_license',
            ],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'driver_license.required' => 'Nomor SIM wajib diisi.',
            'driver_license.unique' => 'Nomor SIM sudah terdaftar.',
        ]);

        // Simpan customer dan ambil data yang baru dibuat
        $customer = Customer::create($validated);

        // Catat aktivitas
        ActivityLogger::log(
            'Tambah Customer',
            'Menambahkan customer: ' .
            $customer->name .
            ' (' . $customer->nik . ')'
        );

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Form edit customer.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update customer.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'max:50',
                'unique:customers,nik,' . $customer->id,
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'address' => [
                'required',
                'string',
            ],
            'driver_license' => [
                'required',
                'string',
                'max:50',
                'unique:customers,driver_license,' . $customer->id,
            ],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'driver_license.required' => 'Nomor SIM wajib diisi.',
            'driver_license.unique' => 'Nomor SIM sudah terdaftar.',
        ]);

        $customer->update($validated);

        ActivityLogger::log(
            'Edit Customer',
            'Mengubah data customer: ' .
            $customer->name .
            ' (' . $customer->nik . ')'
        );

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    /**
     * Hapus customer.
     */
    public function destroy(Customer $customer)
    {
        ActivityLogger::log(
            'Hapus Customer',
            'Menghapus customer: ' .
            $customer->name .
            ' (' . $customer->nik . ')'
        );

        try {
            $customer->delete();

            return redirect()
                ->route('customers.index')
                ->with('success', 'Customer berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()
                ->route('customers.index')
                ->with('error', 'Customer tidak dapat dihapus karena sudah memiliki data rental.');
        }
    }
}