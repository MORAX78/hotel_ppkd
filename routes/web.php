<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Root redirect
Route::get('/', fn() => redirect()->route('login'));

// Protected routes
Route::middleware('auth')->group(function () {
    Route::resource('reservations', ReservationController::class)
         ->only(['index','create','store','show','edit','update']);

    Route::get('reservations/{reservation}/print',
        [ReservationController::class, 'print'])->name('reservations.print');

    Route::patch('reservations/{reservation}/status',
        [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
});
