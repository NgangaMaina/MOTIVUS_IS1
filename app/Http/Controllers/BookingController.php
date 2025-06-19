<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class BookingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of user's bookings.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['vehicle.owner', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Vehicle $vehicle)
    {
        $this->authorize('create', Booking::class);

        if (!$vehicle->availability) {
            return back()->withErrors(['error' => 'This vehicle is not available for booking.']);
        }

        return view('bookings.create', compact('vehicle'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $this->authorize('create', Booking::class);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check if vehicle is available for the requested dates
        $conflictingBookings = $vehicle->bookings()
            ->where('status', '!=', 'completed')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                          ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['error' => 'Vehicle is not available for the selected dates.']);
        }

        // Calculate total amount
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $days * $vehicle->price_per_day;

        $booking = Booking::create([
            'renter_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking request submitted successfully!');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load(['vehicle.owner', 'payment', 'deliveryTask.driver']);
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking (renters only).
     */
    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending bookings can be cancelled.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Accept a booking (owners only).
     */
    public function accept(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending bookings can be accepted.']);
        }

        $booking->update(['status' => 'accepted']);

        return back()->with('success', 'Booking accepted successfully.');
    }

    /**
     * Reject a booking (owners only).
     */
    public function reject(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending bookings can be rejected.']);
        }

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }

    /**
     * Complete a booking (owners only).
     */
    public function complete(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'accepted') {
            return back()->withErrors(['error' => 'Only accepted bookings can be completed.']);
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking marked as completed.');
    }

    /**
     * Display owner's booking requests.
     */
    public function ownerIndex()
    {
        $bookings = Booking::whereHas('vehicle', function ($query) {
            $query->where('owner_id', Auth::id());
        })
        ->with(['vehicle', 'renter', 'payment'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('owner.bookings.index', compact('bookings'));
    }

    /**
     * Assign a driver to a booking (owners only).
     */
    public function assignDriverForm(Booking $booking)
    {
        $this->authorize('manage', $booking);
        // Only allow for accepted bookings
        if ($booking->status !== 'accepted') {
            return back()->withErrors(['error' => 'You can only assign a driver to accepted bookings.']);
        }
        // Get all drivers
        $drivers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'driver');
        })->get();
        return view('owner.bookings.assign_driver', compact('booking', 'drivers'));
    }

    public function assignDriver(Request $request, Booking $booking)
    {
        $this->authorize('manage', $booking);
        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);
        // Only allow for accepted bookings
        if ($booking->status !== 'accepted') {
            return back()->withErrors(['error' => 'You can only assign a driver to accepted bookings.']);
        }
        // Create or update delivery task
        $deliveryTask = $booking->deliveryTask;
        if (!$deliveryTask) {
            $deliveryTask = new \App\Models\DeliveryTask();
            $deliveryTask->booking_id = $booking->id;
        }
        $deliveryTask->driver_id = $request->driver_id;
        $deliveryTask->status = 'assigned';
        $deliveryTask->save();
        return redirect()->route('owner.bookings.index')->with('success', 'Driver assigned successfully!');
    }
}
