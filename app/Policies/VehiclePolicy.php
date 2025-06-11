<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    /**
     * Determine whether the user can view any vehicles.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view available vehicles
    }

    /**
     * Determine whether the user can view the vehicle.
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return true; // Anyone can view individual vehicles
    }

    /**
     * Determine whether the user can create vehicles.
     */
    public function create(User $user): bool
    {
        return $user->isOwner(); // Only owners can create vehicles
    }

    /**
     * Determine whether the user can update the vehicle.
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->isOwner() && $user->id === $vehicle->owner_id;
    }

    /**
     * Determine whether the user can delete the vehicle.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->isOwner() && $user->id === $vehicle->owner_id;
    }

    /**
     * Determine whether the user can view their own vehicles.
     */
    public function viewOwn(User $user): bool
    {
        return $user->isOwner();
    }
}
