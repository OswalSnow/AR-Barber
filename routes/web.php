<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarberController;
use Illuminate\Support\Facades\Route;

//Rutas publicas

Route::get('/', [BarberController::class, 'index']);
Route::get('/agendar/{id}', [BarberController::class, 'showBookingForm']);
Route::post('/confirmar-cita', [BarberController::class, 'store'])->middleware('throttle:3,1');
Route::get('/api/disponibilidad/{user_id}/{fecha}', [BarberController::class, 'checkAvailability']);

Route::get('/servicios', function () {
    $images = \App\Models\PortfolioImage::latest()->get();
    return view('servicios', compact('images'));
});

// RUTAS PRIVADAS BREEZE (Requieren Login)

Route::get('/dashboard', function () {
    $barberos = \App\Models\User::where('role', 'barber')->get();
    return view('dashboard', compact('barberos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/staff/availability', [\App\Http\Controllers\BarberController::class, 'staffAvailability']);
    Route::get('/staff/appointments', [\App\Http\Controllers\BarberController::class, 'getStaffAppointments']);
    Route::delete('/staff/appointments/{id}', [\App\Http\Controllers\BarberController::class, 'cancelAppointment']);
    Route::post('/staff/workdays/set', [\App\Http\Controllers\BarberController::class, 'setWorkday']);
    Route::post('/staff/portfolio', [App\Http\Controllers\PortfolioImageController::class, 'store'])->name('staff.portfolio.store');
    Route::delete('/staff/portfolio/{id}', [App\Http\Controllers\PortfolioImageController::class, 'destroy'])->name('staff.portfolio.destroy');
});
require __DIR__.'/auth.php';