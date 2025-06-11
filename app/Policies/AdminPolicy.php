<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;

class AdminPolicy
{
    /**
     * Determine if the user can manage bookings.
     */
    public function manage(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage vehicles.
     */
    public function manageVehicle(User $user, Vehicle $vehicle): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can access admin dashboard.
     */
    public function viewAdminDashboard(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage users.
     */
    public function manageUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view financial analytics.
     */
    public function viewFinancialAnalytics(User $user): bool
    {
        return $user->isAdmin();
    }
}
