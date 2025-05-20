<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\InspeksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/mobil', [MobilController::class, 'index']);
Route::get('/mobil/create', [MobilController::class, 'create']);
Route::get('/mobil/{id}', [MobilController::class, 'edit']);
Route::post('/mobil', [MobilController::class, 'store']);
Route::put('/mobil/{id}', [MobilController::class, 'update']);
Route::delete('/mobil/{id}', [MobilController::class, 'destroy']);

Route::get('/inspeksi', [InspeksiController::class, 'index']);
Route::get('/inspeksi/create', [InspeksiController::class, 'create']);
Route::get('/inspeksi/{id}', [InspeksiController::class, 'edit']);
Route::post('/inspeksi', [InspeksiController::class, 'store']);
Route::put('/inspeksi/{id}', [InspeksiController::class, 'update']);
Route::delete('/inspeksi/{id}', [InspeksiController::class, 'destroy']);
