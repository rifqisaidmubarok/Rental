<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Rental;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();

        $availableVehicles = Vehicle::where(
            'status',
            'tersedia'
        )->count();

        $rentedVehicles = Vehicle::where(
            'status',
            'disewa'
        )->count();

        $serviceVehicles = Vehicle::where(
            'status',
            'servis'
        )->count();

        $totalCustomers = Customer::count();

        $totalRentals = Rental::count();

        $activeRentals = Rental::whereIn(
            'status',
            ['menunggu', 'disewa', 'terlambat']
        )->count();

        $lateRentals = Rental::where(
            'status',
            'terlambat'
        )->count();

        $totalRevenue = Payment::where(
            'status',
            'lunas'
        )->sum('amount');

        $recentRentals = Rental::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'petugas.dashboard',
            compact(
                'totalVehicles',
                'availableVehicles',
                'rentedVehicles',
                'serviceVehicles',
                'totalCustomers',
                'totalRentals',
                'activeRentals',
                'lateRentals',
                'totalRevenue',
                'recentRentals'
            )
        );
    }
}