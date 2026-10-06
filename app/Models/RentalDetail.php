<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalDetail extends Model
{
    protected $fillable = [
        'rental_id',
        'vehicle_id',
        'price_per_day',
        'duration',
        'subtotal',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'duration' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}