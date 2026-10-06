<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Helpers\ActivityLogger;

class RentalController extends Controller
{
    /**
     * Menampilkan daftar rental.
     */
    public function index(Request $request)
    {
        $query = Rental::with([
            'customer',
            'createdBy',
            'details.vehicle'
        ]);

        /*
         * Pencarian rental berdasarkan:
         * - kode rental
         * - nama customer
         * - NIK customer
         */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'rental_code',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'customer',
                    function ($customerQuery) use ($search) {

                        $customerQuery
                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nik',
                                'like',
                                "%{$search}%"
                            );
                    }
                );
            });
        }

        $rentals = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'rentals.index',
            compact('rentals')
        );
    }


    /**
     * Form transaksi rental.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        $vehicles = Vehicle::with('category')
            ->where('status', 'tersedia')
            ->orderBy('name')
            ->get();

        return view(
            'rentals.create',
            compact(
                'customers',
                'vehicles'
            )
        );
    }


    /**
     * Menyimpan transaksi rental.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'exists:customers,id',
            ],

            'rental_date' => [
                'required',
                'date',
            ],

            'return_date' => [
                'required',
                'date',
                'after_or_equal:rental_date',
            ],

            'vehicle_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'vehicle_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:vehicles,id',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ], [

            'customer_id.required' =>
                'Customer wajib dipilih.',

            'customer_id.exists' =>
                'Customer tidak ditemukan.',

            'rental_date.required' =>
                'Tanggal rental wajib diisi.',

            'return_date.required' =>
                'Tanggal kembali wajib diisi.',

            'return_date.after_or_equal' =>
                'Tanggal kembali tidak boleh sebelum tanggal rental.',

            'vehicle_ids.required' =>
                'Pilih minimal satu kendaraan.',

            'vehicle_ids.min' =>
                'Pilih minimal satu kendaraan.',

            'vehicle_ids.*.distinct' =>
                'Kendaraan tidak boleh dipilih dua kali.',

            'vehicle_ids.*.exists' =>
                'Kendaraan yang dipilih tidak ditemukan.',
        ]);


        try {

            $rental = DB::transaction(
                function () use (
                    $validated,
                    $request
                ) {

                    /*
                     * Lock kendaraan yang dipilih
                     * untuk mencegah double rental.
                     */
                    $vehicles = Vehicle::whereIn(
                        'id',
                        $validated['vehicle_ids']
                    )
                        ->lockForUpdate()
                        ->get();


                    /*
                     * Pastikan semua kendaraan ditemukan.
                     */
                    if (
                        $vehicles->count() !==
                        count($validated['vehicle_ids'])
                    ) {

                        throw ValidationException::withMessages([
                            'vehicle_ids' =>
                                'Salah satu kendaraan tidak ditemukan.'
                        ]);
                    }


                    /*
                     * Pastikan semua kendaraan tersedia.
                     */
                    $unavailableVehicles =
                        $vehicles->filter(
                            function ($vehicle) {

                                return $vehicle->status !==
                                    'tersedia';
                            }
                        );


                    if (
                        $unavailableVehicles->isNotEmpty()
                    ) {

                        $names =
                            $unavailableVehicles
                                ->pluck('name')
                                ->implode(', ');

                        throw ValidationException::withMessages([
                            'vehicle_ids' =>
                                "Kendaraan berikut tidak tersedia: {$names}"
                        ]);
                    }


                    /*
                     * Hitung tanggal rental.
                     */
                    $rentalDate =
                        \Carbon\Carbon::parse(
                            $validated['rental_date']
                        );


                    $returnDate =
                        \Carbon\Carbon::parse(
                            $validated['return_date']
                        );


                    /*
                     * Durasi rental.
                     *
                     * Contoh:
                     *
                     * 1 Oktober - 1 Oktober = 1 hari
                     * 1 Oktober - 3 Oktober = 3 hari
                     */
                    $duration =
                        $rentalDate->diffInDays(
                            $returnDate
                        ) + 1;


                    /*
                     * Hitung subtotal.
                     */
                    $subtotal = 0;


                    foreach ($vehicles as $vehicle) {

                        $detailSubtotal =
                            $vehicle->price_per_day *
                            $duration;

                        $subtotal +=
                            $detailSubtotal;
                    }


                    /*
                     * Generate kode rental.
                     */
                    $rentalCode =
                        $this->generateRentalCode();


                    /*
                     * Simpan rental utama.
                     */
                    $rental = Rental::create([

                        'rental_code' =>
                            $rentalCode,

                        'customer_id' =>
                            $validated['customer_id'],

                        'rental_date' =>
                            $validated['rental_date'],

                        'return_date' =>
                            $validated['return_date'],

                        'actual_return_date' =>
                            null,

                        'subtotal' =>
                            $subtotal,

                        'late_fee' =>
                            0,

                        'total' =>
                            $subtotal,

                        'status' =>
                            'disewa',

                        'notes' =>
                            $validated['notes'] ?? null,

                        'created_by' =>
                            auth()->id(),
                    ]);


                    /*
                     * Simpan detail rental.
                     */
                    foreach ($vehicles as $vehicle) {

                        $detailSubtotal =
                            $vehicle->price_per_day *
                            $duration;


                        $rental->details()->create([

                            'vehicle_id' =>
                                $vehicle->id,

                            'price_per_day' =>
                                $vehicle->price_per_day,

                            'duration' =>
                                $duration,

                            'subtotal' =>
                                $detailSubtotal,
                        ]);


                        /*
                         * Ubah status kendaraan
                         * menjadi disewa.
                         */
                        $vehicle->update([
                            'status' => 'disewa',
                        ]);
                    }


                    return $rental;
                }
            );


            /*
             * Activity Log.
             */
            ActivityLogger::log(
                'Tambah Rental',
                'Membuat transaksi rental: ' .
                $rental->rental_code
            );


            return redirect()
                ->route(
                    'rentals.show',
                    $rental
                )
                ->with(
                    'success',
                    'Transaksi rental berhasil dibuat.'
                );


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Transaksi gagal disimpan: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Menampilkan detail transaksi.
     */
    public function show(Rental $rental)
    {
        $rental->load([
            'customer',
            'createdBy',
            'details.vehicle.category',
            'payments',
        ]);

        return view(
            'rentals.show',
            compact('rental')
        );
    }


    /**
     * Generate kode rental.
     */
    private function generateRentalCode()
    {
        do {

            $code =
                'RNT-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(
                    substr(
                        uniqid(),
                        -4
                    )
                );

        } while (
            Rental::where(
                'rental_code',
                $code
            )->exists()
        );


        return $code;
    }


    /**
     * Form pengembalian kendaraan.
     */
    public function returnForm(Rental $rental)
    {
        $rental->load([
            'customer',
            'details.vehicle',
            'payments'
        ]);


        /*
         * Pengembalian hanya dapat dilakukan
         * untuk rental yang masih disewa
         * atau terlambat.
         */
        if (
            !in_array(
                $rental->status,
                [
                    'disewa',
                    'terlambat'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'rentals.show',
                    $rental
                )
                ->with(
                    'error',
                    'Rental ini sudah tidak dapat diproses untuk pengembalian.'
                );
        }


        return view(
            'rentals.return',
            compact('rental')
        );
    }


    /**
     * Memproses pengembalian kendaraan.
     */
    public function processReturn(
        Request $request,
        Rental $rental
    ) {

        /*
         * Validasi tanggal pengembalian.
         */
        $validated = $request->validate([

            'actual_return_date' => [
                'required',
                'date',
            ],

        ], [

            'actual_return_date.required' =>
                'Tanggal pengembalian wajib diisi.',

            'actual_return_date.date' =>
                'Tanggal pengembalian tidak valid.',
        ]);


        try {

            /*
             * Semua proses pengembalian
             * dilakukan dalam transaction.
             */
            $result = DB::transaction(
                function () use (
                    $validated,
                    $rental
                ) {

                    /*
                     * Lock rental.
                     *
                     * Tujuannya supaya rental
                     * tidak dapat diproses dua kali
                     * secara bersamaan.
                     */
                    $rental = Rental::where(
                        'id',
                        $rental->id
                    )
                        ->lockForUpdate()
                        ->firstOrFail();


                    /*
                     * Pastikan rental masih bisa
                     * diproses.
                     */
                    if (
                        !in_array(
                            $rental->status,
                            [
                                'disewa',
                                'terlambat'
                            ]
                        )
                    ) {

                        throw ValidationException::withMessages([
                            'actual_return_date' =>
                                'Rental ini sudah diproses dan tidak dapat dikembalikan lagi.'
                        ]);
                    }


                    /*
                     * Parse tanggal.
                     */
                    $actualReturnDate =
                        \Carbon\Carbon::parse(
                            $validated['actual_return_date']
                        );


                    $rentalDate =
                        \Carbon\Carbon::parse(
                            $rental->rental_date
                        );


                    $plannedReturnDate =
                        \Carbon\Carbon::parse(
                            $rental->return_date
                        );


                    /*
                     * Tanggal pengembalian tidak boleh
                     * sebelum tanggal rental.
                     */
                    if (
                        $actualReturnDate->lt(
                            $rentalDate
                        )
                    ) {

                        throw ValidationException::withMessages([
                            'actual_return_date' =>
                                'Tanggal pengembalian tidak boleh sebelum tanggal rental.'
                        ]);
                    }


                    /*
                     * Hitung keterlambatan.
                     */
                    $lateDays = 0;


                    if (
                        $actualReturnDate->gt(
                            $plannedReturnDate
                        )
                    ) {

                        $lateDays =
                            $plannedReturnDate->diffInDays(
                                $actualReturnDate
                            );
                    }


                    /*
                     * Denda keterlambatan:
                     *
                     * Rp100.000 per hari.
                     */
                    $lateFee =
                        $lateDays * 100000;


                    /*
                     * Hitung total akhir.
                     */
                    $total =
                        $rental->subtotal +
                        $lateFee;


                    /*
                     * Status rental.
                     *
                     * Jika terlambat:
                     * terlambat
                     *
                     * Jika tidak terlambat:
                     * selesai
                     */
                    $status =
                        $lateDays > 0
                            ? 'terlambat'
                            : 'selesai';


                    /*
                     * Update rental.
                     */
                    $rental->update([

                        'actual_return_date' =>
                            $actualReturnDate->format(
                                'Y-m-d'
                            ),

                        'late_fee' =>
                            $lateFee,

                        'total' =>
                            $total,

                        'status' =>
                            $status,
                    ]);


                    /*
                     * Ambil detail rental.
                     */
                    $rental->load(
                        'details'
                    );


                    /*
                     * Ambil semua ID kendaraan.
                     */
                    $vehicleIds =
                        $rental->details
                            ->pluck('vehicle_id')
                            ->toArray();


                    /*
                     * Kembalikan semua kendaraan
                     * menjadi tersedia.
                     */
                    if (
                        !empty($vehicleIds)
                    ) {

                        Vehicle::whereIn(
                            'id',
                            $vehicleIds
                        )->update([
                            'status' => 'tersedia',
                        ]);
                    }


                    /*
                     * Kembalikan hasil transaction.
                     *
                     * Ini penting karena nilai
                     * $lateFee sebelumnya hanya
                     * tersedia di dalam closure.
                     */
                    return [

                        'rental' =>
                            $rental,

                        'late_days' =>
                            $lateDays,

                        'late_fee' =>
                            $lateFee,

                        'total' =>
                            $total,
                    ];
                }
            );


            /*
             * Ambil hasil transaction.
             */
            $updatedRental =
                $result['rental'];

            $lateDays =
                $result['late_days'];

            $lateFee =
                $result['late_fee'];

            $total =
                $result['total'];


            /*
             * Activity Log.
             */
            ActivityLogger::log(

                'Pengembalian Kendaraan',

                'Memproses pengembalian rental: ' .
                $updatedRental->rental_code .
                '. Keterlambatan: ' .
                $lateDays .
                ' hari. Denda: Rp ' .
                number_format(
                    $lateFee,
                    0,
                    ',',
                    '.'
                ) .
                '. Total: Rp ' .
                number_format(
                    $total,
                    0,
                    ',',
                    '.'
                )
            );


            /*
             * Redirect ke detail rental.
             */
            if ($lateDays > 0) {

                return redirect()
                    ->route(
                        'rentals.show',
                        $updatedRental
                    )
                    ->with(
                        'success',
                        'Kendaraan berhasil dikembalikan. ' .
                        'Denda keterlambatan Rp ' .
                        number_format(
                            $lateFee,
                            0,
                            ',',
                            '.'
                        ) .
                        ' telah ditambahkan.'
                    );

            }


            return redirect()
                ->route(
                    'rentals.show',
                    $updatedRental
                )
                ->with(
                    'success',
                    'Kendaraan berhasil dikembalikan tanpa denda keterlambatan.'
                );


        } catch (ValidationException $e) {

            /*
             * Biarkan Laravel menampilkan
             * pesan validasi.
             */
            throw $e;


        } catch (\Throwable $e) {

            /*
             * Untuk sementara tampilkan error asli
             * agar jika masih ada masalah kita
             * dapat mengetahui penyebabnya.
             */
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengembalian gagal diproses: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Form pembayaran.
     */
    public function paymentForm(Rental $rental)
    {
        $rental->load([
            'customer',
            'payments'
        ]);


        /*
         * Pembayaran hanya dapat dilakukan
         * setelah kendaraan dikembalikan.
         */
        if (
            !in_array(
                $rental->status,
                [
                    'selesai',
                    'terlambat'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'rentals.show',
                    $rental
                )
                ->with(
                    'error',
                    'Pembayaran hanya dapat dilakukan setelah kendaraan dikembalikan.'
                );
        }


        /*
         * Cek apakah sudah ada pembayaran lunas.
         */
        $payment = $rental->payments()
            ->where(
                'status',
                'lunas'
            )
            ->latest()
            ->first();


        if ($payment) {

            return redirect()
                ->route(
                    'rentals.show',
                    $rental
                )
                ->with(
                    'error',
                    'Rental ini sudah memiliki pembayaran lunas.'
                );
        }


        return view(
            'rentals.payment',
            compact('rental')
        );
    }


    /**
     * Memproses pembayaran.
     */
    public function processPayment(
        Request $request,
        Rental $rental
    ) {

        /*
         * Validasi pembayaran.
         */
        $validated = $request->validate([

            'payment_method' => [
                'required',
                'in:cash,transfer,qris',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ], [

            'payment_method.required' =>
                'Metode pembayaran wajib dipilih.',

            'payment_method.in' =>
                'Metode pembayaran tidak valid.',
        ]);


        try {

            DB::transaction(
                function () use (
                    $validated,
                    $rental
                ) {

                    /*
                     * Lock rental.
                     */
                    $rental = Rental::where(
                        'id',
                        $rental->id
                    )
                        ->lockForUpdate()
                        ->firstOrFail();


                    /*
                     * Rental harus sudah dikembalikan.
                     */
                    if (
                        !in_array(
                            $rental->status,
                            [
                                'selesai',
                                'terlambat'
                            ]
                        )
                    ) {

                        throw ValidationException::withMessages([
                            'payment_method' =>
                                'Kendaraan harus dikembalikan terlebih dahulu.'
                        ]);
                    }


                    /*
                     * Cek apakah sudah dibayar.
                     */
                    $alreadyPaid =
                        $rental->payments()
                            ->where(
                                'status',
                                'lunas'
                            )
                            ->exists();


                    if ($alreadyPaid) {

                        throw ValidationException::withMessages([
                            'payment_method' =>
                                'Rental ini sudah dibayar.'
                        ]);
                    }


                    /*
                     * Simpan pembayaran.
                     */
                    $rental->payments()->create([

                        'payment_date' =>
                            now(),

                        'amount' =>
                            $rental->total,

                        'payment_method' =>
                            $validated['payment_method'],

                        'status' =>
                            'lunas',

                        'notes' =>
                            $validated['notes'] ?? null,
                    ]);
                }
            );


            /*
             * Activity Log.
             */
            ActivityLogger::log(

                'Pembayaran Rental',

                'Mencatat pembayaran rental: ' .
                $rental->rental_code .
                ' sebesar Rp ' .
                number_format(
                    $rental->total,
                    0,
                    ',',
                    '.'
                )
            );


            return redirect()
                ->route(
                    'rentals.show',
                    $rental
                )
                ->with(
                    'success',
                    'Pembayaran berhasil dicatat sebagai lunas.'
                );


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pembayaran gagal diproses: ' .
                    $e->getMessage()
                );
        }
    }
}