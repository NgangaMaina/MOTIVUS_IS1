<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\MpesaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Show payment form for a booking
     */
    public function showPaymentForm(Booking $booking)
    {
        // Verify booking belongs to authenticated user
        if ($booking->renter_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access to booking');
        }
        
        // Check if booking is already paid
        if ($booking->payment && $booking->payment->status === 'success') {
            return redirect()->route('bookings.show', $booking)
                ->with('info', 'This booking has already been paid for.');
        }
        
        return view('payments.form', compact('booking'));
    }

    /**
     * Initiate payment for a booking
     */
    public function initiatePayment(Request $request, Booking $booking)
    {
        // Verify booking belongs to authenticated user
        if ($booking->renter_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access to booking');
        }

        // Validate phone number
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^254[0-9]{9}$/'
        ]);

        // Check if there's an existing pending payment
        $existingPayment = $booking->payment;
        
        if ($existingPayment && $existingPayment->status === 'pending') {
            // Use existing payment
            $payment = $existingPayment;
        } else {
            // Create new payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'transaction_code' => 'PENDING-' . uniqid(), // Temporary code until we get the real one
                'amount' => $booking->total_amount,
                'status' => 'pending',
            ]);
        }

        // Generate a fake transaction code (MP + 8 random uppercase characters)
        $transactionCode = 'MP' . strtoupper(Str::random(8));
        
        // Update payment with the transaction code
        $payment->update([
            'transaction_code' => $transactionCode
        ]);
        
        // Schedule a job to mark payment as successful after a delay (3 seconds)
        dispatch(function () use ($payment, $booking) {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);
            
            // Update booking status
            $booking->update(['status' => 'accepted']);
        })->delay(now()->addSeconds(3));
        
        // Redirect to a payment processing page
        return redirect()->route('payments.processing', $booking);
    }

    /**
     * Show payment processing page
     */
    public function showProcessing(Booking $booking)
    {
        return view('payments.processing', compact('booking'));
    }

    /**
     * M-PESA callback endpoint
     */
    public function mpesaCallback(Request $request)
    {
        Log::info('M-PESA callback received', $request->all());

        $callbackData = $request->json()->all();
        
        if (isset($callbackData['Body']['stkCallback'])) {
            $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
            $checkoutRequestID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
            
            // Find payment by checkout request ID
            $payment = Payment::where('transaction_code', $checkoutRequestID)->first();
            
            if ($payment) {
                if ($resultCode == 0) {
                    // Payment successful
                    $payment->update([
                        'status' => 'success',
                        'paid_at' => Carbon::now(),
                    ]);
                    
                    // Update booking status
                    $payment->booking->update(['status' => 'accepted']);
                } else {
                    // Payment failed
                    $payment->update(['status' => 'failed']);
                }
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }

    /**
     * Check payment status
     */
    public function checkStatus(Booking $booking)
    {
        $payment = $booking->payment;
        
        if (!$payment) {
            return response()->json(['status' => 'no_payment']);
        }
        
        // If payment is pending and has a transaction code, query M-PESA for status
        if ($payment->status === 'pending' && $payment->transaction_code) {
            $result = $this->mpesaService->querySTKStatus($payment->transaction_code);
            
            if ($result['success'] && isset($result['data']['ResultCode'])) {
                $resultCode = $result['data']['ResultCode'];
                
                if ($resultCode == 0) {
                    // Payment successful
                    $payment->update([
                        'status' => 'success',
                        'paid_at' => Carbon::now(),
                    ]);
                    
                    // Update booking status
                    $payment->booking->update(['status' => 'accepted']);
                } else if ($resultCode != 1) {
                    // Payment failed (1 means the transaction is in progress)
                    $payment->update(['status' => 'failed']);
                }
            }
        }
        
        return response()->json([
            'status' => $payment->status,
            'paid_at' => $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : null,
            'transaction_code' => $payment->transaction_code,
            'is_fake' => config('services.mpesa.use_fake_payments', false)
        ]);
    }

    /**
     * Manual trigger for fake payment success (for testing)
     */
    public function simulateSuccess(Booking $booking)
    {
        if (!config('services.mpesa.use_fake_payments', false)) {
            return response()->json(['error' => 'Fake payments are not enabled'], 400);
        }

        $payment = $booking->payment;
        
        if (!$payment) {
            return response()->json(['error' => 'No payment found for this booking'], 404);
        }
        
        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);
        
        // Update booking status
        $booking->update(['status' => 'accepted']);
        
        return response()->json([
            'success' => true,
            'message' => 'Payment marked as successful',
            'payment' => $payment
        ]);
    }
}






