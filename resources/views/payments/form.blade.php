@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Complete Payment</div>

                <div class="card-body">
                    <h4>Booking Details</h4>
                    <p><strong>Vehicle:</strong> {{ $booking->vehicle->full_name }}</p>
                    <p><strong>Dates:</strong> {{ $booking->start_date->format('M d, Y') }} to {{ $booking->end_date->format('M d, Y') }}</p>
                    <p><strong>Total Amount:</strong> KSh {{ number_format($booking->total_amount) }}</p>

                    <hr>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Payment Form -->
                    <form method="POST" action="{{ route('payments.initiate', $booking) }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="phone_number">M-PESA Phone Number (Format: 254XXXXXXXXX)</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" 
                                   placeholder="254XXXXXXXXX" value="{{ old('phone_number') }}" required>
                            <small class="form-text text-muted">Enter the phone number to receive M-PESA payment request</small>
                            @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Pay KSh {{ number_format($booking->total_amount) }} with M-PESA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



