<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Analytics - MOTIVUS Admin</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            background: linear-gradient(135deg, #ffc107, #e0a800);
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
        
        .period-selector {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .period-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .period-btn {
            padding: 10px 20px;
            border: 2px solid #ffc107;
            background: white;
            color: #ffc107;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .period-btn.active,
        .period-btn:hover {
            background: #ffc107;
            color: white;
            text-decoration: none;
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
        
        .stat-card.revenue { border-left-color: #28a745; }
        .stat-card.pending { border-left-color: #ffc107; }
        .stat-card.failed { border-left-color: #dc3545; }
        .stat-card.transactions { border-left-color: #007bff; }
        
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
        
        .analytics-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .analytics-card {
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
        
        .top-vehicles {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .vehicle-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .vehicle-item:last-child {
            border-bottom: none;
        }
        
        .vehicle-rank {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ffc107;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 15px;
        }
        
        .vehicle-info {
            flex: 1;
        }
        
        .vehicle-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        
        .vehicle-owner {
            font-size: 0.9rem;
            color: #666;
        }
        
        .vehicle-earnings {
            text-align: right;
        }
        
        .earnings-amount {
            font-weight: 700;
            color: #28a745;
            font-size: 1.1rem;
        }
        
        .earnings-bookings {
            font-size: 0.8rem;
            color: #666;
        }
        
        .payment-stats {
            display: grid;
            gap: 15px;
        }
        
        .payment-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .payment-status {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .status-success { background: #28a745; }
        .status-pending { background: #ffc107; }
        .status-failed { background: #dc3545; }
        
        .payment-details {
            text-align: right;
        }
        
        .payment-count {
            font-weight: 700;
            color: #333;
        }
        
        .payment-amount {
            font-size: 0.9rem;
            color: #666;
        }
        
        .revenue-breakdown {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .revenue-breakdown {
                grid-template-columns: 1fr;
            }
        }
        
        .breakdown-item {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .breakdown-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .breakdown-chart {
            position: relative;
            height: 200px;
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
        
        .trend-indicator {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .trend-up {
            color: #28a745;
        }
        
        .trend-down {
            color: #dc3545;
        }
        
        .trend-neutral {
            color: #6c757d;
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
                <a href="{{ route('admin.user-management') }}" class="nav-link">Users</a>
                <a href="{{ route('admin.financial-analytics') }}" class="nav-link active">Analytics</a>
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
                <h1 class="page-title">Financial Analytics</h1>
                <p class="page-subtitle">Monitor revenue, payments, and financial performance</p>
            </div>

            <!-- Period Selector -->
            <div class="period-selector">
                <div class="period-buttons">
                    <a href="{{ route('admin.financial-analytics', ['period' => 'month']) }}" 
                       class="period-btn {{ $period === 'month' ? 'active' : '' }}">Monthly</a>
                    <a href="{{ route('admin.financial-analytics', ['period' => 'quarter']) }}" 
                       class="period-btn {{ $period === 'quarter' ? 'active' : '' }}">Quarterly</a>
                    <a href="{{ route('admin.financial-analytics', ['period' => 'year']) }}" 
                       class="period-btn {{ $period === 'year' ? 'active' : '' }}">Yearly</a>
                </div>
            </div>

            <!-- Key Financial Metrics -->
            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-icon">💰</div>
                    <div class="stat-number">KSh {{ number_format($totalRevenue) }}</div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="trend-indicator trend-up">
                        <span>↗</span> +12% from last period
                    </div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-number">KSh {{ number_format($pendingPayments) }}</div>
                    <div class="stat-label">Pending Payments</div>
                </div>
                <div class="stat-card failed">
                    <div class="stat-icon">❌</div>
                    <div class="stat-number">{{ $failedPayments }}</div>
                    <div class="stat-label">Failed Transactions</div>
                </div>
                <div class="stat-card transactions">
                    <div class="stat-icon">📊</div>
                    <div class="stat-number">{{ $paymentStats->sum('count') }}</div>
                    <div class="stat-label">Total Transactions</div>
                </div>
            </div>

            <!-- Revenue Analytics -->
            <div class="analytics-grid">
                <!-- Revenue Trend Chart -->
                <div class="analytics-card">
                    <h3 class="card-title">
                        <span>📈</span>
                        Revenue Trend ({{ ucfirst($period) }}ly)
                    </h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Payment Status Breakdown -->
                <div class="analytics-card">
                    <h3 class="card-title">
                        <span>💳</span>
                        Payment Status
                    </h3>
                    <div class="payment-stats">
                        @foreach($paymentStats as $stat)
                            <div class="payment-stat">
                                <div class="payment-status">
                                    <div class="status-indicator status-{{ $stat->status }}"></div>
                                    <span>{{ ucfirst($stat->status) }}</span>
                                </div>
                                <div class="payment-details">
                                    <div class="payment-count">{{ $stat->count }} transactions</div>
                                    <div class="payment-amount">KSh {{ number_format($stat->total) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Earning Vehicles -->
            <div class="analytics-card">
                <h3 class="card-title">
                    <span>🏆</span>
                    Top Earning Vehicles
                </h3>
                @if($topEarningVehicles->count() > 0)
                    <div class="top-vehicles">
                        @foreach($topEarningVehicles as $index => $vehicle)
                            @php
                                $totalEarnings = $vehicle->bookings->sum(function($booking) {
                                    return $booking->payment && $booking->payment->status === 'success' ? $booking->payment->amount : 0;
                                });
                                $totalBookings = $vehicle->bookings->count();
                            @endphp
                            <div class="vehicle-item">
                                <div class="vehicle-rank">{{ $index + 1 }}</div>
                                <div class="vehicle-info">
                                    <div class="vehicle-name">{{ $vehicle->full_name }}</div>
                                    <div class="vehicle-owner">Owner: {{ $vehicle->owner->name }}</div>
                                </div>
                                <div class="vehicle-earnings">
                                    <div class="earnings-amount">KSh {{ number_format($totalEarnings) }}</div>
                                    <div class="earnings-bookings">{{ $totalBookings }} bookings</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">🚗</div>
                        <h4>No Revenue Data</h4>
                        <p>No vehicles have generated revenue yet.</p>
                    </div>
                @endif
            </div>

            <!-- Revenue Breakdown Charts -->
            <div class="revenue-breakdown">
                <div class="breakdown-item">
                    <h4 class="breakdown-title">Revenue by Payment Status</h4>
                    <div class="breakdown-chart">
                        <canvas id="paymentStatusChart"></canvas>
                    </div>
                </div>
                <div class="breakdown-item">
                    <h4 class="breakdown-title">Monthly Growth</h4>
                    <div class="breakdown-chart">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Revenue Trend Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($revenueData);
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => {
                    if ('{{ $period }}' === 'year') {
                        return item.period;
                    } else if ('{{ $period }}' === 'quarter') {
                        return `Q${item.quarter} ${item.year}`;
                    } else {
                        return `${item.year}-${String(item.month).padStart(2, '0')}`;
                    }
                }),
                datasets: [{
                    label: 'Revenue (KSh)',
                    data: revenueData.map(item => item.total),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
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

        // Payment Status Chart
        const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
        const paymentData = @json($paymentStats);
        
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: paymentData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
                datasets: [{
                    data: paymentData.map(item => item.total),
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
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

        // Growth Chart (simplified example)
        const growthCtx = document.getElementById('growthChart').getContext('2d');
        
        new Chart(growthCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Growth %',
                    data: [12, 8, 15, 22, 18, 25],
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: '#ffc107',
                    borderWidth: 1
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
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
