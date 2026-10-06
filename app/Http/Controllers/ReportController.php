<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LAPORAN RENTAL
    |--------------------------------------------------------------------------
    */

    public function rentals(Request $request)
    {
        $query = Rental::with([
            'customer',
            'details.vehicle',
            'createdBy',
            'payments',
        ])
        ->latest('rental_date');


        /*
        |--------------------------------------------------------------------------
        | Filter tanggal rental
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'rental_date',
                '>=',
                $request->date_from
            );

        }


        if ($request->filled('date_to')) {

            $query->whereDate(
                'rental_date',
                '<=',
                $request->date_to
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Filter status rental
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Hitung total seluruh rental
        |--------------------------------------------------------------------------
        */

        $totalSubtotal = (clone $query)
            ->reorder()
            ->sum('subtotal');


        $totalLateFee = (clone $query)
            ->reorder()
            ->sum('late_fee');


        $totalRevenue = (clone $query)
            ->reorder()
            ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | Ambil ID rental sesuai filter
        |--------------------------------------------------------------------------
        */

        $rentalIds = (clone $query)
            ->reorder()
            ->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | Hitung total yang sudah dibayar
        |--------------------------------------------------------------------------
        */

        $totalPaid = Payment::whereIn(
            'rental_id',
            $rentalIds
        )
        ->where('status', 'lunas')
        ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Hitung total yang belum dibayar
        |--------------------------------------------------------------------------
        */

        $totalOutstanding = max(
            0,
            $totalRevenue - $totalPaid
        );


        /*
        |--------------------------------------------------------------------------
        | Ambil data rental
        |--------------------------------------------------------------------------
        */

        $rentals = $query
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Kirim ke view
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.rentals',
            compact(
                'rentals',
                'totalSubtotal',
                'totalLateFee',
                'totalRevenue',
                'totalPaid',
                'totalOutstanding'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LAPORAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function payments(Request $request)
    {
        $query = Payment::with([
            'rental.customer',
            'rental.details.vehicle',
        ])
        ->latest('payment_date');


        /*
        |--------------------------------------------------------------------------
        | Filter tanggal pembayaran
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'payment_date',
                '>=',
                $request->date_from
            );

        }


        if ($request->filled('date_to')) {

            $query->whereDate(
                'payment_date',
                '<=',
                $request->date_to
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Filter metode pembayaran
        |--------------------------------------------------------------------------
        */

        if ($request->filled('payment_method')) {

            $query->where(
                'payment_method',
                $request->payment_method
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Filter status pembayaran
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Total pembayaran sesuai filter
        |--------------------------------------------------------------------------
        */

        $totalPayment = (clone $query)
            ->reorder()
            ->where('status', 'lunas')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Total pending
        |--------------------------------------------------------------------------
        */

        $totalPending = (clone $query)
            ->reorder()
            ->where('status', 'pending')
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Total seluruh pembayaran
        |--------------------------------------------------------------------------
        */

        $totalAllPayment = (clone $query)
            ->reorder()
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Ambil data pembayaran
        |--------------------------------------------------------------------------
        */

        $payments = $query
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Kirim ke view
        |--------------------------------------------------------------------------
        */

        return view(
            'reports.payments',
            compact(
                'payments',
                'totalPayment',
                'totalPending',
                'totalAllPayment'
            )
        );
    }
}