<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'driver_id',
        'status',
        'delivered_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivered_at' => 'datetime',
            'status' => 'string',
        ];
    }

    /**
     * Get the booking that owns the delivery task.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the driver that owns the delivery task.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Scope a query to only include assigned delivery tasks.
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope a query to only include en route delivery tasks.
     */
    public function scopeEnRoute($query)
    {
        return $query->where('status', 'en_route');
    }

    /**
     * Scope a query to only include delivered delivery tasks.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Check if the delivery task is assigned.
     */
    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Check if the delivery task is en route.
     */
    public function isEnRoute(): bool
    {
        return $this->status === 'en_route';
    }

    /**
     * Check if the delivery task is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    /**
     * Mark the delivery task as en route.
     */
    public function markAsEnRoute(): bool
    {
        return $this->update(['status' => 'en_route']);
    }

    /**
     * Mark the delivery task as delivered.
     */
    public function markAsDelivered(): bool
    {
        return $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }
}
