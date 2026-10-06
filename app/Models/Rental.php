<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    protected $fillable = [
        'rental_code',
        'customer_id',
        'rental_date',
        'return_date',
        'actual_return_date',
        'subtotal',
        'late_fee',
        'total',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',

        'subtotal' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(RentalDetail::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}