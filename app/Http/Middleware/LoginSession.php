<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('login_session')) {
            return redirect()->route('auth.login')
                ->with('error', 'Please login first.');
        }
        return $next($request);
    }
}