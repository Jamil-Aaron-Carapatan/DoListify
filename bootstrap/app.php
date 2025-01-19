<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->group('login.session', [
            \App\Http\Middleware\LoginSession::class, // Middleware to prevent back button navigation
        ]);
        $middleware->group('auth', [
            \App\Http\Middleware\Authenticate::class, // Middleware to prevent back button navigation
        ]);
        $middleware->group('registration.session', [
            \App\Http\Middleware\RegistrationSession::class, // Middleware to prevent back button navigation
        ]);
        $middleware->group('password.reset', [
            \App\Http\Middleware\PasswordReset::class, // Middleware to prevent back button navigation
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
