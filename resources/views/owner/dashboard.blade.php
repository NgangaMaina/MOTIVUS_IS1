<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .owner-dashboard-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0099cc;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .action-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .action-btn {
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .action-btn.secondary {
            background: #6c757d;
        }

        .action-btn.secondary:hover {
            background: #5a6268;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }

        .user-info {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .user-info h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS</a>
            <div class="nav-links">
                <a href="{{ route('vehicles.index') }}" class="nav-link">Browse Cars</a>
                @auth
                    @if(auth()->user()->isRenter())
                        <a href="{{ route('bookings.index') }}" class="nav-link">My Bookings</a>
                    @endif
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.vehicles.index') }}" class="nav-link">My Vehicles</a>
                        <a href="{{ route('owner.bookings.index') }}" class="nav-link">Booking Requests</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; color: white;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-btn">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="owner-dashboard-page">
        <div class="dashboard-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Owner Dashboard</h1>
                <p class="page-subtitle">Welcome back, {{ auth()->user()->name }}! Manage your vehicle rental business.</p>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🚗</div>
                    <div class="stat-number">{{ auth()->user()->vehicles()->count() }}</div>
                    <div class="stat-label">My Vehicles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-number">{{ auth()->user()->vehicles()->withCount('bookings')->get()->sum('bookings_count') }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-number">{{ \App\Models\Booking::whereHas('vehicle', function($q) { $q->where('owner_id', auth()->id()); })->where('status', 'pending')->count() }}</div>
                    <div class="stat-label">Pending Requests</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-number">KSh {{ number_format(\App\Models\Booking::whereHas('vehicle', function($q) { $q->where('owner_id', auth()->id()); })->where('status', 'completed')->sum('total_amount')) }}</div>
                    <div class="stat-label">Total Earnings</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <div class="action-card">
                    <h3 class="action-title">
                        <span>🚗</span>
                        Vehicle Management
                    </h3>
                    <p class="action-description">
                        Add new vehicles to your fleet or manage existing ones. Update pricing, availability, and vehicle details.
                    </p>
                    <a href="{{ route('owner.vehicles.create') }}" class="action-btn">Add New Vehicle</a>
                    <a href="{{ route('owner.vehicles.index') }}" class="action-btn secondary">Manage Vehicles</a>
                </div>

                <div class="action-card">
                    <h3 class="action-title">
                        <span>📋</span>
                        Booking Requests
                    </h3>
                    <p class="action-description">
                        Review and manage booking requests from customers. Accept or reject requests and track ongoing rentals.
                    </p>
                    <a href="{{ route('owner.bookings.index') }}" class="action-btn">View Requests</a>
                </div>
            </div>

            <!-- User Information -->
            <div class="user-info">
                <h3>Account Information</h3>
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ auth()->user()->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ auth()->user()->email }}</span>
                </div>
                @if(auth()->user()->phone)
                    <div class="info-item">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ auth()->user()->phone }}</span>
                    </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Role</span>
                    <span class="info-value">{{ ucfirst(auth()->user()->role->name) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Member Since</span>
                    <span class="info-value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
