<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Staff · AR Barbería</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root{
      --bg:#0b0f16; --text:#e5e7eb; --muted:#9ca3af;
      --border:rgba(255,255,255,.10); --shadow:0 10px 30px rgba(0,0,0,.35);
      --radius:18px; --brand:#7c3aed;
      --sky: rgba(56,189,248,.14);
      --skybd: rgba(56,189,248,.35);
      --red: rgba(239,68,68,.14);
      --redbd: rgba(239,68,68,.35);
      --cardbg: linear-gradient(180deg, rgba(255,255,255,.04), rgba(255,255,255,.02));
    }
    *{ box-sizing:border-box; }
    body{
      margin:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:
        radial-gradient(1200px 500px at 20% 0%, rgba(212,175,55,.15), transparent 55%),
        radial-gradient(1000px 500px at 80% 0%, rgba(34,197,94,.10), transparent 55%),
        var(--bg);
      color:var(--text);
      overflow-x:hidden;
    }
    .wrap{ max-width:1200px; margin:26px auto; padding:0 18px; }
    header{ display:flex; justify-content:space-between; align-items:end; gap:12px; margin-bottom:14px; }
    h1{ margin:0; font-size:26px; }
    .sub{ color:var(--muted); font-size:13px; margin-top:6px; }
    .topbar{ display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:8px 12px; border:1px solid var(--border);
      border-radius:999px; background:rgba(255,255,255,.04);
      color:var(--muted); font-size:13px;
    }
    .card{
      background: var(--cardbg);
      border:1px solid var(--border);
      border-radius: var(--radius);
      padding:16px;
      box-shadow: var(--shadow);
      margin-bottom:14px;
      overflow:hidden;
    }
    label{ display:block; color:var(--muted); font-size:12px; margin-bottom:6px; }
    input{
      width:100%;
      padding:10px 12px; border-radius:14px; border:1px solid var(--border);
      background:rgba(0,0,0,.20); color:var(--text); outline:none;
    }
    input:focus{ border-color:rgba(212,175,55,.55); box-shadow:0 0 0 4px rgba(212,175,55,.18); }
    .grid3{ display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px; align-items:end; }
    .btn{
      padding:10px 12px; border-radius:14px;
      border:1px solid rgba(212,175,55,.55);
      background: linear-gradient(180deg, rgba(212,175,55,.90), rgba(212,175,55,.70));
      color:black; cursor:pointer; font-weight:700;
    }
    .btn2{
      padding:10px 12px; border-radius:14px;
      border:1px solid var(--border);
      background: rgba(255,255,255,.04);
      color: var(--text); cursor:pointer; font-weight:650;
    }
    .btn2:hover{ background: rgba(255,255,255,.06); }
    .danger{
      border:1px solid rgba(239,68,68,.40); background: rgba(239,68,68,.12);
      color: rgba(255,255,255,.90); border-radius:12px; padding:8px 10px; cursor:pointer; font-weight:800;
    }
    .danger:hover{ background: rgba(239,68,68,.16); }
    .muted{ color:var(--muted); font-size:13px; }
    hr{ border:0; height:1px; background:rgba(255,255,255,.08); margin:14px 0; }
    
    .tabs{ display:flex; gap:10px; flex-wrap:wrap; margin-top:10px; }
    .tab{
      border:1px solid rgba(255,255,255,.10); background: rgba(255,255,255,.03);
      color: rgba(255,255,255,.85); padding:8px 10px; border-radius:999px;
      cursor:pointer; font-weight:700; font-size:13px; user-select:none;
    }
    .tab.active{
      border-color: rgba(212,175,55,.55); box-shadow: 0 0 0 4px rgba(212,175,55,.18);
      background: rgba(212,175,55,.12);
    }
    .barberHead{ display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
    .barberName{ font-size:16px; font-weight:900; }
    .slots {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); 
      gap: 8px;
      margin-top: 10px;
    }
    .slot{ border:1px solid rgba(255,255,255,.10); border-radius:16px; padding:10px; text-align:center; }
    .slot.available{ background: var(--sky); border-color: var(--skybd); }
    .slot.busy{ background: var(--red); border-color: var(--redbd); }
    table{ width:100%; border-collapse:separate; border-spacing:0; margin-top:12px; }
    thead th{ text-align:left; font-size:12px; color:var(--muted); padding:10px; border-bottom:1px solid rgba(255,255,255,.08); }
    tbody td{ padding:10px; border-bottom:1px solid rgba(255,255,255,.06); font-size:14px; }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div>
        <h1>🧑‍🔧 Staff Panel</h1>
        <div class="sub">Hola, {{ Auth::user()->name }}. Gestiona la disponibilidad y citas del día.</div>
      </div>
      <div class="topbar">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="pill" style="cursor:pointer; background:rgba(239,68,68,.12); color:white;">🚪 Cerrar Sesión</button>
        </form>
      </div>
    </header>

    <div class="card">
      <div class="grid3">
        <div><label>Fecha</label><input id="date" type="date"></div>
        <div><label>Hora inicio (Turno)</label><input id="ws_start" value="10:00" type="time"></div>
        <div><label>Hora fin (Turno)</label><input id="ws_end" value="20:00" type="time"></div>
      </div>
      
      <div style="margin-top: 15px; display:flex; gap:10px; flex-wrap:wrap;">
        <button class="btn" type="button" onclick="setWorkday(true)">✅ ABRIR DÍA</button>
        <button class="btn2" style="border-color: #ef4444;" type="button" onclick="setWorkday(false)">⛔ CERRAR DÍA</button>
        <button class="btn2" type="button" onclick="reloadActiveBarber()">🔄 Refrescar</button>
      </div>

      <hr>
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <div style="font-size:14px; font-weight:700; color:var(--brand);">📸 Subir foto al portafolio</div>
        <form action="{{ route('staff.portfolio.store') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:10px; align-items:center;">
            @csrf
            <input type="file" name="image" accept="image/png, image/jpeg" style="padding:6px; border-radius:10px; font-size:12px; max-width:250px;" required>
            <button type="submit" class="btn2" style="font-size:12px; padding:8px 12px; border-color:var(--brand); color:var(--brand);">Subir</button>
        </form>
      </div>
      <div class="tabs" id="tabs" style="margin-top:20px;"></div>
      <hr>
      <div class="muted" id="hint" style="height: 20px;"></div>
    </div>

    <div id="activeArea"></div>
  </div>

<script>
  const BARBERS = [@foreach($barberos as $b){ id: {{ $b->id }}, name: "{{ $b->name }}" },@endforeach];
  const dateEl = document.getElementById("date");
  const tabsEl = document.getElementById("tabs");
  const areaEl = document.getElementById("activeArea");
  const hintEl = document.getElementById("hint");
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

  let ACTIVE_BARBER_ID = (BARBERS[0]?.id || null);
  dateEl.value = new Date().toISOString().slice(0,10);

  function toHHMM(dtStr){
    if(!dtStr) return "";
    const match = dtStr.toString().match(/(\d{2}:\d{2})/);
    return match ? match[1] : dtStr.slice(0,5);
  }

  function buildTabs(){
    tabsEl.innerHTML = "";
    BARBERS.forEach(b => {
      const btn = document.createElement("button");
      btn.className = "tab" + (b.id === ACTIVE_BARBER_ID ? " active" : "");
      btn.textContent = b.name;
      btn.onclick = ()=>{ ACTIVE_BARBER_ID = b.id; reloadActiveBarber(); };
      tabsEl.appendChild(btn);
    });
  }

  function sectionShell(b){
    const div = document.createElement("div");
    div.className = "card";
    div.innerHTML = `
      <div class="barberHead"><div><div class="barberName">✂️ ${b.name}</div><div class="muted">Azul = libre · Rojo = ocupado</div></div></div>
      <div class="slots" id="slots_${b.id}">Cargando horarios...</div>
      <div style="margin-top:14px;">
        <div class="barberName" style="font-size:14px;">📌 Citas del día</div>
        <table>
          <thead><tr><th>Hora</th><th>Servicio</th><th>Cliente</th><th>Tel</th><th>Acción</th></tr></thead>
          <tbody id="appts_${b.id}"><tr><td colspan="5" class="muted">Cargando...</td></tr></tbody>
        </table>
      </div>`;
    return div;
  }

  function renderSlots(barber_id, data, apptsForBarber){
    const slotsEl = document.getElementById(`slots_${barber_id}`);
    if(!slotsEl) return;
    slotsEl.innerHTML = "";
    
    const apptMap = {};
    if(Array.isArray(apptsForBarber)){
        apptsForBarber.forEach(a => { apptMap[toHHMM(a.starts_at)] = a; });
    }

    const slots = data.slots || [];
    if(slots.length === 0){
        slotsEl.innerHTML = '<div class="muted">Sin horarios configurados.</div>';
        return;
    }

    slots.forEach(s => {
      const d = document.createElement("div");
      const citaDirecta = apptMap[s.time];
      
      let esSegundaMitad = false;
      const timeParts = s.time.split(':');
      if(timeParts.length === 2){
          const [h, m] = timeParts.map(Number);
          let totalMin = (h * 60 + m) - 30;
          const horaPrevia = `${Math.floor(totalMin/60).toString().padStart(2,'0')}:${(totalMin%60).toString().padStart(2,'0')}`;
          esSegundaMitad = apptMap[horaPrevia] && apptMap[horaPrevia].servicio === 'ambos';
      }

      const isBusy = citaDirecta || esSegundaMitad;
      d.className = "slot " + (isBusy ? "busy" : "available");
      
      if(!isBusy){
        d.innerHTML = `<div style="font-weight:900;">${s.time}</div><div class="muted" style="font-size:10px;">Libre</div>`;
      } else {
        const a = citaDirecta || (esSegundaMitad ? apptMap[Object.keys(apptMap).find(k => k < s.time)] : null);
        d.innerHTML = `
          <div style="font-weight:900;">${s.time}</div>
          <div style="font-size:11px; margin-top:4px;">
            <div style="font-weight:800; color:${citaDirecta?'#ef4444':'#9ca3af'}; text-overflow:ellipsis; overflow:hidden;">${a?.customer_name || 'Ocupado'}</div>
          </div>`;
      }
      slotsEl.appendChild(d);
    });
  }

  function renderAppointments(barber_id, appts){
    const bodyEl = document.getElementById(`appts_${barber_id}`);
    if(!bodyEl) return;
    bodyEl.innerHTML = "";
    if(!Array.isArray(appts) || !appts.length) { 
        bodyEl.innerHTML = `<tr><td colspan="5" class="muted">Sin citas agendadas</td></tr>`; 
        return; 
    }
    appts.forEach(a => {
      const tr = document.createElement("tr");
      const serv = (a.servicio || 'corte').toUpperCase();
      tr.innerHTML = `
        <td><b>${toHHMM(a.starts_at)}</b></td>
        <td><span style="color:${a.servicio==='ambos'?'#d4af37':'#9ca3af'}; font-size:11px; font-weight:bold;">${serv}</span></td>
        <td>${a.customer_name}</td><td>${a.customer_phone}</td>
        <td><button class="danger" onclick="cancelAppt(${a.id})">Cancelar</button></td>`;
      bodyEl.appendChild(tr);
    });
  }

  async function reloadActiveBarber(){
    buildTabs(); 
    areaEl.innerHTML = "";
    const b = BARBERS.find(x=>x.id === ACTIVE_BARBER_ID);
    if(!b) return;
    
    areaEl.appendChild(sectionShell(b));
    
    try {
        const [resAppts, resAv] = await Promise.all([
            fetch("/staff/appointments?date=" + dateEl.value),
            fetch("/staff/availability?barber_id=" + b.id + "&date=" + dateEl.value)
        ]);

        const appts = await resAppts.json();
        const av = await resAv.json();

        const bAppts = Array.isArray(appts) ? appts.filter(a => a.user_id === b.id).sort((x,y) => x.starts_at > y.starts_at ? 1 : -1) : [];
        
        renderSlots(b.id, av, bAppts);
        renderAppointments(b.id, bAppts);
    } catch(e) { 
        console.error("Error en Staff Panel:", e);
        const errSlots = document.getElementById(`slots_${b.id}`);
        if(errSlots) errSlots.innerHTML = '<div class="text-danger">Error de conexión.</div>';
    }
  }

  async function cancelAppt(id){
    if(!confirm("¿Cancelar cita?")) return;
    await fetch(`/staff/appointments/${id}`, { method: "DELETE", headers: { "X-CSRF-TOKEN": CSRF_TOKEN } });
    reloadActiveBarber();
  }

  async function setWorkday(is_open){
    await fetch("/staff/workdays/set", {
      method: "POST",
      headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": CSRF_TOKEN },
      body: JSON.stringify({ 
        barber_id: ACTIVE_BARBER_ID, 
        day: dateEl.value, 
        is_open, 
        start_time: document.getElementById("ws_start").value, 
        end_time: document.getElementById("ws_end").value 
      })
    });
    reloadActiveBarber();
  }

  dateEl.onchange = reloadActiveBarber;
  buildTabs();
  reloadActiveBarber();
</script>
</body>
</html>