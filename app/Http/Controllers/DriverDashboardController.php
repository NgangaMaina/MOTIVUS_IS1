<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverDashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        // Fetch delivery tasks assigned to this driver
        $tasks = DeliveryTask::with(['booking.vehicle', 'booking.renter'])
            ->where('driver_id', $driver->id)
            ->orderByDesc('created_at')
            ->get();
        $pending = $tasks->whereIn('status', ['assigned', 'en_route', 'approved']);
        $completed = $tasks->where('status', 'delivered');
        return view('driver.dashboard', compact('pending', 'completed'));
    }

    public function markAsDelivered($id)
    {
        $task = DeliveryTask::findOrFail($id);
        if ($task->driver_id !== Auth::id()) abort(403);
        $task->markAsDelivered();
        return back()->with('success', 'Marked as delivered!');
    }

    public function denyTask($id)
    {
        $task = DeliveryTask::findOrFail($id);
        if ($task->driver_id !== Auth::id()) abort(403);
        $task->update(['status' => 'denied']);
        return back()->with('error', 'Delivery denied.');
    }

    public function acceptTask($id)
    {
        $task = DeliveryTask::findOrFail($id);
        if ($task->driver_id !== Auth::id()) abort(403);
        if ($task->status !== 'assigned') {
            return back()->with('error', 'Only assigned tasks can be accepted.');
        }
        $task->update(['status' => 'en_route']);
        return back()->with('success', 'Delivery request accepted.');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('driver.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('driver.dashboard')->with('success', 'Profile updated successfully.');
    }
}
