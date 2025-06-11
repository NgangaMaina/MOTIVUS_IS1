<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Vehicles - MOTIVUS Owner Dashboard</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .owner-dashboard {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .dashboard-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #0099cc;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .vehicles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .vehicle-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .vehicle-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(45deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #999;
            position: relative;
        }
        
        .vehicle-status {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-available {
            background: #d4edda;
            color: #155724;
        }
        
        .status-unavailable {
            background: #f8d7da;
            color: #721c24;
        }
        
        .vehicle-info {
            padding: 20px;
        }
        
        .vehicle-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .vehicle-details {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .vehicle-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0099cc;
            margin-bottom: 15px;
        }
        
        .vehicle-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .vehicle-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit {
            flex: 1;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-edit:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .no-vehicles {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .no-vehicles-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 2rem;
            }
            
            .vehicles-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-bar {
                flex-direction: column;
                align-items: stretch;
            }
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
                        <a href="{{ route('owner.vehicles.index') }}" class="nav-link active">My Vehicles</a>
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

    <div class="owner-dashboard">
        <div class="dashboard-container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Welcome, {{ auth()->user()->name }}!</h1>
                <p class="dashboard-subtitle">Manage your vehicle listings and track your rental business</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $vehicles->total() }}</div>
                    <div class="stat-label">Total Vehicles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $vehicles->where('availability', true)->count() }}</div>
                    <div class="stat-label">Available</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $vehicles->sum('total_bookings') }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">KSh {{ number_format($vehicles->sum('price_per_day')) }}</div>
                    <div class="stat-label">Daily Revenue Potential</div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <h2 style="margin: 0; color: #333;">My Vehicle Listings</h2>
                <a href="{{ route('owner.vehicles.create') }}" class="primary-btn">
                    + Add New Vehicle
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Vehicles Grid -->
            @if($vehicles->count() > 0)
                <div class="vehicles-grid">
                    @foreach($vehicles as $vehicle)
                        <div class="vehicle-card">
                            <div class="vehicle-image">
                                @if($vehicle->image_url)
                                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->full_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    🚗
                                @endif
                                <div class="vehicle-status {{ $vehicle->availability ? 'status-available' : 'status-unavailable' }}">
                                    {{ $vehicle->availability ? 'Available' : 'Unavailable' }}
                                </div>
                            </div>
                            <div class="vehicle-info">
                                <h3 class="vehicle-name">{{ $vehicle->full_name }}</h3>
                                <div class="vehicle-details">📍 {{ $vehicle->location }}</div>
                                <div class="vehicle-price">KSh {{ number_format($vehicle->price_per_day) }}/day</div>
                                <div class="vehicle-stats">
                                    <span>{{ $vehicle->total_bookings }} bookings</span>
                                    <span>Listed {{ $vehicle->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="vehicle-actions">
                                    <a href="{{ route('owner.vehicles.edit', $vehicle) }}" class="btn-edit">
                                        Edit Vehicle
                                    </a>
                                    <form method="POST" action="{{ route('owner.vehicles.destroy', $vehicle) }}" style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: center; margin-top: 40px;">
                    {{ $vehicles->links() }}
                </div>
            @else
                <div class="no-vehicles">
                    <div class="no-vehicles-icon">🚗</div>
                    <h3>No vehicles listed yet</h3>
                    <p>Start earning by listing your first vehicle!</p>
                    <a href="{{ route('owner.vehicles.create') }}" class="primary-btn" style="margin-top: 20px;">
                        List Your First Vehicle
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
