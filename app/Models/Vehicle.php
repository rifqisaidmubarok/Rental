<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'brand',
        'plate_number',
        'year',
        'price_per_day',
        'status',
        'description',
    ];

    protected $casts = [
        'year' => 'integer',
        'price_per_day' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            VehicleCategory::class,
            'category_id'
        );
    }

    public function rentalDetails(): HasMany
    {
        return $this->hasMany(RentalDetail::class);
    }
}