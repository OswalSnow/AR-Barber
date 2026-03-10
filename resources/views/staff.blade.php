
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Staff · Barbería</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

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
        radial-gradient(1200px 500px at 20% 0%, rgba(124,58,237,.25), transparent 55%),
        radial-gradient(1000px 500px at 80% 0%, rgba(34,197,94,.15), transparent 55%),
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
    input:focus{ border-color:rgba(124,58,237,.55); box-shadow:0 0 0 4px rgba(124,58,237,.18); }
    .grid3{ display:grid; grid-template-columns: 1fr 1fr 1fr; gap:12px; align-items:end; }
    .grid2{ display:grid; grid-template-columns: 1fr 1fr; gap:12px; align-items:end; }

    .btn{
      padding:10px 12px; border-radius:14px;
      border:1px solid rgba(124,58,237,.55);
      background: linear-gradient(180deg, rgba(124,58,237,.90), rgba(124,58,237,.70));
      color:white; cursor:pointer; font-weight:700;
    }
    .btn2{
      padding:10px 12px; border-radius:14px;
      border:1px solid var(--border);
      background: rgba(255,255,255,.04);
      color: var(--text);
      cursor:pointer;
      font-weight:650;
    }
    .btn2:hover{ background: rgba(255,255,255,.06); }
    .muted{ color:var(--muted); font-size:13px; }
    .hint{ margin-left:6px; }

    hr{ border:0; height:1px; background:rgba(255,255,255,.08); margin:14px 0; }

    /* Tabs */
    .tabs{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top:10px;
    }
    .tab{
      border:1px solid rgba(255,255,255,.10);
      background: rgba(255,255,255,.03);
      color: rgba(255,255,255,.85);
      padding:8px 10px;
      border-radius:999px;
      cursor:pointer;
      font-weight:700;
      font-size:13px;
      user-select:none;
    }
    .tab.active{
      border-color: rgba(124,58,237,.55);
      box-shadow: 0 0 0 4px rgba(124,58,237,.18);
      background: rgba(124,58,237,.12);
    }

    /* Sección barbero */
    .barberHead{
      display:flex; justify-content:space-between; align-items:center; gap:12px;
      margin-bottom:10px;
    }
    .barberName{ font-size:16px; font-weight:900; letter-spacing:.2px; }
    .tag{
      display:inline-block; padding:4px 8px; border-radius:999px;
      border:1px solid rgba(255,255,255,.10);
      background: rgba(255,255,255,.03);
      color: rgba(255,255,255,.80);
      font-size:12px;
      margin-left:8px;
    }

    /* Slots */
    .slots{
      display:grid;
      grid-template-columns: repeat(6, minmax(120px, 1fr));
      gap:10px;
      margin-top:10px;
    }
    .slot{
      border:1px solid rgba(255,255,255,.10);
      border-radius:16px;
      padding:10px;
      text-align:center;
      user-select:none;
      min-width:0;
    }
    .slot.available{ background: var(--sky); border-color: var(--skybd); }
    .slot.busy{ background: var(--red); border-color: var(--redbd); color: rgba(255,255,255,.85); }

    /* Tabla */
    table{ width:100%; border-collapse:separate; border-spacing:0; margin-top:12px; overflow:hidden; }
    thead th{
      text-align:left; font-size:12px; color:var(--muted);
      padding:10px 10px;
      border-bottom:1px solid rgba(255,255,255,.08);
    }
    tbody td{
      padding:10px 10px;
      border-bottom:1px solid rgba(255,255,255,.06);
      font-size:14px;
      vertical-align:top;
    }

    .danger{
      border:1px solid rgba(239,68,68,.40);
      background: rgba(239,68,68,.12);
      color: rgba(255,255,255,.90);
      border-radius:12px;
      padding:8px 10px;
      cursor:pointer;
      font-weight:800;
    }
    .danger:hover{ background: rgba(239,68,68,.16); }

    @media (max-width: 980px){
      .slots{ grid-template-columns: repeat(4, 1fr); }
      .grid3{ grid-template-columns: 1fr; }
    }
    @media (max-width: 620px){
      .grid2{ grid-template-columns: 1fr; }
      .slots{ grid-template-columns: repeat(2, 1fr); }
    }
  </style>
</head>

<body>
  <div class="wrap">
    <header>
      <div>
        <h1>🧑‍🔧 Staff Panel</h1>
        <div class="sub">Disponibilidad + citas + cancelar + calendario del día.</div>
      </div>

      <div class="topbar">
        <div class="pill">📅 Slots de 20 min</div>
        <div class="pill">🔒 Acciones requieren X-Staff-Token</div>
      </div>
    </header>

    <!-- Controles globales -->
    <div class="card">
      <div class="grid3">
        <div>
          <label>Fecha</label>
          <input id="date" type="date">
        </div>
        <div>
          <label>Staff Token</label>
          <input id="staff_token" placeholder="X-Staff-Token (acciones y ver citas)">
        </div>
        <div>
          <label>Acciones</label>
          <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button class="btn" type="button" onclick="reloadActiveBarber()">Actualizar</button>
            <button class="btn2" type="button" onclick="saveToken()">Guardar token</button>
          </div>
        </div>
      </div>

      <div class="tabs" id="tabs"></div>

      <hr>

      <!-- Calendario del día (para el barbero activo) -->
      <div class="grid3">
        <div>
          <label>Hora inicio (día)</label>
          <input id="ws_start" value="10:00" placeholder="10:00">
        </div>
        <div>
          <label>Hora fin (día)</label>
          <input id="ws_end" value="20:00" placeholder="20:00">
        </div>
        <div>
          <label>Calendario</label>
          <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button class="btn2" type="button" onclick="setWorkday(true)">✅ Abrir día</button>
            <button class="btn2" type="button" onclick="setWorkday(false)">⛔ Cerrar día</button>
          </div>
        </div>
      </div>

      <div class="muted" style="margin-top:10px;">
        <span id="hint" class="hint"></span>
      </div>
    </div>

    <!-- Sección del barbero activo -->
    <div id="activeArea"></div>
  </div>

<script>
  // Barberos desde Jinja (server)
    const BARBERS = [
        @foreach($barberos as $b)
        { id: {{ $b->id }}, name: "{{ $b->name }}" },
        @endforeach
    ];
    
  const dateEl  = document.getElementById("date");
  const tokenEl = document.getElementById("staff_token");
  const tabsEl  = document.getElementById("tabs");
  const areaEl  = document.getElementById("activeArea");
  const hintEl  = document.getElementById("hint");

  let ACTIVE_BARBER_ID = (BARBERS[0]?.id || null);

  // Defaults
  dateEl.value = new Date().toISOString().slice(0,10);
  tokenEl.value = localStorage.getItem("STAFF_TOKEN") || "";

  function saveToken(){
    localStorage.setItem("STAFF_TOKEN", (tokenEl.value || "").trim());
    hintEl.textContent = "Token guardado.";
    setTimeout(()=>hintEl.textContent="", 1200);
  }

  function qs(p){ return new URLSearchParams(p).toString(); }

  function toHHMM(dtStr){
    // "2026-01-08T10:20:00" -> "10:20"
    if(!dtStr) return "";
    const s = dtStr.toString();
    if(s.includes("T")) return s.split("T")[1].slice(0,5);
    // si viene "2026-01-08 10:20"
    if(s.includes(" ")) return s.split(" ")[1].slice(0,5);
    return s.slice(0,5);
  }

  function buildTabs(){
    tabsEl.innerHTML = "";
    for(const b of BARBERS){
      const btn = document.createElement("button");
      btn.className = "tab" + (b.id === ACTIVE_BARBER_ID ? " active" : "");
      btn.type = "button";
      btn.textContent = b.name;
      btn.onclick = ()=>{
        ACTIVE_BARBER_ID = b.id;
        buildTabs();
        reloadActiveBarber();
      };
      tabsEl.appendChild(btn);
    }
  }

  function sectionShell(b){
    const div = document.createElement("div");
    div.className = "card";
    div.innerHTML = `
      <div class="barberHead">
        <div>
          <div class="barberName">✂️ ${b.name} <span class="tag">id ${b.id}</span></div>
          <div class="muted">Azul = disponible · Rojo = ocupado (con datos)</div>
        </div>
        <button class="btn2" type="button" onclick="reloadActiveBarber()">Actualizar</button>
      </div>

      <div class="slots" id="slots_${b.id}">Cargando horarios...</div>

      <div style="margin-top:14px;">
        <div class="barberName" style="font-size:14px;">📌 Citas del día</div>
        <table>
          <thead>
            <tr>
              <th style="width:110px;">Hora</th>
              <th>Cliente</th>
              <th>Tel</th>
              <th style="width:140px;">Acción</th>
            </tr>
          </thead>
          <tbody id="appts_${b.id}">
            <tr><td colspan="4" class="muted">Cargando...</td></tr>
          </tbody>
        </table>
      </div>
    `;
    return div;
  }

  async function fetchAvailability(barber_id, date){
    const res = await fetch("/availability?" + qs({ barber_id, date }));
    if(!res.ok) throw new Error(await res.text());
    return await res.json(); // { slots:[{time,available,status?}] }
  }

  async function fetchAppointmentsAll(){
    const token = (tokenEl.value || "").trim();
    if(!token) throw new Error("Falta token para ver citas (endpoint staff requiere token).");

    const res = await fetch("/staff/appointments?" + qs({ date: dateEl.value }),{
      headers: { "x-staff-token": token }
    });
    if(!res.ok) throw new Error(await res.text());
    return await res.json(); // [{id,customer_name,customer_phone,starts_at,barber_id}, ...]
  }

  function groupByBarber(appts){
    const map = {};
    for(const b of BARBERS) map[b.id] = [];
    for(const a of appts){
      if(a.barber_id in map) map[a.barber_id].push(a);
    }
    for(const k in map){
      map[k].sort((x,y)=> (x.starts_at > y.starts_at ? 1 : -1));
    }
    return map;
  }

  function buildApptMap(appts){
    const m = {};
    for(const a of appts){
      const hhmm = toHHMM(a.starts_at);
      m[hhmm] = { id: a.id, name: a.customer_name, phone: a.customer_phone };
    }
    return m;
  }

  function renderSlots(barber_id, data, apptsForBarber){
    const slotsEl = document.getElementById(`slots_${barber_id}`);
    slotsEl.innerHTML = "";

    const apptMap = buildApptMap(apptsForBarber || []);

    (data.slots || []).forEach(s=>{
      const d = document.createElement("div");

      // si viene status, úsalo; si no, cae a available/occupied
      const status = s.status || (s.available ? "available" : "occupied");
      const isFree = (status === "available");

      d.className = "slot " + (isFree ? "available" : "busy");

      if(isFree){
        d.innerHTML = `
          <div style="font-weight:900;">${s.time}</div>
          <div class="muted" style="margin-top:4px;">Disponible</div>
        `;
      } else {
        const a = apptMap[s.time];
        const name  = a?.name  || "Hora deshabilitada";
        const phone = a?.phone || "";

        d.innerHTML = `
          <div style="font-weight:900;">${s.time}</div>
          <div style="margin-top:6px; font-size:12px; line-height:1.15; opacity:.92;">
            <div style="font-weight:800;">${name}</div>
            <div style="opacity:.85;">${phone}</div>
          </div>
        `;
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
      const hhmm = toHHMM(a.starts_at);
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><b>${hhmm}</b></td>
        <td>${a.customer_name}</td>
        <td>${a.customer_phone}</td>
        <td>
          <button class="danger" type="button" onclick="cancelAppt(${a.id})">Cancelar</button>
        </td>
      `;
      bodyEl.appendChild(tr);
    }
  }

  async function cancelAppt(id){
    const token = (tokenEl.value || "").trim();
    if(!token){ alert("Pon el Staff Token para cancelar."); return; }
    if(!confirm("¿Cancelar esta cita?")) return;

    const res = await fetch(`/staff/appointments/${id}`,{
      method:"DELETE",
      headers: { "x-staff-token": token }
    });

    if(!res.ok){
      alert("No se pudo cancelar: " + await res.text());
      return;
    }
    await reloadActiveBarber();
  }

  async function setWorkday(is_open){
    const token = (tokenEl.value || "").trim();
    if(!token){ alert("Pon el Staff Token"); return; }
    if(!ACTIVE_BARBER_ID){ alert("No hay barbero seleccionado"); return; }

    const day = dateEl.value;
    const start_time = (document.getElementById("ws_start").value || "10:00").trim();
    const end_time   = (document.getElementById("ws_end").value || "20:00").trim();

    const res = await fetch("/staff/workdays/set",{
      method:"POST",
      headers:{
        "Content-Type":"application/json",
        "x-staff-token": token
      },
      body: JSON.stringify({ barber_id: ACTIVE_BARBER_ID, day, is_open, start_time, end_time })
    });

    if(!res.ok){
      alert("No se pudo guardar: " + await res.text());
      return;
    }
    hintEl.textContent = is_open ? "Día abierto ✅" : "Día cerrado ⛔";
    setTimeout(()=>hintEl.textContent="", 1200);

    await reloadActiveBarber();
  }

  async function reloadActiveBarber(){
    buildTabs();
    areaEl.innerHTML = "";

    const b = BARBERS.find(x=>x.id === ACTIVE_BARBER_ID);
    if(!b){
      areaEl.innerHTML = `<div class="card"><div class="muted">No hay barberos.</div></div>`;
      return;
    }

    areaEl.appendChild(sectionShell(b));

    // 1) Citas
    let appts = [];
    try{
      appts = await fetchAppointmentsAll();
    }catch(e){
      // si no hay token, igual renderizamos horarios
      hintEl.textContent = e.message || "No se pudieron cargar citas.";
      appts = [];
    }

    const grouped = groupByBarber(appts);
    const apptsForBarber = grouped[b.id] || [];

    // 2) Horarios
    try{
      const av = await fetchAvailability(b.id, dateEl.value);
      renderSlots(b.id, av, apptsForBarber);
    }catch(e){
      document.getElementById(`slots_${b.id}`).innerHTML =
        `<small class="muted">Error horarios: ${e.message}</small>`;
    }

    // 3) Tabla
    renderAppointments(b.id, apptsForBarber);
  }

  // Eventos
  dateEl.onchange = reloadActiveBarber;

  // Init
  buildTabs();
  reloadActiveBarber();
</script>
</body>
</html>
