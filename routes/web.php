<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'registerPage']);

Route::group(['prefix' => 'panel-control'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
    Route::get('/vehicles', [DashboardController::class, 'vehicles'])->name('vehicles.vehicles');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

});
