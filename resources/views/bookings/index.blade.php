<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .bookings-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .bookings-container {
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
        
        .bookings-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: 1fr;
        }
        
        @media (min-width: 768px) {
            .bookings-grid {
                grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            }
        }
        
        .booking-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .vehicle-image {
            height: 180px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .vehicle-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .vehicle-image-fallback {
            font-size: 3rem;
            color: #ccc;
        }
        
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-accepted {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .booking-info {
            padding: 20px;
        }
        
        .vehicle-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .vehicle-location {
            color: #666;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }
        
        .booking-dates {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        
        .date-item {
            text-align: center;
        }
        
        .date-label {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 2px;
        }
        
        .date-value {
            color: #333;
            font-weight: 600;
        }
        
        .booking-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .duration {
            color: #666;
            font-size: 0.9rem;
        }
        
        .total-amount {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0099cc;
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
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }
        
        .empty-state p {
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .browse-btn {
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .browse-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        
        .pagination {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .pagination a,
        .pagination span {
            padding: 10px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .pagination a {
            background: white;
            color: #666;
            border: 1px solid #dee2e6;
        }
        
        .pagination a:hover {
            background: #0099cc;
            color: white;
            border-color: #0099cc;
        }
        
        .pagination .current {
            background: #0099cc;
            color: white;
            border: 1px solid #0099cc;
        }
        
        .pagination .disabled {
            background: #f8f9fa;
            color: #ccc;
            border: 1px solid #dee2e6;
            cursor: not-allowed;
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
                    <a href="{{ route('bookings.index') }}" class="nav-link active">My Bookings</a>
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

    <div class="bookings-page">
        <div class="bookings-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">My Bookings</h1>
                <p class="page-subtitle">Track and manage your vehicle rental bookings</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Bookings Grid -->
            @if($bookings->count() > 0)
                <div class="bookings-grid">
                    @foreach($bookings as $booking)
                        <a href="{{ route('bookings.show', $booking) }}" class="booking-card" style="text-decoration: none; color: inherit;">
                            <!-- Vehicle Image -->
                            <div class="vehicle-image">
                                @if($booking->vehicle->image_url)
                                    <img src="{{ $booking->vehicle->image_url }}" alt="{{ $booking->vehicle->full_name }}">
                                @else
                                    <div class="vehicle-image-fallback">🚗</div>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </div>
                            </div>

                            <!-- Booking Information -->
                            <div class="booking-info">
                                <h3 class="vehicle-name">{{ $booking->vehicle->full_name }}</h3>
                                <div class="vehicle-location">
                                    <span>📍</span>
                                    <span>{{ $booking->vehicle->location }}</span>
                                </div>

                                <!-- Booking Dates -->
                                <div class="booking-dates">
                                    <div class="date-item">
                                        <div class="date-label">Pick-up</div>
                                        <div class="date-value">{{ $booking->start_date->format('M d') }}</div>
                                    </div>
                                    <div class="date-item">
                                        <div class="date-label">Return</div>
                                        <div class="date-value">{{ $booking->end_date->format('M d') }}</div>
                                    </div>
                                </div>

                                <!-- Price and Duration -->
                                <div class="booking-price">
                                    <div class="duration">{{ $booking->duration }} {{ $booking->duration == 1 ? 'day' : 'days' }}</div>
                                    <div class="total-amount">KSh {{ number_format($booking->total_amount) }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="pagination-wrapper">
                        {{ $bookings->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">🚗</div>
                    <h3>No Bookings Yet</h3>
                    <p>You haven't made any vehicle bookings yet. Start exploring our available cars!</p>
                    <a href="{{ route('vehicles.index') }}" class="browse-btn">Browse Vehicles</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
