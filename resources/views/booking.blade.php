<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar con {{ $barbero->name }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <style>
        :root {
            --bg: #0b0f16; 
            --text: #e5e7eb; 
            --muted: #9ca3af;
            --brand: #7c3aed; 
            --brand-hover: #6d28d9;
            
            /* Colores de disponibilidad */
            --sky: rgba(56,189,248,.14);   
            --skybd: rgba(56,189,248,.35); 
            --red: rgba(239,68,68,.14);
            --redbd: rgba(239,68,68,.35);

            --cardbg: linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.02));
        }
        
        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }

        .gold-text { color: #d4af37; font-weight: 600; }
        
        .card-booking { 
            background: var(--cardbg);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,.35);
        }

        .form-control {
            background: rgba(0,0,0,.20) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: var(--text) !important;
            border-radius: 14px;
            padding: 10px 12px;
        }
        
        .form-control:focus {
            background: rgba(0,0,0,.40) !important;
            border-color: rgba(124,58,237,.55) !important;
            box-shadow: 0 0 0 4px rgba(124,58,237,.18) !important;
        }
http://127.0.0.1:8000
        .form-control::placeholder { color: var(--muted) !important; opacity: 1 !important; }

        /* Grid de Horarios */
        .slots {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .slot {
            border-radius: 16px;
            padding: 12px 6px;
            text-align: center;
            user-select: none;
            transition: all 0.2s ease;
        }

        .slot.available {
            background: var(--sky);
            border: 1px solid var(--skybd);
            color: #e5e7eb; 
            cursor: pointer;
        }

        .slot.available:hover {
            background: rgba(56,189,248,.25);
            border-color: rgba(56,189,248,.60);
        }

        .slot.busy {
            background: var(--red);
            border: 1px solid var(--redbd);
            color: rgba(255,255,255,.5);
            cursor: not-allowed;
        }

        .slot.selected {
            border-color: rgba(124,58,237,.55) !important;
            box-shadow: 0 0 0 4px rgba(124,58,237,.18);
            background: rgba(124,58,237,.12) !important;
            color: white;
            font-weight: 900;
            transform: scale(1.05);
        }

        .btn-brand {
            background: linear-gradient(180deg, rgba(124,58,237,.90), rgba(124,58,237,.70));
            border: 1px solid rgba(124,58,237,.55);
            color: white;
            font-weight: 700;
            border-radius: 14px;
            padding: 12px;
            transition: background 0.2s;
        }

        .btn-brand:hover:not(:disabled) {
            background: linear-gradient(180deg, rgba(124,58,237,1), rgba(124,58,237,.80));
            color: white;
        }

        .btn-brand:disabled {
            background: rgba(255,255,255,.04);
            border-color: rgba(255,255,255,.10);
            color: var(--muted);
            cursor: not-allowed;
        }

        h2 { color: #ffffff !important; font-weight: bold; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-booking p-4">
                <h2 class="text-center mb-4">Agendar con <span class="gold-text">{{ $barbero->name }}</span></h2>
                                            
                                            @if($errors->has('customer_phone'))
                                <div class="alert text-center mb-4" style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.5); border-radius: 14px; color: var(--text);">
                                    <h5 class="gold-text" style="font-weight: 800;">Límite de citas alcanzado</h5>
                                    <p class="small mb-3" style="color: #d1d5db;">Has alcanzado el límite de 2 citas pendientes. Si necesitas agendar para más personas, mándame un mensaje y te hago el espacio manualmente.</p>
                                    
                                    @php
                                        $mensajeWa = "Hola " . $barbero->name . ", quiero agendar más de 2 citas por favor.";
                                        
                                        // 2. Diccionario manual de teléfonos (Reemplaza con los números reales de cada uno)
                                        // Asegúrate de poner el nombre del barbero EXACTAMENTE como lo registraste en tu sistema
                                        $numerosBarberos = [
                                            'Alberto'       => '5213327974634', 
                                            'Angel' => '5213316070255',
                                            'Anibal'        => '5213320417603',
                                            'Kinich'        => '5213326025007'
                                        ];
                                        
                                        // 3. Busca el teléfono. Si por algo no lo encuentra, usa un número por defecto (ej. el del local)
                                        $telefonoWa = $numerosBarberos[$barbero->name] ?? '5213327974634'; 
                                        
                                        // 4. Armamos el link final
                                        $urlWa = "https://wa.me/" . $telefonoWa . "?text=" . urlencode($mensajeWa);
                                    @endphp
                                    
                                    <a href="{{ $urlWa }}" target="_blank" class="btn w-100" style="background-color: #25D366; color: white; font-weight: bold; border-radius: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp me-2" viewBox="0 0 16 16" style="vertical-align: text-top;">
                                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                        </svg>
                                        Escribir por WhatsApp
                                    </a>
                                </div>
                            @elseif($errors->any())
                                <div class="alert text-center mb-4" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 14px; color: #fca5a5;">
                                    @foreach($errors->all() as $error)
                                        <p class="mb-0 small">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                                            
                <form action="/confirmar-cita" method="POST" id="form-cita">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $barbero->id }}">
                    <input type="hidden" name="hora" id="hora_seleccionada" required>

                    <div class="mb-3">
                        <label class="form-label gold-text small">Tu Nombre</label>
                        <input type="text" name="customer_name" class="form-control" required placeholder="Ej. Juan Pérez">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label gold-text small">Celular</label>
                        <input type="tel" name="customer_phone" class="form-control" 
                            pattern="[0-9]{10}" maxlength="10" placeholder="Ej: 3312345678" required>
                    </div>
                    
                    <div class="mb-3">
                            <label class="form-label gold-text small">¿Qué servicio buscas?</label>
                            <select name="servicio" id="tipo_servicio" class="form-control" required>
                                <option value="corte">Solo Corte (30 min)</option>
                                <option value="barba">Solo Barba (30 min)</option>
                                <option value="ambos">Corte y Barba (1 Hora)</option>
                            </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label gold-text small">Selecciona el Día</label>
                        <input type="text" id="fecha_cita" name="fecha" class="form-control" placeholder="Selecciona una fecha..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label gold-text small">Horas Disponibles</label>
                        <div id="slots-container" class="slots">
                            <div class="text-muted small w-100" style="grid-column: 1 / -1;">
                                Primero elige un día...
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-brand w-100" id="btn-submit" disabled>CONFIRMAR CITA</button>
                    <a href="/" class="btn btn-link text-secondary w-100 mt-2 text-decoration-none text-center">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    const userId = "{{ $barbero->id }}";
    const selectServicio = document.getElementById('tipo_servicio');
    const slotsContainer = document.getElementById('slots-container');
    const horaInput = document.getElementById('hora_seleccionada');
    const btnSubmit = document.getElementById('btn-submit');
    let fechaSeleccionada = null; // Guardamos la fecha globalmente

    // Función que va a buscar al servidor los horarios
    function cargarHorarios() {
        if(!fechaSeleccionada) return;

        // Si es "ambos" pide bloques de 60 mins, si no, de 30 mins
        const duracion = selectServicio.value === 'ambos' ? 60 : 30;
        
        slotsContainer.innerHTML = '<div class="text-muted small w-100" style="grid-column: 1 / -1;">Consultando agenda...</div>';
        btnSubmit.disabled = true;
        horaInput.value = '';

        fetch(`/api/disponibilidad/${userId}/${fechaSeleccionada}?duration=${duracion}`)
            .then(response => response.json())
            .then(data => {
                slotsContainer.innerHTML = '';
                
                if (!data || data.length === 0) {
                        slotsContainer.innerHTML = `
                            <div class="w-100 text-center" style="grid-column: 1 / -1; padding: 20px; border: 1px dashed rgba(212, 175, 55, 0.4); border-radius: 12px; background: rgba(212, 175, 55, 0.05);">
                                <span class="gold-text" style="font-weight: 800; font-size: 1.1rem;">Sin horarios</span><br>
                            <span style="color: #d1d5db; font-size: 0.85rem; margin-top: 8px; display: inline-block;">No hay espacio suficiente para este servicio en este día.</span>
                        </div>`;
                    return;
                }

                data.forEach(hora => {
                    const div = document.createElement('div');
                    div.className = 'slot available';
                    div.innerHTML = `
                        <div style="font-weight:900; font-size: 1.05rem;">${hora}</div>
                        <div style="font-size: 0.75rem; margin-top:2px; opacity:0.8;">Disponible</div>
                    `;

                    div.addEventListener('click', () => {
                        document.querySelectorAll('.slot.available').forEach(el => el.classList.remove('selected'));
                        div.classList.add('selected');
                        horaInput.value = hora;
                        btnSubmit.disabled = false;
                    });
                    slotsContainer.appendChild(div);
                });
            })
            .catch(error => {
                slotsContainer.innerHTML = '<div class="text-danger small w-100" style="grid-column: 1 / -1;">Error al cargar horarios</div>';
            });
    }

    // Inicializar Flatpickr
    flatpickr("#fecha_cita", {
        locale: "es",
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        minDate: "today",
        disableMobile: "true",
        onChange: function(selectedDates, dateStr) {
            fechaSeleccionada = dateStr;
            cargarHorarios(); // Llama a la función cuando eligen fecha
        }
    });

    // Si el usuario cambia de "Solo Corte" a "Corte y Barba", recargamos los horarios
    selectServicio.addEventListener('change', cargarHorarios);

    // Prevenir múltiples clics
    document.getElementById('form-cita').addEventListener('submit', function() {
        btnSubmit.innerHTML = 'AGENDANDO... Espere por favor';
        btnSubmit.disabled = true;
    });
</script>
        <script>
    // Prevenir múltiples clics al enviar el formulario
    document.getElementById('form-cita').addEventListener('submit', function() {
        const btnSubmit = document.getElementById('btn-submit');
        // Cambiamos el texto para que sepan que está cargando
        btnSubmit.innerHTML = 'AGENDANDO... Espere por favor';
        // Bloqueamos el botón para que no le puedan dar doble clic
        btnSubmit.disabled = true;
    });
    </script>
</body>
</html>