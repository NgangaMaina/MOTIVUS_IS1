<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:renter,owner'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Get the role ID
        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return back()->withErrors(['role' => 'Invalid role selected.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $role->id,
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to appropriate page based on role
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
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }
}
