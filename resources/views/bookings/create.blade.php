<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book {{ $vehicle->full_name }} - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .booking-page {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .booking-container {
            max-width: 600px;
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
        
        .vehicle-preview {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .vehicle-image {
            height: 200px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .vehicle-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .vehicle-image-fallback {
            font-size: 4rem;
            color: #ccc;
        }
        
        .vehicle-info {
            padding: 25px;
        }
        
        .vehicle-name {
            font-size: 1.5rem;
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
        }
        
        .vehicle-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0099cc;
        }
        
        .booking-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #0099cc;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 153, 204, 0.1);
        }
        
        .date-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .booking-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 2px solid #dee2e6;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .summary-label {
            color: #666;
        }
        
        .summary-value {
            color: #333;
            font-weight: 600;
        }
        
        .total-amount {
            color: #0099cc !important;
        }
        
        .submit-btn {
            width: 100%;
            background: linear-gradient(45deg, #00d4ff, #0099cc);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }
        
        .submit-btn:disabled {
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
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .error-list {
            margin: 10px 0 0 20px;
            padding: 0;
        }
        
        .error-list li {
            margin-bottom: 5px;
        }
        
        .form-help {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }
        
        .availability-note {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border: 1px solid #bee5eb;
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

    <div class="booking-page">
        <div class="booking-container">
            <!-- Back Button -->
            <a href="{{ route('vehicles.show', $vehicle) }}" class="back-button">
                Back to Vehicle Details
            </a>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Vehicle Preview -->
            <div class="vehicle-preview">
                <div class="vehicle-image">
                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->full_name }}">
                    @else
                        <div class="vehicle-image-fallback">🚗</div>
                    @endif
                </div>
                <div class="vehicle-info">
                    <h2 class="vehicle-name">{{ $vehicle->full_name }}</h2>
                    <div class="vehicle-location">
                        <span>📍</span>
                        <span>{{ $vehicle->location }}</span>
                    </div>
                    <div class="vehicle-price">KSh {{ number_format($vehicle->price_per_day) }}/day</div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="booking-form">
                <h2 class="form-title">Book This Vehicle</h2>
                
                <div class="availability-note">
                    <strong>📅 Booking Information:</strong><br>
                    Please select your rental dates. The total cost will be calculated automatically based on the number of days.
                </div>

                <form method="POST" action="{{ route('bookings.store', $vehicle) }}" id="bookingForm">
                    @csrf
                    
                    <div class="date-inputs">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Pick-up Date</label>
                            <input type="date" 
                                   id="start_date" 
                                   name="start_date" 
                                   class="form-input" 
                                   value="{{ old('start_date') }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            <div class="form-help">Earliest: Today</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date" class="form-label">Return Date</label>
                            <input type="date" 
                                   id="end_date" 
                                   name="end_date" 
                                   class="form-input" 
                                   value="{{ old('end_date') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required>
                            <div class="form-help">Must be after pick-up date</div>
                        </div>
                    </div>

                    <!-- Booking Summary -->
                    <div class="booking-summary" id="bookingSummary" style="display: none;">
                        <div class="summary-row">
                            <span class="summary-label">Daily Rate</span>
                            <span class="summary-value">KSh {{ number_format($vehicle->price_per_day) }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Duration</span>
                            <span class="summary-value" id="durationText">0 days</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Total Amount</span>
                            <span class="summary-value total-amount" id="totalAmount">KSh 0</span>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        Complete Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const bookingSummary = document.getElementById('bookingSummary');
            const durationText = document.getElementById('durationText');
            const totalAmount = document.getElementById('totalAmount');
            const submitBtn = document.getElementById('submitBtn');
            const dailyRate = {{ $vehicle->price_per_day }};

            function updateBookingSummary() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDateInput.value && endDateInput.value && endDate > startDate) {
                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    const total = daysDiff * dailyRate;

                    durationText.textContent = daysDiff + (daysDiff === 1 ? ' day' : ' days');
                    totalAmount.textContent = 'KSh ' + total.toLocaleString();
                    
                    bookingSummary.style.display = 'block';
                    submitBtn.disabled = false;
                } else {
                    bookingSummary.style.display = 'none';
                    submitBtn.disabled = true;
                }
            }

            function updateEndDateMin() {
                if (startDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const nextDay = new Date(startDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    endDateInput.min = nextDay.toISOString().split('T')[0];
                    
                    // Clear end date if it's now invalid
                    if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                        endDateInput.value = '';
                    }
                }
                updateBookingSummary();
            }

            startDateInput.addEventListener('change', updateEndDateMin);
            endDateInput.addEventListener('change', updateBookingSummary);

            // Initial update
            updateEndDateMin();
        });
    </script>
</body>
</html>
