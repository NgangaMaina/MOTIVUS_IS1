<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MpesaService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $passkey;
    protected $shortcode;
    protected $callbackUrl;
    protected $useFakePayments;
    protected $fakePaymentDelay;

    public function __construct()
    {
        $this->baseUrl = config('services.mpesa.env') === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke' 
            : 'https://api.safaricom.co.ke';
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passkey = config('services.mpesa.passkey');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->callbackUrl = config('services.mpesa.callback_url');
        $this->useFakePayments = config('services.mpesa.use_fake_payments', false);
        $this->fakePaymentDelay = config('services.mpesa.fake_payment_delay', 3);
    }

    /**
     * Generate a fake transaction code
     */
    protected function generateFakeTransactionCode()
    {
        return 'MP' . strtoupper(Str::random(8));
    }

    /**
     * Initiate STK Push
     */
    public function initiateSTKPush(Payment $payment, $phoneNumber)
    {
        // If using fake payments, return a successful response with a fake transaction code
        if ($this->useFakePayments) {
            $checkoutRequestId = $this->generateFakeTransactionCode();
            
            // Update payment with the fake checkout request ID
            $payment->update([
                'transaction_code' => $checkoutRequestId
            ]);
            
            // Schedule a job to simulate a successful callback after the delay
            if ($this->fakePaymentDelay > 0) {
                // Use dispatch to schedule a job that will mark the payment as successful
                dispatch(function () use ($payment) {
                    $payment->update([
                        'status' => 'success',
                        'paid_at' => now(),
                    ]);
                    
                    // Update booking status
                    $payment->booking->update(['status' => 'accepted']);
                })->delay(now()->addSeconds((int)$this->fakePaymentDelay)); // Ensure delay is cast to int
            } else {
                // Immediately mark as successful
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                ]);
                
                // Update booking status
                $payment->booking->update(['status' => 'accepted']);
            }
            
            return [
                'success' => true,
                'data' => [
                    'CheckoutRequestID' => $checkoutRequestId,
                    'ResponseDescription' => 'Success. Request accepted for processing',
                    'CustomerMessage' => 'Success. Request accepted for processing',
                ],
                'is_fake' => true
            ];
        }

        // Real M-PESA implementation would go here
        // For now, return an error since we don't have real credentials
        return [
            'success' => false,
            'message' => 'Real M-PESA integration not configured'
        ];
    }
    
    /**
     * Query STK Push status
     */
    public function querySTKStatus($checkoutRequestId)
    {
        if ($this->useFakePayments) {
            // For fake payments, just return a successful response
            return [
                'success' => true,
                'data' => [
                    'ResultCode' => 0,
                    'ResultDesc' => 'The service request is processed successfully.'
                ]
            ];
        }

        // Real implementation would go here
        return [
            'success' => false,
            'message' => 'Real M-PESA integration not configured'
        ];
    }
}


