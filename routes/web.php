<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

Route::get('/home', function () {
    return redirect('/admin');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->middleware('UserAkses:admin');
    Route::get('/admin/penjual', [AdminController::class, 'penjual'])->middleware('UserAkses:pembeli');
    Route::get('/admin/pembeli', [AdminController::class, 'pembeli'])->middleware('UserAkses:pembeli');
    Route::get('/admin/inspektor', [AdminController::class, 'inspektor'])->middleware('UserAkses:inspektor');
    Route::get('/logout', [SesiController::class, 'logout']);
});
