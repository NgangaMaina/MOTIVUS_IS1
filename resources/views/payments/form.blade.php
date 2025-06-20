@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Complete Payment</h2>
                </div>
                <div class="card-body">
                    <div class="booking-details mb-4">
                        <h4>Booking Details</h4>
                        <p><strong>Vehicle:</strong> {{ $booking->vehicle->make }} {{ $booking->vehicle->model }} ({{ $booking->vehicle->year }})</p>
                        <p><strong>Dates:</strong> {{ $booking->start_date->format('M d, Y') }} to {{ $booking->end_date->format('M d, Y') }}</p>
                        <p><strong>Duration:</strong> {{ $booking->duration }} days</p>
                        <p><strong>Total Amount:</strong> KSh {{ number_format($booking->total_amount, 2) }}</p>
                    </div>

                    <div class="payment-section">
                        <h4>Pay with M-PESA</h4>
                        <p class="text-muted">You will receive a prompt on your phone to complete the payment.</p>
                        
                        <form action="{{ route('payments.initiate', $booking) }}" method="POST" class="payment-form" id="payment-form">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="phone_number">M-PESA Phone Number (Format: 254XXXXXXXXX)</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" 
                                    placeholder="254712345678" value="{{ old('phone_number', auth()->user()->phone ?? '') }}" required>
                                <small class="form-text text-muted">Enter your phone number in the format 254XXXXXXXXX (e.g., 254712345678)</small>
                                @error('phone_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" id="pay-button">Pay KSh {{ number_format($booking->total_amount, 2) }}</button>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>

                        <div id="payment-processing" class="mt-4 text-center d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Sending payment request to M-PESA...</p>
                            <p class="text-muted small">Please wait while we process your payment.</p>
                        </div>

                        <div id="payment-success" class="mt-4 alert alert-success d-none">
                            <h5><i class="bi bi-check-circle-fill"></i> Payment Successful!</h5>
                            <p>Your payment has been processed successfully.</p>
                            <p>Transaction Code: <strong id="transaction-code"></strong></p>
                            <p>You will be redirected to your booking details shortly...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('payment-form');
    const payButton = document.getElementById('pay-button');
    const processingDiv = document.getElementById('payment-processing');
    const successDiv = document.getElementById('payment-success');
    const transactionCodeSpan = document.getElementById('transaction-code');
    
    // Create notification container
    const notificationContainer = document.createElement('div');
    notificationContainer.id = 'payment-notification-container';
    notificationContainer.className = 'payment-notification-container';
    notificationContainer.innerHTML = `
        <div class="payment-notification" id="payment-notification">
            <div class="notification-icon">✅</div>
            <div class="notification-content">
                <h3>Payment Successful!</h3>
                <p>Your car is on the way. The owner has been notified.</p>
                <p class="transaction-info">Transaction ID: <span id="notification-transaction-code"></span></p>
            </div>
            <button class="notification-close" id="notification-close">×</button>
        </div>
    `;
    document.body.appendChild(notificationContainer);
    
    // Add CSS for the notification
    const style = document.createElement('style');
    style.textContent = `
        .payment-notification-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .payment-notification {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 25px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }
        .notification-icon {
            font-size: 50px;
            margin-bottom: 15px;
            color: #4CAF50;
        }
        .notification-content h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 22px;
        }
        .notification-content p {
            color: #666;
            margin-bottom: 8px;
            font-size: 16px;
        }
        .transaction-info {
            font-size: 14px;
            color: #888;
            margin-top: 15px;
        }
        .notification-close {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    // Get notification elements
    const notificationTransactionCode = document.getElementById('notification-transaction-code');
    const notificationClose = document.getElementById('notification-close');
    
    // Close notification when clicking the close button
    notificationClose.addEventListener('click', function() {
        document.getElementById('payment-notification-container').style.display = 'none';
        window.location.href = '{{ route('bookings.show', $booking) }}';
    });
    
    // Function to show the notification
    function showSuccessNotification(transactionCode) {
        console.log('Showing success notification with transaction code:', transactionCode);
        if (notificationTransactionCode) {
            notificationTransactionCode.textContent = transactionCode || '';
        }
        document.getElementById('payment-notification-container').style.display = 'flex';
    }
    
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted');
            
            // Show processing spinner
            payButton.disabled = true;
            processingDiv.classList.remove('d-none');
            
            // Get form data
            const formData = new FormData(paymentForm);
            
            // Send AJAX request
            fetch('{{ route('payments.initiate', $booking) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Payment response:', data);
                if (data.success) {
                    // If it's a fake payment, show success immediately or after a short delay
                    if (data.is_fake) {
                        setTimeout(() => {
                            processingDiv.classList.add('d-none');
                            console.log('Showing notification for fake payment');
                            showSuccessNotification(data.transaction_code);
                        }, 2000); // Show success after 2 seconds
                    } else {
                        // For real payments, start polling for status
                        pollPaymentStatus();
                    }
                } else {
                    // Show error
                    processingDiv.classList.add('d-none');
                    payButton.disabled = false;
                    alert('Payment failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                processingDiv.classList.add('d-none');
                payButton.disabled = false;
                alert('An error occurred. Please try again.');
            });
        });
    }
    
    // Function to poll payment status
    function pollPaymentStatus() {
        const checkStatus = () => {
            fetch('{{ route('payments.status', $booking) }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Payment status:', data);
                    if (data.status === 'success') {
                        // Payment successful, show notification
                        processingDiv.classList.add('d-none');
                        console.log('Showing notification for real payment');
                        showSuccessNotification(data.transaction_code);
                    } else if (data.status === 'failed') {
                        // Payment failed
                        processingDiv.classList.add('d-none');
                        payButton.disabled = false;
                        alert('Payment failed. Please try again.');
                    } else {
                        // Still pending, continue polling
                        setTimeout(checkStatus, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                    setTimeout(checkStatus, 3000);
                });
        };
        
        // Start polling
        checkStatus();
    }
    
    // Debug check - log if elements are found
    console.log('Payment form found:', !!paymentForm);
    console.log('Notification container found:', !!document.getElementById('payment-notification-container'));
});
</script>
@endsection



