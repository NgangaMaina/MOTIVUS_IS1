<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Vehicles - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .vehicles-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .vehicles-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        
        .filters-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .vehicle-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(45deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #999;
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
            font-size: 1.5rem;
            font-weight: 700;
            color: #0099cc;
            margin-bottom: 15px;
        }
        
        .vehicle-location {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .btn-rent {
            width: 100%;
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-rent:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .no-vehicles {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        
        .user-profile-section {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            flex-wrap: wrap;
            background: #f8fafc;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(37,99,235,0.07);
            padding: 32px 28px;
            margin-top: 40px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .user-profile-section h2 {
            color: #2563eb;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        
        .user-profile-section .form-group {
            margin-bottom: 12px;
        }
        
        .user-profile-section .form-group label {
            font-weight: 600;
            color: #2563eb;
        }
        
        .user-profile-section .form-input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1.5px solid #c7d2fe;
        }
        
        .user-profile-section button[type="submit"] {
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1.1rem;
            margin-top: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        @media (max-width: 768px) {
            .vehicle-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title {
                font-size: 2rem;
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
                    <a href="{{ route('bookings.index') }}" class="nav-link">My Bookings</a>
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.vehicles.index') }}" class="nav-link">My Vehicles</a>
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

    <div class="vehicles-page">
        <div class="vehicles-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Find Your Perfect Ride</h1>
                <p class="page-subtitle">Choose from our wide selection of vehicles in Nairobi</p>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" action="{{ route('vehicles.index') }}">
                    <div class="filters-grid">
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <select name="location" class="form-input">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Make</label>
                            <select name="make" class="form-input">
                                <option value="">All Makes</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                                        {{ $make }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Min Price (KSh/day)</label>
                            <input type="number" name="min_price" class="form-input" placeholder="0" value="{{ request('min_price') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Max Price (KSh/day)</label>
                            <input type="number" name="max_price" class="form-input" placeholder="10000" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" class="primary-btn" style="max-width: 200px;">
                            Search Vehicles
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="google-btn" style="max-width: 200px; margin-left: 10px;">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Vehicles Grid -->
            @if($vehicles->count() > 0)
                <div class="vehicle-grid">
                    @foreach($vehicles as $vehicle)
                        <div class="vehicle-card">
                            <div class="vehicle-image">
                                @if($vehicle->image_url)
                                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->full_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    🚗
                                @endif
                            </div>
                            <div class="vehicle-info">
                                <h3 class="vehicle-name">{{ $vehicle->full_name }}</h3>
                                <div class="vehicle-details">
                                    @if($vehicle->year) {{ $vehicle->year }} • @endif
                                    Owner: {{ $vehicle->owner->name }}
                                </div>
                                <div class="vehicle-price">KSh {{ number_format($vehicle->price_per_day) }}/day</div>
                                <div class="vehicle-location">📍 {{ $vehicle->location }}</div>
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-rent">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $vehicles->withQueryString()->links() }}
                </div>
            @else
                <div class="no-vehicles">
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your search filters or check back later for new listings.</p>
                </div>
            @endif

            <!-- User Profile Section -->
            <div class="user-profile-section" style="display: flex; gap: 32px; align-items: flex-start; flex-wrap: wrap; background: #f8fafc; border-radius: 18px; box-shadow: 0 4px 18px rgba(37,99,235,0.07); padding: 32px 28px; margin-top: 40px; max-width: 800px; margin-left: auto; margin-right: auto;">
                <div style="min-width: 220px; flex: 1;">
                    <h2 style="color: #2563eb; font-size: 1.6rem; font-weight: 700; margin-bottom: 18px;">Profile</h2>
                    <div style="margin-bottom: 18px;">
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Name:</b> {{ auth()->user()->name }}</div>
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Email:</b> {{ auth()->user()->email }}</div>
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Phone:</b> {{ auth()->user()->phone ?? '-' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" style="flex: 1; min-width: 260px; max-width: 340px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(37,99,235,0.05); padding: 24px 20px;">
                    @csrf
                    @method('PUT')
                    <h4 style="color: #2563eb; font-size: 1.1rem; font-weight: 600; margin-bottom: 16px;">Update Info</h4>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #2563eb;">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #c7d2fe;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #2563eb;">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #c7d2fe;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #2563eb;">Phone</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #c7d2fe;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #2563eb;">Password <span style="font-weight:400; color:#64748b;">(leave blank to keep current)</span></label>
                        <input type="password" name="password" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #c7d2fe;">
                    </div>
                    <button type="submit" style="background: linear-gradient(90deg, #2563eb, #60a5fa); color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 12px 32px; font-size: 1.1rem; margin-top: 8px; cursor: pointer; transition: background 0.2s;">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
