<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role if already verified
            $user = $request->user();
            $redirectUrl = $this->getRedirectUrlForUser($user);
            return redirect($redirectUrl);
        }

        $request->user()->sendEmailVerificationNotification();

        // For AJAX requests, return JSON
        if ($request->expectsJson()) {
            return response()->json(['status' => 'verification-link-sent']);
        }

        // For web requests, redirect back with success message
        return back()->with('status', 'verification-link-sent');
    }

    /**
     * Get the appropriate redirect URL for a user based on their role
     */
    private function getRedirectUrlForUser($user): string
    {
        // Ensure role is loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        $roleName = $user->role->name;

        switch ($roleName) {
            case 'admin':
                return '/admin/dashboard';
            case 'owner':
                return '/owner/dashboard';
            case 'renter':
            default:
                return '/vehicles';
        }
    }
}
