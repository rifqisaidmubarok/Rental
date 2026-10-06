<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['email' => 'admin@rental.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@rental.com'],
            [
                'name' => 'Petugas Rental',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KATEGORI KENDARAAN
        |--------------------------------------------------------------------------
        */

        $mobil = VehicleCategory::updateOrCreate(
            ['name' => 'Mobil'],
            [
                'description' => 'Kendaraan roda empat',
            ]
        );

        $motor = VehicleCategory::updateOrCreate(
            ['name' => 'Motor'],
            [
                'description' => 'Kendaraan roda dua',
            ]
        );

        $suv = VehicleCategory::updateOrCreate(
            ['name' => 'SUV'],
            [
                'description' => 'Sport Utility Vehicle',
            ]
        );

        $minibus = VehicleCategory::updateOrCreate(
            ['name' => 'Minibus'],
            [
                'description' => 'Kendaraan keluarga',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KENDARAAN
        |--------------------------------------------------------------------------
        */

        Vehicle::updateOrCreate(
            ['code' => 'MOB001'],
            [
                'category_id' => $mobil->id,
                'name' => 'Avanza',
                'brand' => 'Toyota',
                'plate_number' => 'BK 1234 AB',
                'year' => 2022,
                'price_per_day' => 350000,
                'status' => 'tersedia',
                'description' => 'Toyota Avanza nyaman untuk keluarga.',
            ]
        );

        Vehicle::updateOrCreate(
            ['code' => 'MOB002'],
            [
                'category_id' => $mobil->id,
                'name' => 'Brio',
                'brand' => 'Honda',
                'plate_number' => 'BK 2345 CD',
                'year' => 2023,
                'price_per_day' => 300000,
                'status' => 'tersedia',
                'description' => 'Honda Brio hemat dan praktis.',
            ]
        );

        Vehicle::updateOrCreate(
            ['code' => 'MTR001'],
            [
                'category_id' => $motor->id,
                'name' => 'Vario 160',
                'brand' => 'Honda',
                'plate_number' => 'BK 3456 EF',
                'year' => 2023,
                'price_per_day' => 100000,
                'status' => 'tersedia',
                'description' => 'Honda Vario 160.',
            ]
        );

        Vehicle::updateOrCreate(
            ['code' => 'MTR002'],
            [
                'category_id' => $motor->id,
                'name' => 'NMAX',
                'brand' => 'Yamaha',
                'plate_number' => 'BK 4567 GH',
                'year' => 2022,
                'price_per_day' => 150000,
                'status' => 'tersedia',
                'description' => 'Yamaha NMAX nyaman untuk perjalanan jauh.',
            ]
        );

        Vehicle::updateOrCreate(
            ['code' => 'SUV001'],
            [
                'category_id' => $suv->id,
                'name' => 'Fortuner',
                'brand' => 'Toyota',
                'plate_number' => 'BK 5678 IJ',
                'year' => 2021,
                'price_per_day' => 750000,
                'status' => 'tersedia',
                'description' => 'Toyota Fortuner.',
            ]
        );

        Vehicle::updateOrCreate(
            ['code' => 'MB001'],
            [
                'category_id' => $minibus->id,
                'name' => 'Innova Reborn',
                'brand' => 'Toyota',
                'plate_number' => 'BK 6789 KL',
                'year' => 2022,
                'price_per_day' => 550000,
                'status' => 'tersedia',
                'description' => 'Toyota Innova Reborn.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        Customer::updateOrCreate(
            ['nik' => '1275010101010001'],
            [
                'name' => 'Said',
                'phone' => '081234567801',
                'address' => 'Binjai',
                'driver_license' => 'SIM001SAID',
            ]
        );

        Customer::updateOrCreate(
            ['nik' => '1275010101010002'],
            [
                'name' => 'Wahyu',
                'phone' => '081234567802',
                'address' => 'Medan',
                'driver_license' => 'SIM002MARIO',
            ]
        );

        Customer::updateOrCreate(
            ['nik' => '1275010101010003'],
            [
                'name' => 'Piki',
                'phone' => '081234567803',
                'address' => 'Binjai',
                'driver_license' => 'SIM003WAHYU',
            ]
        );

        Customer::updateOrCreate(
            ['nik' => '1275010101010004'],
            [
                'name' => 'Irham',
                'phone' => '081234567804',
                'address' => 'Langkat',
                'driver_license' => 'SIM004IRHAM',
            ]
        );
    }
}