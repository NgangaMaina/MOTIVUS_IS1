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
                    <h1 class="verification-title">Enter OTP Code</h1>
                    <p class="verification-subtitle">
                        We've sent a verification code to<br>
                        <strong>{{ auth()->user()->email ?? 'your email' }}</strong>
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

                <!-- OTP Form -->
                <form method="POST" action="{{ route('verification.send') }}" id="otpForm">
                    @csrf
                    
                    <div class="verification-container">
                        <div class="otp-container">
                            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="one-time-code">
                            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                            <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric">
                        </div>

                        <button type="submit" class="primary-btn">
                            VERIFY
                        </button>

                        <div class="resend-text">
                            Didn't receive the code? 
                            <button type="submit" class="resend-link" style="background: none; border: none; color: #0099cc; text-decoration: underline; cursor: pointer;">
                                Resend
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="auth-footer">
                    <a href="{{ route('login') }}">← Back to Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // OTP Input Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input
                    if (value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    
                    // Auto-submit when all fields are filled
                    const allFilled = Array.from(otpInputs).every(input => input.value);
                    if (allFilled) {
                        // You can auto-submit here or just highlight the verify button
                        document.querySelector('.primary-btn').style.background = 'linear-gradient(45deg, #00ff88, #00cc66)';
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text');
                    const digits = pastedData.replace(/\D/g, '').slice(0, 4);
                    
                    digits.split('').forEach((digit, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digit;
                        }
                    });
                    
                    // Focus on the last filled input or next empty one
                    const lastIndex = Math.min(digits.length - 1, otpInputs.length - 1);
                    otpInputs[lastIndex].focus();
                });
            });
        });
    </script>
</body>
</html>
