<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\OfficerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'registerPage']);

Route::group(['prefix' => 'panel-control'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    // Vehicles
    Route::get('/vehicles', [DashboardController::class, 'vehicles'])->name('vehicles.vehicles');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

    // Officers CRUD
    Route::get('/officers', [OfficerController::class, 'index'])->name('officers.index');
    Route::get('/officers/create', [OfficerController::class, 'create'])->name('officers.create');
    Route::post('/officers', [OfficerController::class, 'store'])->name('officers.store');
    Route::get('/officers/{officer}/edit', [OfficerController::class, 'edit'])->name('officers.edit');
    Route::put('/officers/{officer}', [OfficerController::class, 'update'])->name('officers.update');
    Route::delete('/officers/{officer}', [OfficerController::class, 'destroy'])->name('officers.destroy');
});
