<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    /** @test */
    public function la_pagina_principal_carga_correctamente()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function la_pagina_de_agendar_carga_con_un_barbero_valido()
    {
        // Jalamos el primer barbero real que tengas en tu BD para no crear basura
        $barbero = User::where('role', 'barber')->first();

        $response = $this->get('/agendar/' . $barbero->id);

        $response->assertStatus(200);
        $response->assertSee($barbero->name);
    }

    /** @test */
    public function el_formulario_de_cita_falla_si_faltan_datos_obligatorios()
    {
        // Intentamos agendar enviando vacío
        $response = $this->post('/confirmar-cita', []);

        // Verificamos que el sistema rebote la solicitud pidiendo los datos
        $response->assertSessionHasErrors(['customer_name', 'customer_phone', 'servicio', 'fecha', 'hora', 'user_id']);
    }
}