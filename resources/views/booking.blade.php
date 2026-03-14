<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar con {{ $barbero->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0b0b; color: #fff; }
        .gold-text { color: #d4af37; }
        .card-booking { background-color: #1a1a1a; border: 1px solid #d4af37; }
        .btn-gold { background-color: #d4af37; color: #000; font-weight: bold; }
        .form-control { background-color: #333; color: #fff; border-color: #d4af37; }
        .form-control:focus { background-color: #333; color: #fff; border-color: #d4af37; box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25); }
        .form-control::placeholder { color: #ffffff !important; opacity: 1 !important; }
        input::placeholder { color: #ffffff !important; opacity: 1 !important; }
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
                    <div class="mb-3">
                        <label class="form-label gold-text">Tu Nombre</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label gold-text">Celular</label>
                        <input type="tel" name="customer_phone" class="form-control" 
                            pattern="[0-9]{10}" maxlength="10" placeholder="Ej: 3312345678" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label gold-text">Selecciona el Día</label>
                        <input type="date" id="fecha_cita" name="fecha" class="form-control" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label gold-text">Horas Disponibles</label>
                        <select id="hora_cita" name="hora" class="form-select" required disabled style="background-color: #333; color: white; border-color: #d4af37;">
                            <option value="">Primero elige un día...</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">CONFIRMAR CITA</button>
                    <a href="/" class="btn btn-link text-secondary w-100 mt-2">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('fecha_cita').addEventListener('change', function() {
    const fecha = this.value;
    const userId = "{{ $barbero->id }}";
    const selectHora = document.getElementById('hora_cita');

    // Limpiamos y mostramos que estamos cargando
    selectHora.innerHTML = '<option>Cargando disponibilidad...</option>';
    selectHora.disabled = true;

    // Pedimos las horas libres al servidor
    fetch(`/api/disponibilidad/${userId}/${fecha}`)
        .then(response => response.json())
        .then(data => {
            selectHora.innerHTML = '';
            if (data.length > 0) {
                // Si hay horas, las ponemos en el select
                data.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora + ' hrs';
                    selectHora.appendChild(option);
                });
                selectHora.disabled = false;
            } else {
                // Si no hay nada (barbero no trabaja o lleno)
                selectHora.innerHTML = '<option value="">No hay citas disponibles para este día</option>';
                selectHora.disabled = true;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectHora.innerHTML = '<option value="">Error al cargar horarios</option>';
        });
});
</script>
</body>
</html>