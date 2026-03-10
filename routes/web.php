<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarberController;
use Illuminate\Http\Request;

Route::get('/', [BarberController::class, 'index']);
// Ruta para ver el formulario de agendar con un barbero específico
Route::get('/agendar/{id}', [BarberController::class, 'showBookingForm']);
//ruta guardar cita
Route::post('/confirmar-cita', [App\Http\Controllers\BarberController::class, 'store'])->name('appointments.store');Route::get('/api/disponibilidad/{user_id}/{fecha}', [BarberController::class, 'checkAvailability']);Route::get('/api/disponibilidad/{user_id}/{fecha}', [BarberController::class, 'checkAvailability']);
//consulta disponibilidad
Route::get('/api/disponibilidad/{user_id}/{fecha}', [BarberController::class, 'checkAvailability']);

//ruta para conexion del staffa con el calendario de jeric.alla
Route::get('/staff', function () {
    // Traemos a los barberos para pasárselos al JavaScript
    $barberos = \App\Models\User::where('role', 'barber')->get();
    return view('staff', compact('barberos'));
});