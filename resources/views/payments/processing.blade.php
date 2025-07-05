@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Processing</div>

                <div class="card-body text-center">
                    <div id="payment-processing" class="mb-4">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h4>Processing Your Payment</h4>
                        <p class="text-muted">Please wait while we process your M-PESA payment...</p>
                    </div>

                    <div id="payment-success" class="d-none">
                        <div class="bg-success text-white p-3 rounded mb-3">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <h4>Payment Successful!</h4>
                            <p>Transaction Code: <span id="transaction-code" class="font-monospace">{{ $booking->payment->transaction_code }}</span></p>
                        </div>
                        <p>Your booking has been confirmed.</p>
                        
                        <!-- Countdown timer -->
                        <p class="mt-3">Redirecting to booking details in <span id="countdown">10</span> seconds...</p>
                        
                        <!-- Manual redirect button -->
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary mt-2">
                            View Booking Details Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check payment status every 2 seconds
    const checkPaymentStatus = () => {
        fetch('{{ route("payments.status", $booking) }}')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Hide processing and show success message
                    document.getElementById('payment-processing').classList.add('d-none');
                    document.getElementById('payment-success').classList.remove('d-none');
                    
                    // Update transaction code if available
                    if (data.transaction_code) {
                        document.getElementById('transaction-code').textContent = data.transaction_code;
                    }
                    
                    // Start countdown for redirection (10 seconds)
                    startCountdown(10);
                } else if (data.status === 'failed') {
                    // Redirect to payment form with error
                    window.location.href = '{{ route("payments.form", $booking) }}?error=failed';
                } else {
                    // Continue checking
                    setTimeout(checkPaymentStatus, 2000);
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
                setTimeout(checkPaymentStatus, 2000);
            });
    };
    
    // Function to start countdown timer
    const startCountdown = (seconds) => {
        const countdownElement = document.getElementById('countdown');
        let remainingSeconds = seconds;
        
        const countdownInterval = setInterval(() => {
            remainingSeconds--;
            countdownElement.textContent = remainingSeconds;
            
            if (remainingSeconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = '{{ route("bookings.show", $booking) }}';
            }
        }, 1000);
    };
    
    // Start checking payment status
    checkPaymentStatus();
});
</script>
@endsection
