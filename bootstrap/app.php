<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\App;


// 1. DEFINISIKAN OBJEK $app TERLEBIH DAHULU. 
// Simpan hasil Application::configure() ke dalam variabel $app.
$app = Application::configure(basePath: dirname(__DIR__));

// 2. KOREKSI PATH STORAGE SETELAH $app DIDEFINISIKAN.
// Baris ini sekarang aman karena $app sudah ada.
if (isset($_ENV['VERCEL_URL']) || env('APP_ENV') === 'production') {
    // Arahkan storage root ke direktori /tmp yang bisa ditulis di Vercel
    $app->useStoragePath('/tmp/storage');
}

// 3. SELESAIKAN KONFIGURASI DENGAN MENGGUNAKAN OBJEK $app YANG SUDAH ADA.
return $app
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
    ->withMiddleware(function (Middleware $middleware) {
        // ... middleware lain jika ada
        $middleware->trustProxies(at: '*'); // PENTING untuk Vercel
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
