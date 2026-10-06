<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ActivityLogger;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $vehicles = Vehicle::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('brand', 'like', '%' . $search . '%')
                        ->orWhere('plate_number', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('vehicles.index', compact(
            'vehicles',
            'search'
        ));
    }

    public function create()
    {
        $categories = VehicleCategory::orderBy('name')->get();

        return view('vehicles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:vehicle_categories,id',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:vehicles,code',
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'brand' => [
                'required',
                'string',
                'max:100',
            ],

            'plate_number' => [
                'required',
                'string',
                'max:20',
                'unique:vehicles,plate_number',
            ],

            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'price_per_day' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'tersedia',
                    'disewa',
                    'servis',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',

            'code.required' => 'Kode kendaraan wajib diisi.',
            'code.unique' => 'Kode kendaraan sudah digunakan.',

            'name.required' => 'Nama kendaraan wajib diisi.',

            'brand.required' => 'Merek kendaraan wajib diisi.',

            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique' => 'Nomor plat sudah digunakan.',

            'year.required' => 'Tahun kendaraan wajib diisi.',
            'year.min' => 'Tahun kendaraan tidak valid.',
            'year.max' => 'Tahun kendaraan tidak boleh melebihi tahun sekarang.',

            'price_per_day.required' => 'Harga sewa wajib diisi.',
            'price_per_day.numeric' => 'Harga sewa harus berupa angka.',
            'price_per_day.min' => 'Harga sewa tidak boleh kurang dari 0.',

            'status.required' => 'Status kendaraan wajib dipilih.',
        ]);

        Vehicle::create($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');

        ActivityLogger::log(
            'Tambah Kendaraan',
            'Menambahkan kendaraan: ' . $vehicle->name .
            ' (' . $vehicle->plate_number . ')'
            );
    }

    public function edit(Vehicle $vehicle)
    {
        $categories = VehicleCategory::orderBy('name')->get();

        return view('vehicles.edit', compact(
            'vehicle',
            'categories'
        ));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:vehicle_categories,id',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:vehicles,code,' . $vehicle->id,
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'brand' => [
                'required',
                'string',
                'max:100',
            ],

            'plate_number' => [
                'required',
                'string',
                'max:20',
                'unique:vehicles,plate_number,' . $vehicle->id,
            ],

            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'price_per_day' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'tersedia',
                    'disewa',
                    'servis',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',

            'code.required' => 'Kode kendaraan wajib diisi.',
            'code.unique' => 'Kode kendaraan sudah digunakan.',

            'name.required' => 'Nama kendaraan wajib diisi.',

            'brand.required' => 'Merek kendaraan wajib diisi.',

            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique' => 'Nomor plat sudah digunakan.',

            'year.required' => 'Tahun kendaraan wajib diisi.',
            'year.min' => 'Tahun kendaraan tidak valid.',
            'year.max' => 'Tahun kendaraan tidak boleh melebihi tahun sekarang.',

            'price_per_day.required' => 'Harga sewa wajib diisi.',
            'price_per_day.numeric' => 'Harga sewa harus berupa angka.',
            'price_per_day.min' => 'Harga sewa tidak boleh kurang dari 0.',

            'status.required' => 'Status kendaraan wajib dipilih.',
        ]);

        $vehicle->update($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');

        ActivityLogger::log(
            'Edit Kendaraan',
            'Mengubah data kendaraan: ' .
            $vehicle->name .
            ' (' . $vehicle->plate_number . ')');

    }

    public function destroy(Vehicle $vehicle)
    {
        ActivityLogger::log(
        'Hapus Kendaraan',
        'Menghapus kendaraan: ' .
        $vehicle->name .
        ' (' . $vehicle->plate_number . ')');
        
        try {
            $vehicle->delete();

            return redirect()
                ->route('vehicles.index')
                ->with('success', 'Kendaraan berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()
                ->route('vehicles.index')
                ->with(
                    'error',
                    'Kendaraan tidak dapat dihapus karena sudah digunakan dalam transaksi.'
                );
        }
    }
}