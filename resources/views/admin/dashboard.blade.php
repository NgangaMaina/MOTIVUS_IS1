<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .admin-dashboard {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .dashboard-container {
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
        
        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 5px solid;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stat-card.users { border-left-color: #007bff; }
        .stat-card.vehicles { border-left-color: #28a745; }
        .stat-card.bookings { border-left-color: #ffc107; }
        .stat-card.revenue { border-left-color: #dc3545; }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }
        
        .activity-icon.booking { background: #e3f2fd; color: #1976d2; }
        .activity-icon.payment { background: #e8f5e8; color: #388e3c; }
        .activity-icon.user { background: #fff3e0; color: #f57c00; }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .activity-subtitle {
            font-size: 0.9rem;
            color: #666;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: #999;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .action-btn.secondary { background: linear-gradient(45deg, #6c757d, #545b62); }
        .action-btn.success { background: linear-gradient(45deg, #28a745, #1e7e34); }
        .action-btn.warning { background: linear-gradient(45deg, #ffc107, #e0a800); }
        
        .top-vehicles {
            margin-top: 20px;
        }
        
        .vehicle-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .vehicle-item:last-child {
            border-bottom: none;
        }
        
        .vehicle-info {
            flex: 1;
        }
        
        .vehicle-name {
            font-weight: 600;
            color: #333;
        }
        
        .vehicle-owner {
            font-size: 0.9rem;
            color: #666;
        }
        
        .vehicle-bookings {
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <!-- Admin Navigation -->
    <nav class="desktop-nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">MOTIVUS ADMIN</a>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">Dashboard</a>
                <a href="{{ route('admin.rental-requests') }}" class="nav-link">Rental Requests</a>
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

    <div class="admin-dashboard">
        <div class="dashboard-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Admin Dashboard</h1>
                <p class="page-subtitle">Monitor and manage the MOTIVUS platform</p>
            </div>

            <!-- Key Statistics -->
            <div class="stats-grid">
                <div class="stat-card users">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number">{{ number_format($totalUsers) }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card vehicles">
                    <div class="stat-icon">🚗</div>
                    <div class="stat-number">{{ number_format($totalVehicles) }}</div>
                    <div class="stat-label">Total Vehicles</div>
                </div>
                <div class="stat-card bookings">
                    <div class="stat-icon">📋</div>
                    <div class="stat-number">{{ number_format($totalBookings) }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="stat-card revenue">
                    <div class="stat-icon">💰</div>
                    <div class="stat-number">KSh {{ number_format($totalRevenue) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="{{ route('admin.rental-requests') }}" class="action-btn">
                    <span>📋</span>
                    Rental Requests ({{ $pendingBookings }})
                </a>
                <a href="{{ route('admin.car-management') }}" class="action-btn success">
                    <span>🚗</span>
                    Manage Vehicles
                </a>
                <a href="{{ route('admin.user-management') }}" class="action-btn secondary">
                    <span>👥</span>
                    Manage Users
                </a>
                <a href="{{ route('admin.financial-analytics') }}" class="action-btn warning">
                    <span>📊</span>
                    Financial Reports
                </a>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Revenue Chart -->
                <div class="dashboard-card">
                    <h3 class="card-title">
                        <span>📈</span>
                        Monthly Revenue Trend
                    </h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="dashboard-card">
                    <h3 class="card-title">
                        <span>🔔</span>
                        Recent Activity
                    </h3>
                    <div class="recent-activity">
                        @forelse($recentBookings as $booking)
                            <div class="activity-item">
                                <div class="activity-icon booking">📋</div>
                                <div class="activity-content">
                                    <div class="activity-title">New Booking Request</div>
                                    <div class="activity-subtitle">
                                        {{ $booking->renter->name }} → {{ $booking->vehicle->full_name }}
                                    </div>
                                    <div class="activity-time">{{ $booking->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                No recent activity to display.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Additional Analytics -->
            <div class="dashboard-grid">
                <!-- User Distribution -->
                <div class="dashboard-card">
                    <h3 class="card-title">
                        <span>👥</span>
                        User Distribution
                    </h3>
                    <div class="chart-container">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>

                <!-- Top Performing Vehicles -->
                <div class="dashboard-card">
                    <h3 class="card-title">
                        <span>🏆</span>
                        Top Performing Vehicles
                    </h3>
                    <div class="top-vehicles">
                        @forelse($topVehicles as $vehicle)
                            <div class="vehicle-item">
                                <div class="vehicle-info">
                                    <div class="vehicle-name">{{ $vehicle->full_name }}</div>
                                    <div class="vehicle-owner">Owner: {{ $vehicle->owner->name }}</div>
                                </div>
                                <div class="vehicle-bookings">{{ $vehicle->total_bookings }} bookings</div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                No booking data available yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($monthlyRevenue);
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
                datasets: [{
                    label: 'Revenue (KSh)',
                    data: revenueData.map(item => item.total),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'KSh ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // User Distribution Chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        const userData = @json($usersByRole);
        
        new Chart(userCtx, {
            type: 'doughnut',
            data: {
                labels: userData.map(item => item.name.charAt(0).toUpperCase() + item.name.slice(1)),
                datasets: [{
                    data: userData.map(item => item.count),
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
