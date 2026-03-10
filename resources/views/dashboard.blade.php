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
    .slots{ display:grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap:10px; margin-top:10px; }
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

      <div class="tabs" id="tabs"></div>
      <hr>
      <div class="muted" id="hint" style="height: 20px;"></div>
    </div>

    <div id="activeArea"></div>
  </div>

<script>
  // Barberos inyectados desde Laravel Blade
  const BARBERS = [
    @foreach($barberos as $b)
      { id: {{ $b->id }}, name: "{{ $b->name }}" },
    @endforeach
  ];

  const dateEl = document.getElementById("date");
  const tabsEl = document.getElementById("tabs");
  const areaEl = document.getElementById("activeArea");
  const hintEl = document.getElementById("hint");
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

  let ACTIVE_BARBER_ID = (BARBERS[0]?.id || null);
  dateEl.value = new Date().toISOString().slice(0,10);

  function qs(p){ return new URLSearchParams(p).toString(); }

  function toHHMM(dtStr){
    if(!dtStr) return "";
    const s = dtStr.toString();
    if(s.includes("T")) return s.split("T")[1].slice(0,5);
    if(s.includes(" ")) return s.split(" ")[1].slice(0,5);
    return s.slice(0,5);
  }

  function buildTabs(){
    tabsEl.innerHTML = "";
    for(const b of BARBERS){
      const btn = document.createElement("button");
      btn.className = "tab" + (b.id === ACTIVE_BARBER_ID ? " active" : "");
      btn.textContent = b.name;
      btn.onclick = ()=>{ ACTIVE_BARBER_ID = b.id; reloadActiveBarber(); };
      tabsEl.appendChild(btn);
    }
  }

  function sectionShell(b){
    const div = document.createElement("div");
    div.className = "card";
    div.innerHTML = `
      <div class="barberHead">
        <div>
          <div class="barberName">✂️ ${b.name}</div>
          <div class="muted">Azul = libre · Rojo = reservado</div>
        </div>
      </div>
      <div class="slots" id="slots_${b.id}">Cargando horarios...</div>
      <div style="margin-top:14px;">
        <div class="barberName" style="font-size:14px;">📌 Citas del día</div>
        <table>
          <thead><tr><th>Hora</th><th>Cliente</th><th>Tel</th><th>Acción</th></tr></thead>
          <tbody id="appts_${b.id}"><tr><td colspan="4" class="muted">Cargando...</td></tr></tbody>
        </table>
      </div>
    `;
    return div;
  }

  async function fetchAvailability(barber_id, date){
    const res = await fetch("/staff/availability?" + qs({ barber_id, date }));
    return await res.json();
  }

  async function fetchAppointmentsAll(){
    const res = await fetch("/staff/appointments?" + qs({ date: dateEl.value }));
    return await res.json(); 
  }

  function buildApptMap(appts){
    const m = {};
    for(const a of appts){
      m[toHHMM(a.starts_at)] = { id: a.id, name: a.customer_name, phone: a.customer_phone };
    }
    return m;
  }

  function renderSlots(barber_id, data, apptsForBarber){
    const slotsEl = document.getElementById(`slots_${barber_id}`);
    slotsEl.innerHTML = "";
    const apptMap = buildApptMap(apptsForBarber || []);

    (data.slots || []).forEach(s=>{
      const d = document.createElement("div");
      const isFree = s.available;
      d.className = "slot " + (isFree ? "available" : "busy");

      if(isFree){
        d.innerHTML = `<div style="font-weight:900;">${s.time}</div><div class="muted" style="margin-top:4px;">Disponible</div>`;
      } else {
        const a = apptMap[s.time];
        d.innerHTML = `
          <div style="font-weight:900;">${s.time}</div>
          <div style="margin-top:6px; font-size:12px; line-height:1.15; opacity:.92;">
            <div style="font-weight:800;">${a?.name || 'Ocupado'}</div>
            <div style="opacity:.85;">${a?.phone || ''}</div>
          </div>`;
      }
      slotsEl.appendChild(d);
    });

    if(!(data.slots || []).length){
      slotsEl.innerHTML = `<div class="muted">Sin horarios para esta fecha (día cerrado o no configurado).</div>`;
    }
  }

  function renderAppointments(barber_id, appts){
    const bodyEl = document.getElementById(`appts_${barber_id}`);
    bodyEl.innerHTML = "";
    if(!appts.length){
      bodyEl.innerHTML = `<tr><td colspan="4" class="muted">Sin citas</td></tr>`;
      return;
    }
    for(const a of appts){
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><b>${toHHMM(a.starts_at)}</b></td>
        <td>${a.customer_name}</td>
        <td>${a.customer_phone}</td>
        <td><button class="danger" onclick="cancelAppt(${a.id})">Cancelar</button></td>
      `;
      bodyEl.appendChild(tr);
    }
  }

  async function cancelAppt(id){
    if(!confirm("¿Cancelar esta cita de forma permanente?")) return;
    const res = await fetch(`/staff/appointments/${id}`, { 
      method: "DELETE", 
      headers: { "X-CSRF-TOKEN": CSRF_TOKEN } 
    });
    if(!res.ok) { alert("Error al cancelar."); return; }
    await reloadActiveBarber();
  }

  async function setWorkday(is_open){
    const day = dateEl.value;
    const start_time = document.getElementById("ws_start").value;
    const end_time = document.getElementById("ws_end").value;

    const res = await fetch("/staff/workdays/set", {
      method: "POST",
      headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": CSRF_TOKEN },
      body: JSON.stringify({ barber_id: ACTIVE_BARBER_ID, day, is_open, start_time, end_time })
    });

    if(!res.ok){ alert("Error al guardar el día."); return; }
    hintEl.textContent = is_open ? "✅ Día abierto correctamente." : "⛔ Día cerrado. No se recibirán citas.";
    setTimeout(()=>hintEl.textContent="", 2500);
    await reloadActiveBarber();
  }

  async function reloadActiveBarber(){
    buildTabs();
    areaEl.innerHTML = "";
    const b = BARBERS.find(x=>x.id === ACTIVE_BARBER_ID);
    if(!b) return;

    areaEl.appendChild(sectionShell(b));

    const appts = await fetchAppointmentsAll();
    const apptsForBarber = appts.filter(a => a.barber_id === b.id).sort((x,y) => x.starts_at > y.starts_at ? 1 : -1);

    const av = await fetchAvailability(b.id, dateEl.value);
    renderSlots(b.id, av, apptsForBarber);
    renderAppointments(b.id, apptsForBarber);
  }

  dateEl.onchange = reloadActiveBarber;
  buildTabs();
  reloadActiveBarber();
</script>
</body>
</html>