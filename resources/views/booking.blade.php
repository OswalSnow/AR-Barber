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
                
                <form action="/confirmar-cita" method="POST">
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
    // Inicializar Flatpickr
    flatpickr("#fecha_cita", {
        locale: "es",           // Idioma español
        dateFormat: "Y-m-d",    // El formato oculto que se envía a Laravel (Ej. 2026-04-15)
        altInput: true,         // Crea un input falso visualmente más bonito
        altFormat: "d/m/Y",     // El formato que ve el cliente (Ej. 15/04/2026)
        minDate: "today",       // No deja agendar en el pasado
        disableMobile: "true",  // Fuerza nuestro calendario premium en celulares en lugar del nativo
        
        // Cuando el cliente elige un día, ejecutamos la búsqueda de horas
        onChange: function(selectedDates, dateStr, instance) {
            const userId = "{{ $barbero->id }}";
            const slotsContainer = document.getElementById('slots-container');
            const horaInput = document.getElementById('hora_seleccionada');
            const btnSubmit = document.getElementById('btn-submit');

            if(!dateStr) return;

            slotsContainer.innerHTML = '<div class="text-muted small w-100" style="grid-column: 1 / -1;">Consultando agenda...</div>';
            btnSubmit.disabled = true;
            horaInput.value = '';

            fetch(`/api/disponibilidad/${userId}/${dateStr}`)
                .then(response => response.json())
                .then(data => {
                    slotsContainer.innerHTML = '';
                    
                    // NUEVA VALIDACIÓN: Si el día está cerrado o no existe en la DB
                    if (!data || data.length === 0) {
                            slotsContainer.innerHTML = `
                                <div class="w-100 text-center" style="grid-column: 1 / -1; padding: 20px; border: 1px dashed rgba(212, 175, 55, 0.4); border-radius: 12px; background: rgba(212, 175, 55, 0.05);">
                                    <span class="gold-text" style="font-weight: 800; font-size: 1.1rem;">Día no habilitado</span><br>
                                <span style="color: #d1d5db; font-size: 0.85rem; margin-top: 8px; display: inline-block;">No hay citas disponibles hasta que el barbero active su agenda para esta fecha.</span>
                            </div>`;
                        return;
                    }

                    const horasLibres = data.map(h => typeof h === 'object' ? h.time || h.hora : h);
                    const jornadaLaboral = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];
                    
                    jornadaLaboral.forEach(hora => {
                        const div = document.createElement('div');
                        const estaDisponible = horasLibres.includes(hora);

                        if (estaDisponible) {
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
                        } else {
                            div.className = 'slot busy';
                            div.innerHTML = `
                                <div style="font-weight:900; font-size: 1.05rem;">${hora}</div>
                                <div style="font-size: 0.75rem; margin-top:2px; opacity:0.8;">Ocupado</div>
                            `;
                        }

                        slotsContainer.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    slotsContainer.innerHTML = '<div class="text-danger small w-100" style="grid-column: 1 / -1;">Error al cargar horarios</div>';
                });
        }
    });
</script>
</body>
</html>