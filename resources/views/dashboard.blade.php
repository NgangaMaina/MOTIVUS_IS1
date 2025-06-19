<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
</head>
<body>
    <div class="mobile-container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">MOTIVUS</div>
                    <h1 class="auth-title">Welcome, {{ auth()->check() && auth()->user() ? auth()->user()->name : 'Guest' }}!</h1>
                    <p class="auth-subtitle">You're logged in as a {{ auth()->check() && auth()->user() && auth()->user()->role ? auth()->user()->role->name : 'guest' }}</p>
                </div>

                <div style="text-align: center; margin: 30px 0;">
                    <p>🎉 Your beautiful mobile-responsive pages are working!</p>
                    <p>Role: <strong>{{ auth()->check() && auth()->user() && auth()->user()->role ? ucfirst(auth()->user()->role->name) : 'Guest' }}</strong></p>
                    <p>Email: <strong>{{ auth()->check() && auth()->user() ? auth()->user()->email : '' }}</strong></p>
                    @if(auth()->check() && auth()->user() && auth()->user()->phone)
                        <p>Phone: <strong>{{ auth()->user()->phone }}</strong></p>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="primary-btn">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
