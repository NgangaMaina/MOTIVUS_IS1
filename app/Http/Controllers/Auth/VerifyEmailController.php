<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            // Redirect based on user role
            $redirectUrl = $this->getRedirectUrlForUser($user) . '?verified=1';
            return redirect($redirectUrl);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Redirect based on user role after verification
        $redirectUrl = $this->getRedirectUrlForUser($user) . '?verified=1';
        return redirect($redirectUrl);
    }

    /**
     * Get the appropriate redirect URL for a user based on their role
     */
    private function getRedirectUrlForUser(User $user): string
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
