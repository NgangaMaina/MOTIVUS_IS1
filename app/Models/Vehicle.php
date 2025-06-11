<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'make',
        'model',
        'year',
        'location',
        'price_per_day',
        'availability',
        'image_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'availability' => 'boolean',
            'price_per_day' => 'decimal:2',
            'year' => 'integer',
        ];
    }

    /**
     * Get the owner that owns the vehicle.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the bookings for the vehicle.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }



    /**
     * Scope a query to only include available vehicles.
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability', true);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopeByPriceRange($query, float $minPrice = null, float $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price_per_day', '>=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $query->where('price_per_day', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Get the full vehicle name (make + model + year).
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->make . ' ' . $this->model . ' ' . $this->year);
    }
}
