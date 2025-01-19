<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLoginAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Redirect to login if verifying identity without being verified
        if ($request->is('DoListify/Verify-its-you') && !session('pending_verification')) {
            return redirect()->route('auth.login');
        }
        if (!$request->is('DoListify/Verify-its-you') && session('pending_verification')) {
            session()->forget('pending_verification');
        }
        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
