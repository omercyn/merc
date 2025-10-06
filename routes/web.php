<?php
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Hapus route default yang ada jika menggunakan Laravel 11
Route::resource('mahasiswas', MahasiswaController::class);

// Atur root path
Route::get('/', function () {
    return redirect()->route('mahasiswas.index');
});