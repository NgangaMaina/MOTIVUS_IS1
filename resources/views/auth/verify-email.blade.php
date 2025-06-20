<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - MOTIVUS</title>
    <link href="{{ asset('css/motivus.css') }}" rel="stylesheet">
</head>
<body>
    <div class="mobile-container">
        <div class="auth-container">
            <div class="auth-card">
                <!-- Header -->
                <div class="auth-header">
                    <div class="auth-logo">MOTIVUS</div>
                    <h1 class="verification-title">Verify Your Email</h1>
                    <p class="verification-subtitle">
                        We've sent a verification link to<br>
                        <strong>{{ auth()->user()->fresh()->email ?? 'your email' }}</strong>
                    </p>
                </div>

                <!-- Success/Error Messages -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Verification Instructions -->
                <div class="verification-container">
                    <div class="verification-instructions">
                        <div class="verification-icon">
                            📧
                        </div>
                        <p>Please check your email and click the verification link to activate your account.</p>
                        <p>If you don't see the email, check your spam folder.</p>
                    </div>

                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="primary-btn">
                            Resend Verification Email
                        </button>
                    </form>

                    <!-- Logout Option -->
                    <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
                        @csrf
                        <button type="submit" class="secondary-btn">
                            Sign Out
                        </button>
                    </form>
                </div>

                <!-- Back to Login -->
                <div class="auth-footer">
                    <a href="{{ route('login') }}">← Back to Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .verification-instructions {
            text-align: center;
            margin: 30px 0;
        }

        .verification-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .verification-instructions p {
            margin: 15px 0;
            color: #666;
            line-height: 1.5;
        }

        .secondary-btn {
            background: transparent;
            color: #666;
            border: 1px solid #ddd;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .secondary-btn:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
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
</body>
</html>
