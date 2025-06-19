<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliverer Dashboard - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
    <style>
        .driver-dashboard-container {
            display: flex;
            min-height: 80vh;
            background: #f6f6f6; /* match other pages */
        }
        .driver-profile-sidebar {
            width: 260px;
            background: #f0fdf4; /* soft green background */
            border-radius: 20px;
            margin: 30px 20px 30px 30px;
            padding: 30px 20px;
            box-shadow: 0 5px 20px rgba(16,185,129,0.08); /* green shadow */
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            min-width: 220px;
        }
        .profile-avatar svg {
            background: #f0fdf4;
            border-radius: 50%;
            padding: 8px;
        }
        .profile-username {
            font-weight: 700;
            font-size: 1.2rem;
            color: #059669; /* green */
            margin-bottom: 10px;
        }
        .profile-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        .profile-link {
            color: #059669; /* green */
            text-decoration: none;
            font-weight: 500;
            padding: 8px 0;
            border-radius: 8px;
            transition: background 0.2s;
            text-align: center;
        }
        .profile-link:hover {
            background: #d1fae5; /* lighter green */
        }
        .driver-dashboard-main {
            flex: 1;
            margin: 30px 30px 30px 0;
            background: #fff;
            border-radius: 20px;
            padding: 35px 40px;
            box-shadow: 0 5px 20px rgba(16,185,129,0.08); /* green shadow */
        }
        .delivery-requests-section, .completed-deliveries-section, .profile-section {
            margin-bottom: 40px;
        }
        .requests-list, .completed-list {
            display: grid;
            gap: 20px;
        }
        .request-card, .completed-card {
            background: #f0fdf4; /* soft green */
            border-radius: 15px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(16,185,129,0.07); /* green shadow */
            font-size: 1rem;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .request-card.status-pending {
            border-left: 6px solid #fbbf24; /* yellow */
        }
        .request-card.status-approved {
            border-left: 6px solid #059669; /* green */
        }
        .status-label {
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 5px;
        }
        .status-pending .status-label {
            color: #b45309; /* yellow-brown */
        }
        .status-approved .status-label {
            color: #059669; /* green */
        }
        .status-completed {
            color: #059669; /* green for completed */
        }
        .mark-delivered-btn {
            margin-top: 10px;
            background: #111827; /* black */
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .mark-delivered-btn:hover {
            background: #374151; /* dark gray on hover */
        }
        .completed-card {
            background: #e0f2fe; /* light blue for completed, but subtle */
            border-left: 6px solid #059669; /* green */
        }
        .completed-card .status-label {
            color: #059669; /* green */
        }
        .empty {
            opacity: 0.6;
            font-style: italic;
            text-align: center;
        }
        @media (max-width: 900px) {
            .driver-dashboard-container {
                flex-direction: column;
            }
            .driver-profile-sidebar {
                width: 100%;
                margin: 20px 20px 0 20px;
                flex-direction: row;
                justify-content: space-between;
                min-width: unset;
            }
            .driver-dashboard-main {
                margin: 20px;
                padding: 20px 10px;
            }
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
                <a href="{{ route('bookings.index') }}" class="nav-link">My Bookings</a>
                <a href="{{ route('login') }}" class="nav-link">Get Started</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; color: #b45309;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="driver-dashboard-container">
        <div class="driver-profile-sidebar">
            <div class="profile-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#fbbf24" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
                </svg>
            </div>
            <div class="profile-username">{{ auth()->user()->name ?? 'Deliverer' }}</div>
            <div class="profile-links">
                <a href="#delivery-requests" class="profile-link">Delivery Requests</a>
                <a href="#completed-deliveries" class="profile-link">Completed</a>
                <a href="#profile" class="profile-link">Profile</a>
            </div>
        </div>
        <div class="driver-dashboard-main">
            @if(session('success'))
                <div style="background:#d1fae5;color:#065f46;padding:12px 18px;border-radius:8px;margin-bottom:18px;font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fee2e2;color:#991b1b;padding:12px 18px;border-radius:8px;margin-bottom:18px;font-weight:600;">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background:#fef3c7;color:#92400e;padding:12px 18px;border-radius:8px;margin-bottom:18px;">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Delivery Requests Section -->
            <div id="delivery-requests" class="delivery-requests-section">
                <h3>Rental Delivery Requests</h3>
                <div class="requests-list">
                    @forelse($pending as $task)
                        <div class="request-card status-{{ $task->status }}">
                            <div><b>Customer:</b> {{ $task->booking->renter->name ?? '-' }}</div>
                            <div><b>Location:</b> {{ $task->booking->vehicle->location ?? '-' }}</div>
                            <div><b>Delivery Time:</b> {{ $task->booking->start_date->format('g:i A') ?? '-' }}</div>
                            <div><b>Rental Duration:</b> {{ $task->booking->duration }} days</div>
                            <div class="status-label">
                                @if($task->status === 'assigned') Pending Validation
                                @elseif($task->status === 'approved') Approved
                                @elseif($task->status === 'en_route') En Route
                                @endif
                            </div>
                            @if($task->status === 'assigned')
                                <form method="POST" action="{{ route('driver.delivery.accept', $task->id) }}" style="display:inline; margin-right:10px;">
                                    @csrf
                                    <button class="mark-delivered-btn" style="background:#059669;" type="submit">Accept</button>
                                </form>
                                <form method="POST" action="{{ route('driver.delivery.deny', $task->id) }}" style="display:inline; margin-left:10px;">
                                    @csrf
                                    <button class="mark-delivered-btn" style="background:#b91c1c;" type="submit">Deny</button>
                                </form>
                            @elseif($task->status === 'en_route')
                                <form method="POST" action="{{ route('driver.delivery.delivered', $task->id) }}" style="display:inline;">
                                    @csrf
                                    <button class="mark-delivered-btn" type="submit">Mark as Delivered</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="request-card empty">No delivery requests assigned yet.</div>
                    @endforelse
                </div>
            </div>
            <!-- Completed Deliveries Section -->
            <div id="completed-deliveries" class="completed-deliveries-section">
                <h3>Completed Deliveries</h3>
                <div class="completed-list">
                    @forelse($completed as $task)
                        <div class="completed-card">
                            <div><b>Customer:</b> {{ $task->booking->renter->name ?? '-' }}</div>
                            <div><b>Location:</b> {{ $task->booking->vehicle->location ?? '-' }}</div>
                            <div><b>Delivered At:</b> {{ $task->delivered_at ? $task->delivered_at->format('g:i A, M d') : '-' }}</div>
                            <div class="status-label status-completed">Delivered</div>
                        </div>
                    @empty
                        <div class="completed-card empty">No completed deliveries yet.</div>
                    @endforelse
                </div>
            </div>
            <!-- Profile Section -->
            <div id="profile" class="profile-section" style="display: flex; gap: 32px; align-items: flex-start; flex-wrap: wrap; background: #fffbe6; border-radius: 16px; box-shadow: 0 2px 8px rgba(251,191,36,0.07); padding: 32px 24px; margin-top: 32px;">
                <div style="min-width: 220px; flex: 1;">
                    <h3 style="color: #b45309; font-size: 1.3rem; font-weight: 700; margin-bottom: 18px;">Profile</h3>
                    <div style="margin-bottom: 18px;">
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Name:</b> {{ auth()->user()->name ?? '' }}</div>
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Email:</b> {{ auth()->user()->email ?? '' }}</div>
                        <div style="font-size: 1.1rem; margin-bottom: 6px;"><b>Phone:</b> {{ auth()->user()->phone ?? '-' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('driver.profile.update') }}" enctype="multipart/form-data" style="flex: 1; min-width: 260px; max-width: 340px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(251,191,36,0.05); padding: 24px 20px;">
                    @csrf
                    @method('PUT')
                    <h4 style="color: #b45309; font-size: 1.1rem; font-weight: 600; margin-bottom: 16px;">Update Info</h4>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #b45309;">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #fde68a;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #b45309;">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #fde68a;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #b45309;">Phone</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #fde68a;">
                    </div>
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #b45309;">Password <span style="font-weight:400; color:#b45309;">(leave blank to keep current)</span></label>
                        <input type="password" name="password" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1.5px solid #fde68a;">
                    </div>
                    <button type="submit" style="background: linear-gradient(90deg, #fbbf24, #fde68a); color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 12px 32px; font-size: 1.1rem; margin-top: 8px; cursor: pointer; transition: background 0.2s;">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
