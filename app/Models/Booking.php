<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'renter_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'status',
        'total_amount',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_amount' => 'decimal:2',
            'status' => 'string',
        ];
    }

    /**
     * Get the renter that owns the booking.
     */
    public function renter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    /**
     * Get the vehicle that belongs to the booking.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the payment associated with the booking.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the delivery task associated with the booking.
     */
    public function deliveryTask(): HasOne
    {
        return $this->hasOne(DeliveryTask::class);
    }

    /**
     * Get the vehicle review associated with the booking.
     */
    public function vehicleReview(): HasOne
    {
        return $this->hasOne(VehicleReview::class);
    }

    /**
     * Scope a query to only include bookings with a specific status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted bookings.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the duration of the booking in days.
     */
    public function getDurationAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Check if the booking is currently active.
     */
    public function isActive(): bool
    {
        $today = now()->toDateString();
        return $this->start_date <= $today && $this->end_date >= $today && $this->status === 'accepted';
    }
}
