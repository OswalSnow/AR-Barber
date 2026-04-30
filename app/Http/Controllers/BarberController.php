<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    public function index()
    {
        // 1. El orden nuevo (fíjate que Anibal ya no tiene acento para que coincida con tu DB)
        $ordenDeseado = ['Alberto', 'Anibal', 'Kinich', 'Angel'];

        $barberos = User::where('role', 'barber')
                        ->where('is_active', true)
                        ->get()
                        ->sortBy(function ($user) use ($ordenDeseado) {
                            // Limpiamos espacios en blanco por si las moscas y buscamos la posición
                            $posicion = array_search(trim($user->name), $ordenDeseado);
                            // Si no lo encuentra, lo manda al final (99)
                            return $posicion === false ? 99 : $posicion;
                        })
                        // 2. IMPORTANTE: values() reordena los índices internos para que el foreach de Blade no se vuelva loco
                        ->values()
                        // 3. El parche para ocultar las redes de Kinich
                        ->map(function ($barbero) {
                            if (str_contains($barbero->name, 'Kinich')) {
                                // Ajusta estas columnas según cómo se llamen en tu DB
                                $barbero->facebook = null;
                                $barbero->instagram = null; 
                            }
                            return $barbero;
                        });

        return view('welcome', compact('barberos'));
    }

    public function showBookingForm($id)
    {
        $barbero = User::findOrFail($id);
        return view('booking', compact('barbero'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|regex:/^[0-9]{10}$/',
            'servicio'       => 'required|in:corte,barba,ambos',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora'           => 'required',
            'user_id'        => 'required|exists:users,id',
        ]);

        // 1. Calculamos la duración
        $duracion = $request->servicio == 'ambos' ? 60 : 30;

        // 2. Armamos las fechas de inicio y fin con Carbon
        $fechaInicio = \Carbon\Carbon::parse($request->fecha . ' ' . $request->hora . ':00');
        $fechaFin = $fechaInicio->copy()->addMinutes((int)$duracion);

        // 3. Verificación Anti-Spam: Máximo 2 citas activas
        $citasActivas = \App\Models\Appointment::where('customer_phone', $request->customer_phone)
                        ->where('starts_at', '>=', now())
                        ->count();

        if ($citasActivas >= 2) {
            return back()->withErrors(['customer_phone' => 'límite']); // Dispara el aviso de WhatsApp
        }

        // 4. Verificación de seguridad por si alguien más ganó el lugar
        // Chocan si: (NuevoInicio < ViejoFin) Y (NuevoFin > ViejoInicio)
        $existeCita = \App\Models\Appointment::where('user_id', $request->user_id)
                        ->whereDate('starts_at', $fechaInicio->toDateString())
                        ->where(function ($query) use ($fechaInicio, $fechaFin) {
                            $query->where('starts_at', '<', $fechaFin)
                                  ->where('ends_at', '>', $fechaInicio);
                        })
                        ->exists();

        if ($existeCita) {
            return back()->withErrors(['hora' => 'Este horario ya fue ocupado. Elige otro.']);
        }

        // 5. Creamos la cita
        \App\Models\Appointment::create([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'servicio'       => $request->servicio,
            'starts_at'      => $fechaInicio,
            'ends_at'        => $fechaFin,
            'user_id'        => $request->user_id,
            'status'         => 'pending',
        ]);

        $fechaBonita = $fechaInicio->format('d/m/Y');
        $mensaje = "¡Todo listo, {$request->customer_name}! Tu cita quedó confirmada para el día $fechaBonita a las {$request->hora}.";
        return redirect('/')->with('success', $mensaje);
    }

    public function checkAvailability(Request $request, $user_id, $fecha)
    {
        // Leemos cuánto tiempo necesita el cliente y lo forzamos a entero
        $duracionMinutos = (int) $request->query('duration', 30);

        $workday = \App\Models\Workday::where('user_id', $user_id)->where('day', $fecha)->where('is_open', true)->first();
        if (!$workday) return response()->json([]);

        $slots = [];
        $start = \Carbon\Carbon::parse($workday->start_time);
        $end = \Carbon\Carbon::parse($workday->end_time);

        // Avanzamos de 30 en 30 minutos
        while ($start < $end) {
            $slotStart = $start->copy();
            $slotEnd = $start->copy()->addMinutes($duracionMinutos);

            // Si el servicio dura 1 hora y se sale del horario de salida, no lo mostramos
            if ($slotEnd > $end) {
                $start->addMinutes(30);
                continue;
            }

            // Checamos si choca con alguna cita existente
            $exists = \App\Models\Appointment::where('user_id', $user_id)
                        ->whereDate('starts_at', $fecha)
                        ->where(function ($query) use ($slotStart, $slotEnd) {
                            $query->where('starts_at', '<', $slotEnd)
                                  ->where('ends_at', '>', $slotStart);
                        })
                        ->exists();

            if (!$exists) {
                $slots[] = $slotStart->format('H:i');
            }
            
            $start->addMinutes(30);
        }

        return response()->json($slots);
    }

    // --- FUNCIONES DEL STAFF PANEL ---

    public function staffAvailability(Request $request) {
        $user_id = $request->query('barber_id');
        $fecha = $request->query('date');

        // Validación básica por si falta algún dato
        if (!$user_id || !$fecha) return response()->json(['slots' => []]);

        $workday = \App\Models\Workday::where('user_id', $user_id)->where('day', $fecha)->first();

        if (!$workday || !$workday->is_open) return response()->json(['slots' => []]);

        $slots = [];
        $start = \Carbon\Carbon::parse($workday->start_time);
        $end = \Carbon\Carbon::parse($workday->end_time);

        while ($start < $end) {
            $hora = $start->format('H:i');
            $slotStart = \Carbon\Carbon::parse($fecha . ' ' . $hora);
            $slotEnd = $slotStart->copy()->addMinutes(30);

            // Buscamos si hay cita. Manejamos el caso de citas viejas sin 'ends_at'
            $ocupado = \App\Models\Appointment::where('user_id', $user_id)
                        ->whereDate('starts_at', $fecha)
                        ->where(function ($query) use ($slotStart, $slotEnd) {
                            $query->where(function($q) use ($slotStart, $slotEnd) {
                                $q->where('starts_at', '<', $slotEnd)
                                  ->where('ends_at', '>', $slotStart);
                            })
                            ->orWhere('starts_at', $slotStart); // Respaldo para citas viejas
                        })
                        ->exists();

            $slots[] = [
                'time' => $hora, 
                'available' => !$ocupado,
                'status' => $ocupado ? 'occupied' : 'available'
            ];
            
            $start->addMinutes(30);
        }
        return response()->json(['slots' => $slots]);
    }

    public function getStaffAppointments(Request $request) {
        $date = $request->query('date', today()->toDateString());
        // Traemos todas las citas de ese día
        $appts = \App\Models\Appointment::whereDate('starts_at', $date)->get();
        return response()->json($appts);
    }

    public function cancelAppointment($id) {
        \App\Models\Appointment::destroy($id);
        return response()->json(['success' => true]);
    }

    public function setWorkday(Request $request) {
        $data = $request->validate([
            'barber_id' => 'required',
            'day' => 'required|date',
            'is_open' => 'required|boolean',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Si ya existe el día lo actualiza, si no, lo crea
        \App\Models\Workday::updateOrCreate(
            ['user_id' => $data['barber_id'], 'day' => $data['day']],
            ['is_open' => $data['is_open'], 'start_time' => $data['start_time'], 'end_time' => $data['end_time']]
        );
        return response()->json(['success' => true]);
    }
}