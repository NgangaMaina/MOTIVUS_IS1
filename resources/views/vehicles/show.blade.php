<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vehicle->full_name }} - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .vehicle-detail-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .vehicle-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            color: #666;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .back-button:hover {
            color: #0099cc;
            text-decoration: none;
        }
        
        .back-button::before {
            content: '←';
            margin-right: 8px;
            font-size: 1.2rem;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .vehicle-image {
            height: 300px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        .vehicle-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .vehicle-image-fallback {
            font-size: 5rem;
            color: #ccc;
        }
        
        .availability-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .available {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .unavailable {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .vehicle-details {
            padding: 30px;
        }
        
        .vehicle-name {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .vehicle-location {
            color: #666;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.1rem;
        }
        
        .vehicle-price {
            font-size: 2rem;
            font-weight: 700;
            color: #0099cc;
            margin-bottom: 25px;
        }
        
        .vehicle-specs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
        }
        
        .spec-item {
            text-align: center;
        }
        
        .spec-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .spec-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        
        .owner-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .owner-info h4 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.2rem;
        }
        
        .owner-contact {
            color: #666;
            font-size: 1rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        
        .reviews-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .reviews-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }
        
        .average-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            color: #666;
        }
        
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }
        
        .review-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }
        
        .review-item:last-child {
            border-bottom: none;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .reviewer-name {
            font-weight: 600;
            color: #333;
        }
        
        .review-rating {
            color: #ffc107;
        }
        
        .review-comment {
            color: #666;
            line-height: 1.6;
        }
        
        .book-button {
            width: 100%;
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        
        .book-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .book-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .no-reviews {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px 0;
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

    <div class="vehicle-detail-page">
        <div class="vehicle-container">
            <!-- Back Button -->
            <a href="{{ route('vehicles.index') }}" class="back-button">
                Back to Browse Vehicles
            </a>

            <!-- Vehicle Details Card -->
            <div class="vehicle-card">
                <!-- Vehicle Image -->
                <div class="vehicle-image">
                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->full_name }}">
                    @else
                        <div class="vehicle-image-fallback">🚗</div>
                    @endif
                    
                    <!-- Availability Badge -->
                    <div class="availability-badge {{ $vehicle->availability ? 'available' : 'unavailable' }}">
                        {{ $vehicle->availability ? 'Available' : 'Unavailable' }}
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="vehicle-details">
                    <h1 class="vehicle-name">{{ $vehicle->full_name }}</h1>
                    <div class="vehicle-location">
                        <span>📍</span>
                        <span>{{ $vehicle->location }}</span>
                    </div>
                    <div class="vehicle-price">KSh {{ number_format($vehicle->price_per_day) }}/day</div>

                    <!-- Vehicle Specifications -->
                    <div class="vehicle-specs">
                        <div class="spec-item">
                            <div class="spec-label">Make</div>
                            <div class="spec-value">{{ $vehicle->make }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Model</div>
                            <div class="spec-value">{{ $vehicle->model }}</div>
                        </div>
                        @if($vehicle->year)
                            <div class="spec-item">
                                <div class="spec-label">Year</div>
                                <div class="spec-value">{{ $vehicle->year }}</div>
                            </div>
                        @endif
                        <div class="spec-item">
                            <div class="spec-label">Daily Rate</div>
                            <div class="spec-value">KSh {{ number_format($vehicle->price_per_day) }}</div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="owner-info">
                        <h4>Vehicle Owner</h4>
                        <div class="owner-contact">
                            <div class="contact-item">
                                <span>👤</span>
                                <strong>{{ $vehicle->owner->name }}</strong>
                            </div>
                            <div class="contact-item">
                                <span>✉️</span>
                                <span>{{ $vehicle->owner->email }}</span>
                            </div>
                            @if($vehicle->owner->phone)
                                <div class="contact-item">
                                    <span>📞</span>
                                    <span>{{ $vehicle->owner->phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Booking Button -->
                    @auth
                        @if(auth()->user()->isRenter())
                            @if($vehicle->availability)
                                <a href="{{ route('bookings.create', $vehicle) }}" class="book-button">
                                    Book This Vehicle
                                </a>
                            @else
                                <button class="book-button" disabled>
                                    Currently Unavailable
                                </button>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                Only renters can book vehicles. Please contact us if you need to change your account type.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="book-button">
                            Sign In to Book
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="reviews-section">
                <div class="reviews-header">
                    <h3 class="reviews-title">Customer Reviews</h3>
                    @if($reviews->count() > 0)
                        <div class="average-rating">
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($averageRating) ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span>{{ number_format($averageRating, 1) }} ({{ $reviews->count() }} {{ $reviews->count() == 1 ? 'review' : 'reviews' }})</span>
                        </div>
                    @endif
                </div>

                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <span class="reviewer-name">{{ $review->booking->renter->name }}</span>
                                <span class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            @if($review->comment)
                                <div class="review-comment">{{ $review->comment }}</div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="no-reviews">
                        No reviews yet. Be the first to review this vehicle!
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
