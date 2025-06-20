<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip verification for admin users
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if (! $user ||
            ($user instanceof MustVerifyEmail &&
            ! $user->hasVerifiedEmail())) {

            // For AJAX requests, return JSON response
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your email address is not verified.'], 409);
            }

            // For web requests, redirect to verification notice
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
