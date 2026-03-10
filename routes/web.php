<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarberController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTAS PÚBLICAS (Lo que armamos nosotros)
// ==========================================
Route::get('/', [BarberController::class, 'index']);
Route::get('/agendar/{id}', [BarberController::class, 'showBookingForm']);
Route::post('/confirmar-cita', [BarberController::class, 'store']);
Route::get('/api/disponibilidad/{user_id}/{fecha}', [BarberController::class, 'checkAvailability']);

// ==========================================
// RUTAS PRIVADAS BREEZE (Requieren Login)
// ==========================================
Route::get('/dashboard', function () {
    // 1. Buscamos a los barberos en la base de datos
    $barberos = \App\Models\User::where('role', 'barber')->get();

    // 2. Se los mandamos a la vista con "compact"
    return view('dashboard', compact('barberos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/staff/availability', [\App\Http\Controllers\BarberController::class, 'staffAvailability']);
    Route::get('/staff/appointments', [\App\Http\Controllers\BarberController::class, 'getStaffAppointments']);
    Route::delete('/staff/appointments/{id}', [\App\Http\Controllers\BarberController::class, 'cancelAppointment']);
    Route::post('/staff/workdays/set', [\App\Http\Controllers\BarberController::class, 'setWorkday']);
});
require __DIR__.'/auth.php';