<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginLogController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.process');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | KATEGORI KENDARAAN
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'categories',
            VehicleCategoryController::class
        )->except([
            'show'
        ]);
    });


/*
|--------------------------------------------------------------------------
| PENGGUNA
|--------------------------------------------------------------------------
|
| Hanya Admin yang dapat mengelola pengguna.
|
*/

Route::middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::resource(
            'users',
            UserController::class
        )->except([
            'show']);

        Route::get('/login-logs', [
        LoginLogController::class,
        'index'
        ])->name('login-logs.index');

    });


/*
|--------------------------------------------------------------------------
| KENDARAAN, CUSTOMER, RENTAL, LAPORAN & LOG
|--------------------------------------------------------------------------
|
| Admin dan Petugas dapat mengakses bagian ini.
|
*/

Route::middleware([
    'auth',
    'role:admin,petugas'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | KENDARAAN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'vehicles',
        VehicleController::class
    )->except([
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'customers',
        CustomerController::class
    )->except([
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | RENTAL
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'rentals',
        RentalController::class
    )->only([
        'index',
        'create',
        'store',
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/rentals/{rental}/return',
        [RentalController::class, 'returnForm']
    )->name('rentals.return');

    Route::post(
        '/rentals/{rental}/return',
        [RentalController::class, 'processReturn']
    )->name('rentals.return.process');


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/rentals/{rental}/payment',
        [RentalController::class, 'paymentForm']
    )->name('rentals.payment');

    Route::post(
        '/rentals/{rental}/payment',
        [RentalController::class, 'processPayment']
    )->name('rentals.payment.process');


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/activity-logs',
        [ActivityLogController::class, 'index']
    )->name('activity-logs.index');


    /*
    |--------------------------------------------------------------------------
    | LAPORAN RENTAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/rentals',
        [ReportController::class, 'rentals']
    )->name('reports.rentals');


    /*
    |--------------------------------------------------------------------------
    | LAPORAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/payments',
        [ReportController::class, 'payments']
    )->name('reports.payments');

});


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD PETUGAS
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            PetugasDashboardController::class,
            'index'
        ])->name('dashboard');

    });