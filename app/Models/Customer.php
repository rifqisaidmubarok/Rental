<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'nik',
        'name',
        'phone',
        'address',
        'driver_license',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}