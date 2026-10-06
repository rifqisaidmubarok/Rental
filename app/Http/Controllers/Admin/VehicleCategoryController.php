<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VehicleCategoryController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::withCount('vehicles')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:vehicle_categories,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        VehicleCategory::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori kendaraan berhasil ditambahkan.');
    }

    public function edit(VehicleCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, VehicleCategory $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:vehicle_categories,name,' . $category->id,
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori kendaraan berhasil diperbarui.');
    }

    public function destroy(VehicleCategory $category)
    {
        if ($category->vehicles()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan oleh kendaraan.'
                );
        }

        try {
            $category->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Kategori kendaraan berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan.'
                );
        }
    }
}