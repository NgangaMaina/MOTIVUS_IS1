<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Development Routes
|--------------------------------------------------------------------------
|
| These routes are only for development and testing purposes.
| DO NOT use in production!
|
*/

// Only enable in local environment
if (app()->environment('local')) {
    
    Route::prefix('dev')->name('dev.')->group(function () {
        
        // Show all users and their verification status
        Route::get('/users', function () {
            $users = User::with('role')->get(['id', 'name', 'email', 'email_verified_at', 'role_id']);
            
            $html = '<h1>MOTIVUS - Development User List</h1>';
            $html .= '<style>table{border-collapse:collapse;width:100%;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f2f2f2;}</style>';
            $html .= '<table>';
            $html .= '<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Verified</th><th>Actions</th></tr>';
            
            foreach ($users as $user) {
                $verified = $user->email_verified_at ? 'Yes' : 'No';
                $verifyBtn = $user->email_verified_at ? '' : '<a href="/dev/verify-user/' . $user->id . '" style="background:#28a745;color:white;padding:4px 8px;text-decoration:none;border-radius:4px;">Verify</a>';
                $unverifyBtn = $user->email_verified_at ? '<a href="/dev/unverify-user/' . $user->id . '" style="background:#dc3545;color:white;padding:4px 8px;text-decoration:none;border-radius:4px;">Unverify</a>' : '';
                
                $html .= '<tr>';
                $html .= '<td>' . $user->id . '</td>';
                $html .= '<td>' . $user->name . '</td>';
                $html .= '<td>' . $user->email . '</td>';
                $html .= '<td>' . ($user->role->name ?? 'N/A') . '</td>';
                $html .= '<td>' . $verified . '</td>';
                $html .= '<td>' . $verifyBtn . ' ' . $unverifyBtn . '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</table>';
            $html .= '<br><a href="/dev/test-verification" style="background:#007bff;color:white;padding:8px 16px;text-decoration:none;border-radius:4px;">Test Email Verification</a>';
            
            return $html;
        });
        
        // Manually verify a user (for testing)
        Route::get('/verify-user/{user}', function (User $user) {
            $user->markEmailAsVerified();
            return redirect('/dev/users')->with('message', 'User ' . $user->email . ' has been verified!');
        });
        
        // Manually unverify a user (for testing)
        Route::get('/unverify-user/{user}', function (User $user) {
            $user->email_verified_at = null;
            $user->save();
            return redirect('/dev/users')->with('message', 'User ' . $user->email . ' has been unverified!');
        });
        
        // Test verification email system
        Route::get('/test-verification', function () {
            $html = '<h1>Email Verification Test</h1>';
            $html .= '<p><strong>Important:</strong> In development mode, emails are logged to <code>storage/logs/laravel.log</code> instead of being sent to real email addresses.</p>';
            
            $html .= '<h2>How to Test Email Verification:</h2>';
            $html .= '<ol>';
            $html .= '<li>Register a new user or use an unverified user</li>';
            $html .= '<li>Check <code>storage/logs/laravel.log</code> for the verification email</li>';
            $html .= '<li>Copy the verification URL from the log</li>';
            $html .= '<li>Paste it in your browser to verify the user</li>';
            $html .= '</ol>';
            
            $html .= '<h2>Generate Test Verification Link:</h2>';
            $html .= '<form method="GET" action="/dev/generate-verification-link">';
            $html .= '<label>User Email: <input type="email" name="email" placeholder="user@example.com" required></label><br><br>';
            $html .= '<button type="submit" style="background:#28a745;color:white;padding:8px 16px;border:none;border-radius:4px;">Generate Link</button>';
            $html .= '</form>';
            
            $html .= '<br><a href="/dev/users">← Back to User List</a>';
            
            return $html;
        });
        
        // Verify current user (for quick testing)
        Route::get('/verify-current-user', function () {
            $user = Auth::user();
            if ($user) {
                $user->markEmailAsVerified();
                return redirect('/dev/users')->with('message', 'Current user (' . $user->email . ') has been verified!');
            }
            return redirect('/dev/users')->with('error', 'No user logged in!');
        });

        // Generate verification link for testing
        Route::get('/generate-verification-link', function () {
            $email = request('email');
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                return redirect('/dev/test-verification')->with('error', 'User not found!');
            }
            
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );
            
            $html = '<h1>Verification Link Generated</h1>';
            $html .= '<p><strong>User:</strong> ' . $user->name . ' (' . $user->email . ')</p>';
            $html .= '<p><strong>Verification Status:</strong> ' . ($user->email_verified_at ? 'Verified' : 'Unverified') . '</p>';
            $html .= '<p><strong>Verification URL:</strong></p>';
            $html .= '<textarea style="width:100%;height:100px;">' . $verificationUrl . '</textarea>';
            $html .= '<br><br><a href="' . $verificationUrl . '" style="background:#007bff;color:white;padding:8px 16px;text-decoration:none;border-radius:4px;">Click to Verify</a>';
            $html .= '<br><br><a href="/dev/users">← Back to User List</a>';
            
            return $html;
        });
    });
}
