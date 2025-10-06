<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;


// 1. BUAT APLIKASI UTAMA (BELUM DIEKSEKUSI)
$app_builder = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    ->withMiddleware(function (Middleware $middleware) {
        // ... middleware lain jika ada
        $middleware->trustProxies(at: '*'); 
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    });

// 2. EKSEKUSI BUILDER UNTUK MENDAPATKAN OBJEK APPLICATION
$app = $app_builder->create();

// 3. PANGGIL useStoragePath() PADA OBJEK APPLICATION ($app) YANG SUDAH JADI
// Ini adalah koreksi untuk error "undefined method"
if (isset($_ENV['VERCEL_URL']) || env('APP_ENV') === 'production') {
    // Arahkan storage root ke direktori /tmp yang bisa ditulis di Vercel
    $app->useStoragePath('/tmp/storage');
}

// 4. KEMBALIKAN APLIKASI
return $app;
