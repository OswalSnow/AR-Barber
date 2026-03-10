<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Barbería & Studio | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        :root { --gold: #d4af37; --black: #0b0b0b; --dark-gray: #1a1a1a; }
        body { background-color: var(--black); color: #fff; font-family: 'Roboto', sans-serif; }
        h1, h2, h3, .nav-link { font-family: 'Oswald', sans-serif; text-transform: uppercase; }
        
        .gold-text { color: var(--gold); }
        .bg-gold { background-color: var(--gold); color: #000; }

        /* Navbar */
        .navbar { background-color: rgba(0,0,0,0.9) !important; border-bottom: 2px solid var(--gold); }
        .nav-link { color: #fff !important; margin: 0 15px; letter-spacing: 1px; }
        .nav-link:hover { color: var(--gold) !important; }

        /* Hero Section */
        .hero { 
            height: 70vh; 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
            background-size: cover; background-position: center;
            display: flex; align-items: center; justify-content: center; text-align: center;
        }

        /* Card de Barberos */
        .barber-card { background-color: var(--dark-gray); border: 1px solid #333; transition: 0.4s; overflow: hidden; }
        .barber-card:hover { border-color: var(--gold); transform: translateY(-10px); }
        .barber-img { height: 350px; object-fit: cover; filter: grayscale(100%); transition: 0.5s; }
        .barber-card:hover .barber-img { filter: grayscale(0%); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" class="me-2">
            <span class="gold-text fs-3 fw-bold">AR BARBERÍA</span>
        </a>
        <button class="navbar-toggler bg-gold" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-center">
                <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#barberos">Barberos</a></li>
                <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="/login" class="gold-text">Acceso Staff</a></li>
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
<div class="container mt-4">
    <div class="alert alert-dismissible fade show shadow-lg" role="alert" 
         style="background-color: #d4af37; color: #000; border: none; border-radius: 0;">
        <div class="d-flex align-items-center">
            <span class="fs-4 me-3">✔️</span>
            <div>
                <strong class="text-uppercase">¡Todo listo!</strong><br>
                {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<header id="inicio" class="hero">
    <div class="container">
        <h1 class="display-1 fw-bold">AR <span class="gold-text">BARBERÍA</span> & STUDIO</h1>
        <p class="fs-4 mb-4">Cortes de autor y estilo clásico</p>
        <a href="#barberos" class="btn bg-gold btn-lg px-5 py-3 fw-bold">AGENDAR UNA CITA</a>
    </div>
</header>

<section id="barberos" class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-4 fw-bold">Nuestros <span class="gold-text">Expertos</span></h2>
        <div class="mx-auto bg-gold" style="height: 4px; width: 100px;"></div>
    </div>

    <div class="row g-4">
        @foreach($barberos as $barbero)
        <div class="col-lg-3 col-md-6">
            <div class="card barber-card">
                <img src="{{ asset('img/' . strtolower(str_replace(' ', '_', $barbero->name)) . '.jpg') }}" 
                     class="card-img-top barber-img" alt="{{ $barbero->name }}">
                <div class="card-body text-center">
                    <h4 class="gold-text">{{ $barbero->name }}</h4>
                    <p class="text-secondary small">Maestro Barbero</p>
                    <a href="/agendar/{{ $barbero->id }}" class="btn btn-outline-warning w-100 fw-bold">SELECCIONAR</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<footer class="py-4 text-center border-top border-secondary mt-5">
    <p class="text-secondary">&copy; 2026 AR Barbería & Studio. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>