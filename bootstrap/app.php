<?php

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, $request) {
             if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed. Please check your input.', // <-- custom message
                    'errors' => $e->errors(),
                ], 422);
             }
        });
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required. Please log in.',
                ], 401);
            }

            Toastr::error('You must be logged in to access this page.');
            return redirect()->guest(route('login'));
        });
    })->create();
