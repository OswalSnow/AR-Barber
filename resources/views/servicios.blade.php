<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios y Portafolio · AR Barbería</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    
    <style>
        /* === ESTILOS EXACTOS DEL WELCOME === */
        :root { --gold: #d4af37; --black: #0b0b0b; --dark-gray: #1a1a1a; --muted-light: #d1d5db; }
        body { background-color: var(--black); color: #fff; font-family: 'Roboto', sans-serif; }
        h1, h2, h3, .nav-link { font-family: 'Oswald', sans-serif; text-transform: uppercase; }
        
        .gold-text { color: var(--gold); }
        .bg-gold { background-color: var(--gold); color: #000; }

        /* Navbar */
        .navbar { background-color: rgba(0,0,0,0.9) !important; border-bottom: 2px solid var(--gold); padding-top: 10px; padding-bottom: 10px; }
        .nav-link { color: #fff !important; margin: 0 15px; letter-spacing: 1px; }
        .nav-link:hover { color: var(--gold) !important; }

        /* === ESTILOS ESPECÍFICOS DE LA GALERÍA === */
        .text-light-muted { color: var(--muted-light) !important; }
        .section-title { font-weight: 800; letter-spacing: 1px; }

        /* Pestañas (Tabs) */
        .nav-pills .nav-link-pill {
            color: var(--muted-light);
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 700;
            margin: 0 5px 10px 5px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
            font-family: 'Roboto', sans-serif; 
            text-transform: none;
            background: transparent;
        }
        
        .nav-pills .nav-link-pill:hover {
            color: #fff;
            border-color: rgba(212, 175, 55, 0.5);
        }

        .nav-pills .nav-link-pill.active {
            background-color: rgba(212, 175, 55, 0.15);
            color: var(--gold);
            border-color: var(--gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        /* Contenedor de Imágenes */
        .gallery-item {
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, 0.2); 
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
            cursor: pointer;
            background-color: #000; 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-img {
            width: 100%;
            height: auto; 
            max-height: 500px; 
            object-fit: contain; 
            transition: transform 0.5s ease;
        }

        .gallery-item:hover {
            border-color: var(--gold);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.15);
        }

        .gallery-item:hover .gallery-img { transform: scale(1.02); }

        /* Botón de Instagram */
        .ig-btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; padding: 10px 20px; border-radius: 50px;
            font-weight: bold; text-decoration: none; transition: all 0.3s;
            border: 1px solid var(--gold); color: var(--gold); background: transparent;
            font-size: 0.9rem;
        }
        .ig-btn:hover { background: var(--gold); color: #000; transform: translateY(-2px); }

        /* Banner Final */
        .cta-banner {
            background: linear-gradient(180deg, rgba(212, 175, 55, 0.05), transparent);
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }
        .cta-btn {
            display: inline-block; padding: 14px 32px; border-radius: 50px;
            font-weight: 800; text-decoration: none; transition: all 0.3s;
            background: var(--gold); color: #000; letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            font-family: 'Oswald', sans-serif;
        }
        .cta-btn:hover { background: #b5952f; color: #000; transform: scale(1.05); }
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
                <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/#barberos">Barberos</a></li>
                <li class="nav-item"><a class="nav-link gold-text" href="/servicios">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="/login">Acceso Staff</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">El Arte de <span class="gold-text">Nuestros Barberos</span></h2>
        <p class="text-light-muted">Selecciona a un barbero para ver su portafolio.</p>
    </div>

    <ul class="nav nav-pills justify-content-center mb-5" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-pill active" id="pills-alberto-tab" data-bs-toggle="pill" data-bs-target="#pills-alberto" type="button" role="tab">Alberto</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-pill" id="pills-angel-tab" data-bs-toggle="pill" data-bs-target="#pills-angel" type="button" role="tab">Angel</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-pill" id="pills-anibal-tab" data-bs-toggle="pill" data-bs-target="#pills-anibal" type="button" role="tab">Anibal</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-pill" id="pills-kinich-tab" data-bs-toggle="pill" data-bs-target="#pills-kinich" type="button" role="tab">Kinich</button>
        </li>
        
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-pill" id="pills-nuevos-tab" data-bs-toggle="pill" data-bs-target="#pills-nuevos" type="button" role="tab" style="border-color: var(--gold); color: var(--gold);">✨ Nuevos Cortes</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <div class="tab-pane fade show active" id="pills-alberto" role="tabpanel">
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-1.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-2.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-3.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-4.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-5.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/alberto-6.jpg') }}" class="gallery-img"></div></div>
            </div>
            <div class="text-center mt-5">
                <a href="https://www.instagram.com/albert_the_barber10?igsh=MXI2OWV6ZGZuZXo3Ng==" target="_blank" class="ig-btn">📸 Ver más trabajos en su Instagram</a>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-angel" role="tabpanel">
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/angel-1.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/angel-2.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/angel-3.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/angel-4.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/angel-5.jpg') }}" class="gallery-img"></div></div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-anibal" role="tabpanel">
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-1.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-2.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-3.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-4.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-5.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/anibal-6.jpg') }}" class="gallery-img"></div></div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-kinich" role="tabpanel">
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-1.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-2.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-3.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-4.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-5.jpg') }}" class="gallery-img"></div></div>
                <div class="col-12 col-md-6 col-lg-4"><div class="gallery-item"><img src="{{ asset('img/portafolio/kinich-6.jpg') }}" class="gallery-img"></div></div>
            </div>
             <div class="text-center mt-5">
            </div>
        </div>

        <div class="tab-pane fade" id="pills-nuevos" role="tabpanel">
            <div class="row g-4 justify-content-center">
                @if(isset($images) && $images->isNotEmpty())
                    @foreach($images as $image)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $image->path) }}" class="gallery-img">
                            </div>
                            @auth
                            <form action="{{ route('staff.portfolio.destroy', $image->id) }}" method="POST" class="mt-2 text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 15px; border-radius: 20px; font-weight: bold; cursor: pointer;">🗑️ Borrar Foto</button>
                            </form>
                            @endauth
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p class="text-light-muted" style="margin-top: 40px;">Aún no se han subido nuevos cortes recientes.</p>
                    </div>
                @endif
            </div>
        </div>

        </div>
    </div>
    
<div class="cta-banner py-5 mt-4">
    <div class="container text-center">
        <h3 class="mb-3 fw-bold">¿Listo para un <span class="gold-text">cambio</span>?</h3>
        <p class="text-light-muted mb-4">Reserva tu lugar con nuestros barberos y asegura tu mejor versión.</p>
        <a href="/#barberos" class="cta-btn">AGENDAR MI CITA AHORA</a>
    </div>
</div>

<footer class="text-center py-4 mt-5 border-top border-secondary" style="background-color: var(--dark-gray);">
    <p class="text-light-muted mb-0">&copy; {{ date('Y') }} AR Barbería & Studio. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>