<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Requests - MOTIVUS Owner</title>
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
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .bookings-list {
            display: grid;
            gap: 20px;
        }
        
        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .booking-info {
            flex: 1;
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
        
        .booking-dates {
            font-size: 0.9rem;
            color: #666;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
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
        
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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
        }
        
        .btn-accept:hover {
            background: #218838;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
        }
        
        .btn-reject:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .btn-complete {
            background: #17a2b8;
            color: white;
        }
        
        .btn-complete:hover {
            background: #138496;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
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
        
        .renter-contact {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }
        
        .contact-info {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS</a>
            <div class="nav-links">
                <a href="{{ route('owner.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('owner.vehicles.index') }}" class="nav-link">My Vehicles</a>
                <a href="{{ route('owner.bookings.index') }}" class="nav-link active">Manage Bookings</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; color: white;">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="owner-bookings-page">
        <div class="bookings-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Booking Requests</h1>
                <p class="page-subtitle">Manage rental requests for your vehicles</p>
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

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $bookings->where('status', 'pending')->count() }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $bookings->where('status', 'accepted')->count() }}</div>
                    <div class="stat-label">Accepted</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $bookings->where('status', 'completed')->count() }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $bookings->count() }}</div>
                    <div class="stat-label">Total</div>
                </div>
            </div>

            <!-- Bookings List -->
            @if($bookings->count() > 0)
                <div class="bookings-list">
                    @foreach($bookings as $booking)
                        <div class="booking-card">
                            <!-- Booking Header -->
                            <div class="booking-header">
                                <div class="booking-info">
                                    <h3 class="vehicle-name">{{ $booking->vehicle->full_name }}</h3>
                                    <div class="renter-name">
                                        <strong>Renter:</strong> {{ $booking->renter->name }}
                                    </div>
                                    <div class="contact-info">
                                        <div class="contact-item">
                                            <span>✉️</span>
                                            <span>{{ $booking->renter->email }}</span>
                                        </div>
                                        @if($booking->renter->phone)
                                            <div class="contact-item">
                                                <span>📞</span>
                                                <span>{{ $booking->renter->phone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </div>
                            </div>

                            <!-- Booking Details -->
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

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                @if($booking->status === 'pending')
                                    <form method="POST" action="{{ route('owner.bookings.accept', $booking) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-accept" onclick="return confirm('Accept this booking request?')">
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('owner.bookings.reject', $booking) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this booking request?')">
                                            Reject
                                        </button>
                                    </form>
                                @elseif($booking->status === 'accepted')
                                    @if(!$booking->deliveryTask)
                                        <a href="{{ route('owner.bookings.assignDriverForm', $booking) }}" class="btn btn-accept">
                                            Assign Driver
                                        </a>
                                    @else
                                        <span class="btn btn-secondary" style="background:#e0e7ef;color:#333;cursor:default;">Driver Assigned</span>
                                    @endif
                                    <form method="POST" action="{{ route('owner.bookings.complete', $booking) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-complete" onclick="return confirm('Mark this booking as completed?')">
                                            Mark Complete
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="mailto:{{ $booking->renter->email }}" class="btn btn-secondary">
                                    Contact Renter
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div style="display: flex; justify-content: center; margin-top: 40px;">
                        {{ $bookings->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <h3>No Booking Requests</h3>
                    <p>You haven't received any booking requests yet. Make sure your vehicles are listed and available!</p>
                    <a href="{{ route('owner.vehicles.index') }}" class="btn btn-accept">Manage My Vehicles</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
