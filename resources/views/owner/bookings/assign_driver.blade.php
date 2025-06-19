<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Driver - MOTIVUS Owner</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .owner-bookings-page {
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
        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 32px;
        }
        .vehicle-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .renter-name {
            color: #666;
            margin-bottom: 10px;
        }
        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 10px;
            padding: 20px 0 0 0;
        }
        .detail-item {
            text-align: center;
        }
        .detail-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        .total-amount {
            color: #0099cc !important;
            font-size: 1.3rem !important;
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
        .form-section {
            background: white;
            padding: 32px 24px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 24px;
        }
        label[for="driver_id"] {
            font-weight: 700;
            color: #0099cc;
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
        }
        select.form-input {
            width: 100%;
            padding: 12px 10px;
            border-radius: 10px;
            border: 1.5px solid #0099cc;
            font-size: 1rem;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            border: none;
            display: inline-block;
        }
        .btn-accept {
            background: #28a745;
            color: white;
            min-width: 140px;
        }
        .btn-accept:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
        @media (max-width: 700px) {
            .booking-details {
                grid-template-columns: 1fr;
            }
            .form-section {
                padding: 18px 8px;
            }
        }
    </style>
</head>
<body>
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS</a>
            <div class="nav-links">
                <a href="{{ route('vehicles.index') }}" class="nav-link">Browse Cars</a>
                @auth
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.vehicles.index') }}" class="nav-link">My Vehicles</a>
                        <a href="{{ route('owner.bookings.index') }}" class="nav-link active">Booking Requests</a>
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
    <div class="owner-bookings-page">
        <div class="bookings-container">
            <div class="page-header">
                <h1 class="page-title">Assign Driver</h1>
                <p class="page-subtitle">Select a driver to deliver the vehicle for this booking.</p>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="booking-card">
                <h3 class="vehicle-name">{{ $booking->vehicle->full_name }}</h3>
                <div class="renter-name"><strong>Renter:</strong> {{ $booking->renter->name }}</div>
                <div class="booking-details">
                    <div class="detail-item">
                        <div class="detail-label">Pick-up Date</div>
                        <div class="detail-value">{{ $booking->start_date->format('M d, Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Return Date</div>
                        <div class="detail-value">{{ $booking->end_date->format('M d, Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value">{{ $booking->duration }} {{ $booking->duration == 1 ? 'day' : 'days' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Total Amount</div>
                        <div class="detail-value total-amount">KSh {{ number_format($booking->total_amount) }}</div>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('owner.bookings.assignDriver', $booking) }}" class="form-section">
                @csrf
                <div class="form-group">
                    <label for="driver_id">Select Driver</label>
                    <select name="driver_id" id="driver_id" class="form-input">
                        <option value="">-- Choose a driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex;gap:12px;align-items:center;">
                    <button type="submit" class="btn btn-accept">Assign Driver</button>
                    <a href="{{ route('owner.bookings.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
