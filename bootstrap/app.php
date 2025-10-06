<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;


if (isset($_ENV['VERCEL_URL']) || env('APP_ENV') === 'production') {
    // Arahkan storage ke direktori /tmp
    $app->useStoragePath('/tmp/storage');
}
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    ->withMiddleware(function (Middleware $middleware) {
        // ... middleware lain jika ada
        $middleware->trustProxies(at: '*'); // TAMBAHKAN INI
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();