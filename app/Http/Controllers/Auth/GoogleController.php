<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Get default renter role for Google OAuth users
                $renterRole = Role::where('name', 'renter')->first();

                if (!$renterRole) {
                    return redirect('/register')->withErrors(['error' => 'System error: Default role not found.']);
                }

                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'role_id' => $renterRole->id,
                    'email_verified_at' => now(), // Google accounts are pre-verified
                    'password' => Hash::make(Str::random(24)),
                ]);
            }

            Auth::login($user, true);

            // Refresh user with role relationship for accurate role checking
            $user = User::with('role')->find($user->id);

            // Redirect based on user role
            $redirectUrl = $this->getRedirectUrlForUser($user);
            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Google authentication failed. Please try again.']);
        }
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
            case 'driver':
                return '/driver/dashboard';
            case 'renter':
            default:
                return '/user/dashboard';
        }
    }
}
