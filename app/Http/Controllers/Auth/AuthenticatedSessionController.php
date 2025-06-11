<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Clear ALL session data that might interfere with redirects
        $request->session()->forget(['url.intended', '_previous', 'intended_url']);

        // Force logout and re-login to ensure fresh session
        $userId = Auth::id();
        Auth::logout();

        // Re-authenticate with fresh user data
        $user = User::with('role')->find($userId);
        Auth::login($user);

        // Determine redirect URL based on fresh user role
        $redirectUrl = $this->getRedirectUrlForUser($user);

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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }
}
