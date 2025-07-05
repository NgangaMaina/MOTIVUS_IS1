<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .booking-summary-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .booking-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Desktop/Laptop styling */
        @media (min-width: 768px) {
            .booking-container {
                max-width: 600px;
                padding: 0 40px;
            }
            
            .booking-summary-page {
                padding: 40px 0;
            }
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
        
        .booking-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .vehicle-header {
            position: relative;
            height: 200px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .vehicle-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .vehicle-image-fallback {
            font-size: 4rem;
            color: #ccc;
        }
        
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
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
        
        .booking-details {
            padding: 30px;
        }
        
        .vehicle-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .vehicle-location {
            color: #666;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .detail-section {
            margin-bottom: 25px;
        }
        
        .detail-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .detail-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 600;
        }
        
        .date-range {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .date-item {
            flex: 1;
        }
        
        .pricing-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .pricing-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .pricing-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 2px solid #dee2e6;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .pricing-label {
            color: #666;
        }
        
        .pricing-value {
            color: #333;
            font-weight: 600;
        }
        
        .total-amount {
            color: #0099cc !important;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-primary {
            flex: 1;
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            flex: 1;
            background: white;
            color: #666;
            border: 2px solid #dee2e6;
            padding: 15px 20px;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }
        
        .btn-secondary:hover {
            border-color: #0099cc;
            color: #0099cc;
            text-decoration: none;
        }
        
        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
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
        
        .owner-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .owner-info h4 {
            margin-bottom: 10px;
            color: #333;
            font-size: 1.1rem;
        }
        
        .owner-contact {
            color: #666;
            font-size: 0.9rem;
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

    <div class="booking-summary-page">
        <div class="booking-container">
            <!-- Back Button -->
            <a href="{{ route('bookings.index') }}" class="back-button">
                Back to My Bookings
            </a>

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

            <!-- Booking Summary Card -->
            <div class="booking-card">
                <!-- Vehicle Header with Image -->
                <div class="vehicle-header">
                    @if($booking->vehicle->image_url)
                        <img src="{{ $booking->vehicle->image_url }}" alt="{{ $booking->vehicle->full_name }}" class="vehicle-image">
                    @else
                        <div class="vehicle-image-fallback">🚗</div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="booking-details">
                    <!-- Vehicle Information -->
                    <h2 class="vehicle-name">{{ $booking->vehicle->full_name }}</h2>
                    <div class="vehicle-location">
                        <span>📍</span>
                        <span>{{ $booking->vehicle->location }}</span>
                    </div>

                    <!-- Booking Dates -->
                    <div class="date-range">
                        <div class="date-item">
                            <div class="detail-label">Pick-up Date</div>
                            <div class="detail-value">{{ $booking->start_date->format('M d, Y') }}</div>
                        </div>
                        <div class="date-item">
                            <div class="detail-label">Return Date</div>
                            <div class="detail-value">{{ $booking->end_date->format('M d, Y') }}</div>
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="detail-section">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value">{{ $booking->duration }} {{ $booking->duration == 1 ? 'day' : 'days' }}</div>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="pricing-section">
                        <div class="pricing-row">
                            <span class="pricing-label">Daily Rate</span>
                            <span class="pricing-value">KSh {{ number_format($booking->vehicle->price_per_day) }}</span>
                        </div>
                        <div class="pricing-row">
                            <span class="pricing-label">Duration</span>
                            <span class="pricing-value">{{ $booking->duration }} {{ $booking->duration == 1 ? 'day' : 'days' }}</span>
                        </div>
                        <div class="pricing-row">
                            <span class="pricing-label">Total Amount</span>
                            <span class="pricing-value total-amount">KSh {{ number_format($booking->total_amount) }}</span>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="owner-info">
                        <h4>Vehicle Owner</h4>
                        <div class="owner-contact">
                            <div><strong>{{ $booking->vehicle->owner->name }}</strong></div>
                            @if($booking->vehicle->owner->phone)
                                <div>📞 {{ $booking->vehicle->owner->phone }}</div>
                            @endif
                            <div>✉️ {{ $booking->vehicle->owner->email }}</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        @if($booking->status === 'pending' && $booking->renter_id === auth()->id())
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" style="flex: 1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-secondary btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('bookings.index') }}" class="btn-primary">
                            View All Bookings
                        </a>
                    </div>

                    @if($booking->status === 'pending' && (!$booking->payment || $booking->payment->status !== 'success'))
                        <a href="{{ route('payments.form', $booking) }}" class="btn btn-primary">
                            Pay Now
                        </a>
                    @endif

                    @if($booking->status === 'pending' && (!$booking->payment || $booking->payment->status !== 'success'))
                        <div class="payment-section">
                            <h3>Complete Payment</h3>
                            <p>Total Amount: KSh {{ number_format($booking->total_amount, 2) }}</p>
                            
                            <form action="{{ route('payments.initiate', $booking) }}" method="POST" class="payment-form">
                                @csrf
                                <div class="form-group">
                                    <label for="phone_number">M-PESA Phone Number (Format: 254XXXXXXXXX)</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" 
                                        placeholder="254712345678" value="{{ old('phone_number', auth()->user()->phone) }}" required>
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Pay with M-PESA</button>
                            </form>
                        </div>
                    @endif

                    @if($booking->payment && $booking->payment->status === 'pending')
                        <div class="payment-status-section">
                            <div class="alert alert-info">
                                <p>Payment is being processed. Please complete the transaction on your phone.</p>
                                <div id="payment-status-loading">Checking payment status...</div>
                            </div>
                        </div>

                        <script>
                            // Poll for payment status
                            function checkPaymentStatus() {
                                fetch('{{ route("payments.status", $booking) }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            window.location.reload();
                                        } else if (data.status === 'failed') {
                                            document.getElementById('payment-status-loading').innerHTML = 
                                                '<span class="text-danger">Payment failed. Please try again.</span>';
                                        } else {
                                            // Continue polling
                                            setTimeout(checkPaymentStatus, 5000);
                                        }
                                    });
                            }
                            
                            // Start polling
                            checkPaymentStatus();
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>


