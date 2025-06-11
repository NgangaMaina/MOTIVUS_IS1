<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'rating',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Get the booking that owns the vehicle review.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the vehicle through the booking relationship.
     */
    public function vehicle(): BelongsTo
    {
        return $this->booking()->with('vehicle')->first()->vehicle ?? null;
    }

    /**
     * Get the renter through the booking relationship.
     */
    public function renter(): BelongsTo
    {
        return $this->booking()->with('renter')->first()->renter ?? null;
    }

    /**
     * Scope a query to only include reviews with a specific rating.
     */
    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope a query to only include reviews with rating above a threshold.
     */
    public function scopeHighRated($query, int $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope a query to only include reviews with rating below a threshold.
     */
    public function scopeLowRated($query, int $maxRating = 2)
    {
        return $query->where('rating', '<=', $maxRating);
    }

    /**
     * Check if the review is positive (4-5 stars).
     */
    public function isPositive(): bool
    {
        return $this->rating >= 4;
    }

    /**
     * Check if the review is negative (1-2 stars).
     */
    public function isNegative(): bool
    {
        return $this->rating <= 2;
    }

    /**
     * Check if the review is neutral (3 stars).
     */
    public function isNeutral(): bool
    {
        return $this->rating === 3;
    }
}
