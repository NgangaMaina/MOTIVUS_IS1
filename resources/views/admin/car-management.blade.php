<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management - MOTIVUS Admin</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .admin-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .page-header {
            background: linear-gradient(135deg, #28a745, #1e7e34);
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
        
        .filters-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }
        
        .form-group {
            margin-bottom: 0;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }
        
        .btn-filter {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        
        .vehicles-grid {
            display: grid;
            gap: 20px;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: 200px 1fr auto;
            gap: 20px;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .vehicle-card {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
        
        .vehicle-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .vehicle-image {
            width: 200px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #666;
        }
        
        .vehicle-info {
            flex: 1;
        }
        
        .vehicle-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .vehicle-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .detail-value {
            font-weight: 600;
            color: #333;
        }
        
        .price-value {
            color: #28a745 !important;
            font-size: 1.1rem !important;
        }
        
        .owner-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        
        .owner-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .owner-contact {
            font-size: 0.9rem;
            color: #666;
        }
        
        .vehicle-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 150px;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .status-available {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-unavailable {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            border: none;
            display: inline-block;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background: #218838;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .btn-suspend {
            background: #dc3545;
            color: white;
        }
        
        .btn-suspend:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .btn-view {
            background: #007bff;
            color: white;
        }
        
        .btn-view:hover {
            background: #0056b3;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .booking-stats {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
        }
        
        .booking-count {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1976d2;
        }
        
        .booking-label {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <!-- Admin Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS ADMIN</a>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('admin.rental-requests') }}" class="nav-link">Rental Requests</a>
                <a href="{{ route('admin.car-management') }}" class="nav-link active">Car Management</a>
                <a href="{{ route('admin.user-management') }}" class="nav-link">Users</a>
                <a href="{{ route('admin.financial-analytics') }}" class="nav-link">Analytics</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; color: white;">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="admin-page">
        <div class="page-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Car Management</h1>
                <p class="page-subtitle">Monitor and manage all vehicles on the platform</p>
            </div>

            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" action="{{ route('admin.car-management') }}">
                    <div class="filters-grid">
                        <div class="form-group">
                            <label for="availability" class="form-label">Availability</label>
                            <select id="availability" name="availability" class="form-input">
                                <option value="">All Vehicles</option>
                                <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="owner_id" class="form-label">Owner</label>
                            <select id="owner_id" name="owner_id" class="form-input">
                                <option value="">All Owners</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" id="search" name="search" class="form-input" 
                                   placeholder="Make or model..." value="{{ request('search') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-filter">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Vehicles -->
            @if($vehicles->count() > 0)
                <div class="vehicles-grid">
                    @foreach($vehicles as $vehicle)
                        <div class="vehicle-card">
                            <!-- Vehicle Image -->
                            <div class="vehicle-image">
                                @if($vehicle->image_url)
                                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->full_name }}" class="vehicle-image">
                                @else
                                    🚗
                                @endif
                            </div>

                            <!-- Vehicle Information -->
                            <div class="vehicle-info">
                                <h3 class="vehicle-name">{{ $vehicle->full_name }}</h3>
                                
                                <div class="vehicle-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Year</div>
                                        <div class="detail-value">{{ $vehicle->year }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Location</div>
                                        <div class="detail-value">{{ $vehicle->location }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">Price per Day</div>
                                        <div class="detail-value price-value">KSh {{ number_format($vehicle->price_per_day) }}</div>
                                    </div>
                                </div>

                                <!-- Owner Information -->
                                <div class="owner-info">
                                    <div class="owner-name">{{ $vehicle->owner->name }}</div>
                                    <div class="owner-contact">{{ $vehicle->owner->email }}</div>
                                    @if($vehicle->owner->phone)
                                        <div class="owner-contact">{{ $vehicle->owner->phone }}</div>
                                    @endif
                                </div>

                                <!-- Booking Statistics -->
                                <div class="booking-stats">
                                    <div class="booking-count">{{ $vehicle->bookings->count() }}</div>
                                    <div class="booking-label">Total Bookings</div>
                                </div>
                            </div>

                            <!-- Vehicle Actions -->
                            <div class="vehicle-actions">
                                <!-- Status Badge -->
                                <div class="status-badge {{ $vehicle->availability ? 'status-available' : 'status-unavailable' }}">
                                    {{ $vehicle->availability ? 'Available' : 'Unavailable' }}
                                </div>

                                <!-- Action Buttons -->
                                @if($vehicle->availability)
                                    <form method="POST" action="{{ route('admin.suspend-vehicle', $vehicle) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-suspend" onclick="return confirm('Suspend this vehicle?')">
                                            Suspend
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.approve-vehicle', $vehicle) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this vehicle?')">
                                            Approve
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-view">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($vehicles->hasPages())
                    <div class="pagination-wrapper">
                        {{ $vehicles->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">🚗</div>
                    <h3>No Vehicles Found</h3>
                    <p>No vehicles match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
