<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordReset
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');
        if (!$token || !DB::table('password_resets')->where('token', $token)->exists()) {
            return redirect()->route('reset.password', ['token' => $token])
                ->with('error', 'Invalid password reset link.');
        }
        return $next($request);
    }
}