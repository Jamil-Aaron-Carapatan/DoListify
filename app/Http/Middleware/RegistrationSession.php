<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegistrationSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('registration_session')) {
            return redirect()->route('register')
                ->with('error', 'Please complete registration first.');
        }
        return $next($request);
    }
}
