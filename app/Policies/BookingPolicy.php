<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can view any bookings.
     */
    public function viewAny(User $user): bool
    {
        return $user->isRenter() || $user->isOwner();
    }

    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        // Renter can view their own bookings
        if ($user->isRenter() && $user->id === $booking->renter_id) {
            return true;
        }

        // Owner can view bookings for their vehicles
        if ($user->isOwner() && $user->id === $booking->vehicle->owner_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create bookings.
     */
    public function create(User $user): bool
    {
        return $user->isRenter();
    }

    /**
     * Determine whether the user can cancel the booking.
     */
    public function cancel(User $user, Booking $booking): bool
    {
        return $user->isRenter() && $user->id === $booking->renter_id;
    }

    /**
     * Determine whether the user can manage the booking (accept/reject/complete).
     */
    public function manage(User $user, Booking $booking): bool
    {
        return $user->isOwner() && $user->id === $booking->vehicle->owner_id;
    }
}
