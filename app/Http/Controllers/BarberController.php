<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    public function index()
    {
        // Traemos solo a los que son barberos y están activos
        $barberos = User::where('role', 'barber')
                        ->where('is_active', true)
                        ->get();

        return view('welcome', compact('barberos'));
    }

    public function showBookingForm($id)
    {
        $barbero = User::findOrFail($id);
        return view('booking', compact('barbero'));
    }

    public function store(Request $request)
    {
        // 1. Validamos los campos que vienen del nuevo formulario
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|regex:/^[0-9]{10}$/',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora'           => 'required',
            'user_id'        => 'required|exists:users,id',
        ]);

        // 2. Juntamos la fecha y la hora para que MySQL las entienda
        // Esto convierte "2026-03-10" y "14:00" en "2026-03-10 14:00:00"
        $fechaCompleta = $request->fecha . ' ' . $request->hora . ':00';

        // 3. Verificación de seguridad: ¿Alguien más ganó el lugar mientras llenabas el formulario?
        $existeCita = \App\Models\Appointment::where('user_id', $request->user_id)
                        ->where('starts_at', $fechaCompleta)
                        ->exists();

        if ($existeCita) {
            return back()->withErrors(['hora' => 'Este horario ya fue ocupado. Elige otro.']);
        }

        // 4. Creamos la cita con el campo starts_at ya armado
        \App\Models\Appointment::create([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'starts_at'      => $fechaCompleta,
            'user_id'        => $request->user_id,
            'status'         => 'pending',
        ]);

        // 5. Redirigimos al inicio con el mensaje de éxito
        return redirect('/')->with('success', '¡Cita agendada con éxito! Te contactaremos por WhatsApp.');
    }

    public function checkAvailability($user_id, $fecha)
    {
        // 1. checar disponibilidad de barbero en el dia
        $workday = \App\Models\Workday::where('user_id', $user_id)
                    ->where('day', $fecha)
                    ->where('is_open', true)
                    ->first();

        if (!$workday) return response()->json([]); // No trabaja

        // 2. Generar rangos de 1 hora
        $slots = [];
        $start = \Carbon\Carbon::parse($workday->start_time);
        $end = \Carbon\Carbon::parse($workday->end_time);

        while ($start < $end) {
            $slotTime = $start->format('H:i');
            
            // 3. Verificar si ya hay una cita a esa hora
            $exists = \App\Models\Appointment::where('user_id', $user_id)
                        ->whereDate('starts_at', $fecha)
                        ->whereTime('starts_at', $slotTime)
                        ->exists();

            if (!$exists) {
                $slots[] = $slotTime;
            }
            $start->addHour(); // Citas de 1 hora
        }

        return response()->json($slots);
    }

    // --- FUNCIONES DEL STAFF PANEL ---

    public function staffAvailability(Request $request) {
        $user_id = $request->query('barber_id');
        $fecha = $request->query('date');
        $workday = \App\Models\Workday::where('user_id', $user_id)->where('day', $fecha)->first();

        if (!$workday || !$workday->is_open) return response()->json(['slots' => []]);

        $slots = [];
        $start = \Carbon\Carbon::parse($workday->start_time);
        $end = \Carbon\Carbon::parse($workday->end_time);

        while ($start < $end) {
            $hora = $start->format('H:i');
            $fechaCompleta = $fecha . ' ' . $hora . ':00';
            $ocupado = \App\Models\Appointment::where('user_id', $user_id)->where('starts_at', $fechaCompleta)->exists();

            $slots[] = ['time' => $hora, 'available' => !$ocupado];
            $start->addHour();
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