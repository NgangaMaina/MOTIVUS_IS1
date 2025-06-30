<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Requests - MOTIVUS Admin</title>
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
            background: linear-gradient(135deg, #dc3545, #c82333);
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
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        
        .btn-filter {
            background: linear-gradient(45deg, #dc3545, #c82333);
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
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }
        
        .requests-grid {
            display: grid;
            gap: 20px;
        }
        
        .request-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .request-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .request-info {
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
        
        .request-dates {
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
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
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
            color: #dc3545 !important;
            font-size: 1.3rem !important;
        }
        
        .customer-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .customer-info h4 {
            margin-bottom: 10px;
            color: #333;
            font-size: 1.1rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
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
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
                <a href="{{ route('admin.rental-requests') }}" class="nav-link active">Rental Requests</a>
                <a href="{{ route('admin.car-management') }}" class="nav-link">Car Management</a>
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
                <h1 class="page-title">Rental Requests Management</h1>
                <p class="page-subtitle">Review and manage all vehicle rental requests</p>
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

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" action="{{ route('admin.rental-requests') }}">
                    <div class="filters-grid">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-input">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" id="date_from" name="date_from" class="form-input" value="{{ request('date_from') }}">
                        </div>
                        <div class="form-group">
                            <label for="date_to" class="form-label">To Date</label>
                            <input type="date" id="date_to" name="date_to" class="form-input" value="{{ request('date_to') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-filter">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Rental Requests -->
            @if($bookings->count() > 0)
                <div class="requests-grid">
                    @foreach($bookings as $booking)
                        <div class="request-card">
                            <!-- Request Header -->
                            <div class="request-header">
                                <div class="request-info">
                                    <h3 class="vehicle-name">{{ $booking->vehicle->full_name }}</h3>
                                    <div class="renter-name">
                                        <strong>Renter:</strong> {{ $booking->renter->name }}
                                    </div>
                                    <div class="request-dates">
                                        <strong>Requested:</strong> {{ $booking->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                                <div class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </div>
                            </div>

                            <div class="action-buttons">
                                @if($booking->status === 'pending')
                                    <form method="POST" action="{{ route('admin.approve-rental', $booking) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this rental request?')">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reject-rental', $booking) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-reject" onclick="return confirm('Reject this rental request?')">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <!-- Request Details (always visible) -->
                            <div style="margin-top:20px;">
                                <!-- Request Details -->
                                <div class="request-details">
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

                                <!-- Customer Information -->
                                <div class="customer-info">
                                    <h4>Customer Details</h4>
                                    <div class="contact-item">
                                        <span>👤</span>
                                        <span><strong>{{ $booking->renter->name }}</strong></span>
                                    </div>
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

                                <!-- Vehicle Owner Information -->
                                <div class="customer-info">
                                    <h4>Vehicle Owner</h4>
                                    <div class="contact-item">
                                        <span>👤</span>
                                        <span><strong>{{ $booking->vehicle->owner->name }}</strong></span>
                                    </div>
                                    <div class="contact-item">
                                        <span>✉️</span>
                                        <span>{{ $booking->vehicle->owner->email }}</span>
                                    </div>
                                    @if($booking->vehicle->owner->phone)
                                        <div class="contact-item">
                                            <span>📞</span>
                                            <span>{{ $booking->vehicle->owner->phone }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Payment Information -->
                                @if($booking->payment)
                                    <div class="customer-info">
                                        <h4>Payment Status</h4>
                                        <div class="contact-item">
                                            <span>💳</span>
                                            <span><strong>{{ ucfirst($booking->payment->status) }}</strong></span>
                                        </div>
                                        @if($booking->payment->transaction_code)
                                            <div class="contact-item">
                                                <span>🔢</span>
                                                <span>{{ $booking->payment->transaction_code }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="pagination-wrapper">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <h3>No Rental Requests Found</h3>
                    <p>No rental requests match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
