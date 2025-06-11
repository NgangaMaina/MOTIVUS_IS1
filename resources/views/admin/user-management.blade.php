<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - MOTIVUS Admin</title>
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
            background: linear-gradient(135deg, #6c757d, #545b62);
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
            border-color: #6c757d;
            box-shadow: 0 0 0 3px rgba(108, 117, 125, 0.1);
        }
        
        .btn-filter {
            background: linear-gradient(45deg, #6c757d, #545b62);
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
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }
        
        .users-grid {
            display: grid;
            gap: 20px;
        }
        
        .user-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .user-card {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
        
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #0056b3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: 700;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .user-email {
            color: #666;
            margin-bottom: 10px;
        }
        
        .user-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
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
        
        .role-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        
        .role-renter {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .role-owner {
            background: #d4edda;
            color: #155724;
        }
        
        .role-driver {
            background: #fff3cd;
            color: #856404;
        }
        
        .role-admin {
            background: #f8d7da;
            color: #721c24;
        }
        
        .user-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }
        
        .stat-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }
        
        .stat-label {
            font-size: 0.7rem;
            color: #666;
            text-transform: uppercase;
        }
        
        .user-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 120px;
        }
        
        .verification-status {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .verified {
            background: #d4edda;
            color: #155724;
        }
        
        .unverified {
            background: #f8d7da;
            color: #721c24;
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
        
        .btn-contact {
            background: #28a745;
            color: white;
        }
        
        .btn-contact:hover {
            background: #218838;
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
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-left: 5px solid;
        }
        
        .summary-card.renters { border-left-color: #007bff; }
        .summary-card.owners { border-left-color: #28a745; }
        .summary-card.drivers { border-left-color: #ffc107; }
        .summary-card.admins { border-left-color: #dc3545; }
        
        .summary-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .summary-label {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
                <a href="{{ route('admin.car-management') }}" class="nav-link">Car Management</a>
                <a href="{{ route('admin.user-management') }}" class="nav-link active">Users</a>
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
                <h1 class="page-title">User Management</h1>
                <p class="page-subtitle">Monitor and manage all platform users</p>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                @php
                    $roleCounts = $users->groupBy('role.name')->map->count();
                @endphp
                <div class="summary-card renters">
                    <div class="summary-number">{{ $roleCounts->get('renter', 0) }}</div>
                    <div class="summary-label">Renters</div>
                </div>
                <div class="summary-card owners">
                    <div class="summary-number">{{ $roleCounts->get('owner', 0) }}</div>
                    <div class="summary-label">Owners</div>
                </div>
                <div class="summary-card drivers">
                    <div class="summary-number">{{ $roleCounts->get('driver', 0) }}</div>
                    <div class="summary-label">Drivers</div>
                </div>
                <div class="summary-card admins">
                    <div class="summary-number">{{ $roleCounts->get('admin', 0) }}</div>
                    <div class="summary-label">Admins</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" action="{{ route('admin.user-management') }}">
                    <div class="filters-grid">
                        <div class="form-group">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-input">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" id="search" name="search" class="form-input" 
                                   placeholder="Name or email..." value="{{ request('search') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-filter">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Users -->
            @if($users->count() > 0)
                <div class="users-grid">
                    @foreach($users as $user)
                        <div class="user-card">
                            <!-- User Avatar -->
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <!-- User Information -->
                            <div class="user-info">
                                <h3 class="user-name">{{ $user->name }}</h3>
                                <div class="user-email">{{ $user->email }}</div>
                                
                                <div class="user-details">
                                    <div class="detail-item">
                                        <div class="detail-label">Role</div>
                                        <div class="detail-value">
                                            <span class="role-badge role-{{ $user->role->name }}">
                                                {{ ucfirst($user->role->name) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($user->phone)
                                        <div class="detail-item">
                                            <div class="detail-label">Phone</div>
                                            <div class="detail-value">{{ $user->phone }}</div>
                                        </div>
                                    @endif
                                    <div class="detail-item">
                                        <div class="detail-label">Joined</div>
                                        <div class="detail-value">{{ $user->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>

                                <!-- User Statistics -->
                                <div class="user-stats">
                                    @if($user->isRenter())
                                        <div class="stat-item">
                                            <div class="stat-number">{{ $user->bookings->count() }}</div>
                                            <div class="stat-label">Bookings</div>
                                        </div>
                                    @elseif($user->isOwner())
                                        <div class="stat-item">
                                            <div class="stat-number">{{ $user->vehicles->count() }}</div>
                                            <div class="stat-label">Vehicles</div>
                                        </div>
                                    @elseif($user->isDriver())
                                        <div class="stat-item">
                                            <div class="stat-number">{{ $user->deliveryTasks->count() }}</div>
                                            <div class="stat-label">Deliveries</div>
                                        </div>
                                    @endif
                                    
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $user->updated_at->diffInDays() }}</div>
                                        <div class="stat-label">Days Ago</div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Actions -->
                            <div class="user-actions">
                                <!-- Verification Status -->
                                <div class="verification-status {{ $user->email_verified_at ? 'verified' : 'unverified' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                </div>

                                <!-- Action Buttons -->
                                <a href="mailto:{{ $user->email }}" class="btn btn-contact">
                                    Contact
                                </a>
                                
                                @if($user->isOwner() && $user->vehicles->count() > 0)
                                    <a href="{{ route('admin.car-management', ['owner_id' => $user->id]) }}" class="btn btn-view">
                                        View Vehicles
                                    </a>
                                @elseif($user->isRenter() && $user->bookings->count() > 0)
                                    <a href="{{ route('admin.rental-requests', ['renter_id' => $user->id]) }}" class="btn btn-view">
                                        View Bookings
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="pagination-wrapper">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">👥</div>
                    <h3>No Users Found</h3>
                    <p>No users match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
