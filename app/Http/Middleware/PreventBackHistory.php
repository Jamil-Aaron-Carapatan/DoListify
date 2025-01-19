<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Redirect to registration if trying to verify email without registration
        if ($request->is('DoListify/Verify-Email') && !session('registration_complete')) {
            return redirect()->route('auth.register');
        }

        // Redirect to login if accessing successful registration without verification
        if ($request->is('DoListify/Successful-Registration') && !session('email_verified')) {
            return redirect()->route('auth.login');
        }

        // Redirect to login if verifying identity without being verified
        if ($request->is('DoListify/Verify-its-you') && !session('registration_complete')) {
            return redirect()->route('auth.login');
        }

        // Clear email_verified session after leaving successful registration
        if (!$request->is('DoListify/Successful-Registration') && session('email_verified')) {
            session()->forget('email_verified');
        }

        // Clear registration_complete only after a successful verification process
        if (!$request->is('DoListify/Verify-Email') && session('registration_complete')) {
            session()->forget('registration_complete');
        }
        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}

