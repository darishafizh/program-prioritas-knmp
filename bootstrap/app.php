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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function ($request) {
            $request->session()->flash('error', 'Sesi Anda telah berakhir, silakan login kembali.');
            return route('login');
        });

        // Register global middleware
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // Register web middleware
        $middleware->web(prepend: [
            \App\Http\Middleware\DecodeHashIds::class,
        ]);

        // Register role middleware alias
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'village_access' => \App\Http\Middleware\CheckVillageAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            \Illuminate\Support\Facades\Log::warning('404 URL: ' . request()->fullUrl());
        });
    })->create();
