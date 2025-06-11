<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VehicleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of available vehicles for renters.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with('owner')->available();

        // Apply filters
        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->byPriceRange($request->min_price, $request->max_price);
        }

        if ($request->filled('make')) {
            $query->where('make', 'like', '%' . $request->make . '%');
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Sort by price or newest
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['price_per_day', 'created_at', 'year'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $vehicles = $query->paginate(12);

        // Get filter options
        $locations = Vehicle::distinct()->pluck('location')->filter();
        $makes = Vehicle::distinct()->pluck('make')->filter();
        $years = Vehicle::distinct()->pluck('year')->filter()->sort()->reverse();

        return view('vehicles.index', compact('vehicles', 'locations', 'makes', 'years'));
    }

    /**
     * Display the specified vehicle for renters.
     */
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['owner', 'bookings.vehicleReview']);
        
        // Get reviews for this vehicle
        $reviews = $vehicle->bookings()
            ->whereHas('vehicleReview')
            ->with(['vehicleReview', 'renter'])
            ->get()
            ->pluck('vehicleReview');

        $averageRating = $reviews->avg('rating');
        
        return view('vehicles.show', compact('vehicle', 'reviews', 'averageRating'));
    }

    /**
     * Show the form for creating a new vehicle (owners only).
     */
    public function create()
    {
        $this->authorize('create', Vehicle::class);
        return view('vehicles.create');
    }

    /**
     * Store a newly created vehicle (owners only).
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'location' => 'required|string|max:100',
            'price_per_day' => 'required|numeric|min:0|max:999999.99',
            'image_url' => 'nullable|url|max:2000',
        ]);

        $validated['owner_id'] = Auth::id();
        $validated['availability'] = true;

        $vehicle = Vehicle::create($validated);

        return redirect()->route('owner.vehicles.index')
            ->with('success', 'Vehicle listed successfully! It will be available for rent once approved.');
    }

    /**
     * Show the form for editing the specified vehicle (owners only).
     */
    public function edit(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle (owners only).
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $validated = $request->validate([
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'location' => 'required|string|max:100',
            'price_per_day' => 'required|numeric|min:0|max:999999.99',
            'availability' => 'boolean',
            'image_url' => 'nullable|url|max:2000',
        ]);

        $vehicle->update($validated);

        return redirect()->route('owner.vehicles.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    /**
     * Remove the specified vehicle (owners only).
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        // Check if vehicle has active bookings
        $activeBookings = $vehicle->bookings()
            ->whereIn('status', ['pending', 'accepted'])
            ->count();

        if ($activeBookings > 0) {
            return back()->withErrors(['error' => 'Cannot delete vehicle with active bookings.']);
        }

        $vehicle->delete();

        return redirect()->route('owner.vehicles.index')
            ->with('success', 'Vehicle removed successfully!');
    }

    /**
     * Display owner's vehicles (owners only).
     */
    public function ownerIndex()
    {
        $this->authorize('viewOwn', Vehicle::class);
        
        $vehicles = Auth::user()->vehicles()
            ->withCount(['bookings as total_bookings'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('owner.vehicles.index', compact('vehicles'));
    }
}
