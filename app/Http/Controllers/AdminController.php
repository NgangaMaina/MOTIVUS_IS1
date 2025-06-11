<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\DeliveryTask;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // No parent constructor to call in Laravel 11
    }

    /**
     * Check if the current user is an admin
     */
    private function checkAdminAccess()
    {
        $user = User::with('role')->find(Auth::id());
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Access denied. Admin privileges required.');
        }
    }

    /**
     * Admin Dashboard with Analytics
     */
    public function dashboard()
    {
        $this->checkAdminAccess();
        // Get key metrics
        $totalUsers = User::count();
        $totalVehicles = Vehicle::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::successful()->sum('amount');
        
        // Recent activity
        $recentBookings = Booking::with(['renter', 'vehicle.owner'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $pendingBookings = Booking::pending()->count();
        $activeBookings = Booking::accepted()->count();
        
        // Monthly revenue data for chart
        $monthlyRevenue = Payment::successful()
            ->selectRaw('MONTH(paid_at) as month, YEAR(paid_at) as year, SUM(amount) as total')
            ->whereYear('paid_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
            
        // User distribution by role
        $usersByRole = User::select('roles.name', DB::raw('count(*) as count'))
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->get();
            
        // Top performing vehicles
        $topVehicles = Vehicle::withCount(['bookings as total_bookings'])
            ->with('owner')
            ->having('total_bookings', '>', 0)
            ->orderBy('total_bookings', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalVehicles', 'totalBookings', 'totalRevenue',
            'recentBookings', 'pendingBookings', 'activeBookings',
            'monthlyRevenue', 'usersByRole', 'topVehicles'
        ));
    }

    /**
     * Rental Requests Management
     */
    public function rentalRequests(Request $request)
    {
        $this->checkAdminAccess();
        $query = Booking::with(['renter', 'vehicle.owner', 'payment']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.rental-requests', compact('bookings'));
    }

    /**
     * Approve a rental request
     */
    public function approveRental(Booking $booking)
    {
        $this->authorize('manage', $booking);
        
        $booking->update(['status' => 'accepted']);
        
        return back()->with('success', 'Rental request approved successfully.');
    }

    /**
     * Reject a rental request
     */
    public function rejectRental(Booking $booking)
    {
        $this->authorize('manage', $booking);
        
        $booking->update(['status' => 'rejected']);
        
        return back()->with('success', 'Rental request rejected.');
    }

    /**
     * Car Management Dashboard
     */
    public function carManagement(Request $request)
    {
        $this->checkAdminAccess();
        $query = Vehicle::with(['owner', 'bookings']);
        
        // Filter by availability
        if ($request->filled('availability')) {
            $query->where('availability', $request->availability === 'available');
        }
        
        // Filter by owner
        if ($request->filled('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }
        
        // Search by make/model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }
        
        $vehicles = $query->orderBy('created_at', 'desc')->paginate(20);
        $owners = User::where('role_id', Role::where('name', 'owner')->first()->id)->get();
        
        return view('admin.car-management', compact('vehicles', 'owners'));
    }

    /**
     * Approve a vehicle
     */
    public function approveVehicle(Vehicle $vehicle)
    {
        $this->authorize('manage', $vehicle);
        
        $vehicle->update(['availability' => true]);
        
        return back()->with('success', 'Vehicle approved and made available.');
    }

    /**
     * Suspend a vehicle
     */
    public function suspendVehicle(Vehicle $vehicle)
    {
        $this->authorize('manage', $vehicle);
        
        $vehicle->update(['availability' => false]);
        
        return back()->with('success', 'Vehicle suspended from listings.');
    }

    /**
     * User Management
     */
    public function userManagement(Request $request)
    {
        $query = User::with('role');
        
        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        // Search by name/email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        $roles = Role::all();
        
        return view('admin.user-management', compact('users', 'roles'));
    }

    /**
     * Financial Analytics
     */
    public function financialAnalytics(Request $request)
    {
        $period = $request->get('period', 'month'); // month, quarter, year
        
        // Revenue analytics
        $totalRevenue = Payment::successful()->sum('amount');
        $pendingPayments = Payment::pending()->sum('amount');
        $failedPayments = Payment::failed()->count();
        
        // Revenue by period
        $revenueData = $this->getRevenueByPeriod($period);
        
        // Top earning vehicles
        $topEarningVehicles = Vehicle::select('vehicles.*')
            ->join('bookings', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->join('payments', 'bookings.id', '=', 'payments.booking_id')
            ->where('payments.status', 'success')
            ->groupBy('vehicles.id')
            ->orderByRaw('SUM(payments.amount) DESC')
            ->with(['owner', 'bookings.payment'])
            ->limit(10)
            ->get();
            
        // Payment method distribution
        $paymentStats = Payment::selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get();
        
        return view('admin.financial-analytics', compact(
            'totalRevenue', 'pendingPayments', 'failedPayments',
            'revenueData', 'topEarningVehicles', 'paymentStats', 'period'
        ));
    }

    /**
     * System Activity Monitor
     */
    public function systemActivity()
    {
        // Recent user registrations
        $recentUsers = User::with('role')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Recent vehicle listings
        $recentVehicles = Vehicle::with('owner')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Active delivery tasks
        $activeDeliveries = DeliveryTask::with(['booking.vehicle', 'booking.renter', 'driver'])
            ->whereIn('status', ['assigned', 'en_route'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // System metrics
        $metrics = [
            'daily_signups' => User::whereDate('created_at', today())->count(),
            'daily_bookings' => Booking::whereDate('created_at', today())->count(),
            'daily_revenue' => Payment::successful()->whereDate('paid_at', today())->sum('amount'),
            'active_users' => User::where('updated_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('admin.system-activity', compact(
            'recentUsers', 'recentVehicles', 'activeDeliveries', 'metrics'
        ));
    }

    /**
     * Get revenue data by period for charts
     */
    private function getRevenueByPeriod($period)
    {
        switch ($period) {
            case 'year':
                return Payment::successful()
                    ->selectRaw('YEAR(paid_at) as period, SUM(amount) as total')
                    ->groupBy('period')
                    ->orderBy('period', 'desc')
                    ->limit(5)
                    ->get();
                    
            case 'quarter':
                return Payment::successful()
                    ->selectRaw('YEAR(paid_at) as year, QUARTER(paid_at) as quarter, SUM(amount) as total')
                    ->groupBy('year', 'quarter')
                    ->orderBy('year', 'desc')
                    ->orderBy('quarter', 'desc')
                    ->limit(8)
                    ->get();
                    
            default: // month
                return Payment::successful()
                    ->selectRaw('YEAR(paid_at) as year, MONTH(paid_at) as month, SUM(amount) as total')
                    ->groupBy('year', 'month')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->limit(12)
                    ->get();
        }
    }
}
