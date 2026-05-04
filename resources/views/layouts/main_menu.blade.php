<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synapse CTF MVP - @yield('title', 'Menú Principal')</title>
    <!-- Opcional: Carga de una fuente moderna como Inter desde Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Variables de Color */
        :root {
            --color-body-bg: #F9FAFB; /* Gris muy claro para el fondo general */
            --color-main-bg: #FFFFFF; /* Blanco para el contenedor principal de contenido */
            --color-header-footer-bg: #111827; /* Negro para Header y Footer */
            --color-text-main: #1F2937; /* Gris oscuro / Casi negro para texto principal */
            --color-text-on-dark: #FFFFFF; /* Blanco para texto sobre fondos oscuros */
            --color-text-on-dark-light: #E5E7EB; /* Gris claro para texto secundario sobre fondos oscuros */
            --color-accent: #F97316; /* Naranja brillante para acentos y CTAs */
            --color-accent-hover: #EA580C; /* Naranja un poco más oscuro para hover */
            --color-border-subtle: #E5E7EB; /* Borde sutil para tarjetas y separadores */
            --color-text-muted: #6B7280; /* Gris para texto menos prominente */
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: var(--color-body-bg);
            color: var(--color-text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Contenedor principal de ancho limitado */
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem; /* Padding consistente en los lados */
        }

        /* Header (Barra de Navegación) - Reimplementado con Flexbox */
        .header {
            background-color: var(--color-header-footer-bg);
            padding: 1rem 0;
            color: var(--color-text-on-dark);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; /* Permite que los elementos se envuelvan en pantallas pequeñas */
            gap: 1.5rem; /* Espacio entre grupos de elementos */
        }
        .header-logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--color-text-on-dark);
            text-decoration: none;
            white-space: nowrap; /* Evita que el logo se rompa */
        }
        .header-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1.8rem; /* Espacio entre los enlaces de navegación */
            flex-wrap: wrap;
            justify-content: center; /* Centra los enlaces en móvil si se envuelven */
        }
        .header-nav a {
            color: var(--color-text-on-dark);
            text-decoration: none;
            font-weight: 600; /* Semibold */
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }
        .header-nav a:hover {
            color: var(--color-accent);
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-left: auto; /* Empuja a la derecha en diseños fluidos */
        }
        .btn-accent {
            background-color: var(--color-accent);
            color: var(--color-text-on-dark);
            padding: 0.7rem 1.5rem;
            border-radius: 9999px; /* Bordes totalmente redondeados */
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            white-space: nowrap; /* Evita que el texto del botón se rompa */
            border: none;
            cursor: pointer;
        }
        .btn-accent:hover {
            background-color: var(--color-accent-hover);
            transform: translateY(-2px);
        }
        .profile-icon {
            width: 2.5rem;
            height: 2.5rem;
            background-color: #6B7280; /* Gris para el placeholder del icono de perfil */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--color-text-on-dark);
            font-weight: bold;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .profile-icon:hover {
            background-color: #4B5563; /* Gris más oscuro al hover */
        }
        .logout-link {
            color: var(--color-text-on-dark-light);
            text-decoration: none;
            font-weight: normal;
            transition: color 0.3s ease;
            padding: 0.5rem 0; /* Para hacer el área clicable más grande */
            margin-left: 0.5rem; /* Espacio entre el icono de perfil y el botón de salir */
        }
        .logout-link:hover {
            color: var(--color-accent);
        }

        /* Contenido Principal (Wrapper que define el fondo blanco y sombra) */
        .main-content-wrapper {
            background-color: var(--color-main-bg);
            border-radius: 0.75rem; /* Un poco más redondeado */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08); /* Sombra más pronunciada */
            padding: 3rem; /* Padding generoso */
            margin: 2.5rem auto; /* Margen superior e inferior */
        }

        /* Footer - Reimplementado con Flexbox */
        .footer {
            background-color: var(--color-header-footer-bg);
            padding: 2.5rem 0;
            color: var(--color-text-on-dark-light);
            font-size: 0.9rem;
            margin-top: 5rem; /* Más espacio respecto al contenido */
        }
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .footer-left {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .footer-left .footer-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--color-text-on-dark-light);
            text-decoration: none;
        }
        .footer-right ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .footer-right a {
            color: var(--color-text-on-dark-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer-right a:hover {
            color: var(--color-accent);
        }

        /* Estilos específicos para el contenido de index.blade.php (se incluyen aquí para evitar otro archivo) */
        .hero-section {
            text-align: center;
            padding: 4rem 2rem;
            margin-bottom: 3rem;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800; /* Extra bold */
            color: var(--color-text-main);
            margin-bottom: 1rem;
            line-height: 1.1;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--color-text-muted); /* Texto principal más sutil */
            max-width: 800px;
            margin: 0 auto 2.5rem auto;
        }
        .hero-cta {
            font-size: 1.1rem;
            padding: 1rem 2.5rem;
            border-radius: 9999px;
            display: inline-block;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-text-main);
            text-align: center;
            margin-bottom: 3rem;
            border-bottom: 2px solid var(--color-accent); /* Subrayado de acento */
            display: inline-block; /* Para que el subrayado se ajuste al texto */
            padding-bottom: 0.5rem;
            margin-left: auto; /* Centrar con display inline-block */
            margin-right: auto;
            width: fit-content; /* Asegura que el borde inferior se ajuste al texto */
        }

        .categories-grid, .featured-challenges-grid, .tools-grid, .info-grid {
            display: grid;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .categories-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* 4 columnas para pantallas grandes */
        }
        .category-card {
            background-color: var(--color-body-bg); /* Fondo ligeramente diferente para las tarjetas */
            border: 1px solid var(--color-border-subtle);
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .category-card:hover {
            border-color: var(--color-accent);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }
        .icon-placeholder {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--color-accent); /* Color de acento para el icono */
            background-color: rgba(249, 115, 22, 0.1); /* Fondo sutil para el icono */
            padding: 0.75rem;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        .category-card .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-text-main);
            margin-bottom: 0.75rem;
        }
        .category-card .card-description {
            font-size: 0.95rem;
            color: var(--color-text-muted);
            flex-grow: 1; /* Empuja el enlace hacia abajo */
            margin-bottom: 1.5rem;
        }
        .category-card .card-link {
            display: inline-block;
            background-color: var(--color-accent);
            color: var(--color-text-on-dark);
            padding: 0.6rem 1.2rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .category-card .card-link:hover {
            background-color: var(--color-accent-hover);
        }

        .featured-challenges-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* 3 columnas */
        }
        .featured-challenge-item {
            background-color: var(--color-body-bg);
            border: 1px solid var(--color-border-subtle);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--color-text-main);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }
        .featured-challenge-item:hover {
            border-color: var(--color-accent);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
            color: var(--color-accent);
        }
        .featured-challenge-item .highlight {
            background-color: var(--color-accent);
            color: var(--color-text-on-dark);
            padding: 0.3rem 0.6rem;
            border-radius: 0.3rem;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Secciones específicas por rol dentro del contenido principal */
        .admin-tools-section, .coach-tools-section, .student-info-section {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px dashed var(--color-border-subtle);
        }
        .tools-grid, .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .tool-link, .info-link {
            display: block;
            background-color: var(--color-body-bg);
            border: 1px solid var(--color-border-subtle);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: var(--color-text-main);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 1px 5px rgba(0,0,0,0.02);
        }
        .tool-link:hover, .info-link:hover {
            border-color: var(--color-accent);
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transform: translateY(-2px);
            color: var(--color-accent);
        }


        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .categories-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Ajuste para laptops más pequeñas */
            }
        }
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            .header-nav ul {
                width: 100%;
                justify-content: center;
                gap: 1rem;
            }
            .header-actions {
                width: 100%;
                justify-content: center;
                margin-left: 0;
            }
            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }
            .footer-right ul {
                justify-content: center;
                gap: 1rem;
            }

            .main-content-wrapper {
                padding: 1.5rem;
                margin: 1.5rem auto;
            }
            .hero-section {
                padding: 3rem 1rem;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .section-title {
                font-size: 1.8rem;
                margin-bottom: 2rem;
            }
            .categories-grid, .featured-challenges-grid, .tools-grid, .info-grid {
                grid-template-columns: 1fr; /* Una sola columna en móvil */
                gap: 1.5rem;
            }
            .category-card, .featured-challenge-item, .tool-link, .info-link {
                padding: 1.25rem;
            }
        }
        @media (max-width: 480px) {
            .header-logo {
                font-size: 1.5rem;
            }
            .header-nav a {
                padding: 0.3rem 0;
            }
            .btn-accent {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .hero-cta {
                padding: 0.8rem 1.8rem;
                font-size: 1rem;
            }
            .section-title {
                font-size: 1.5rem;
            }
            .main-content-wrapper {
                padding: 1rem;
                margin: 1rem auto;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container-main">
            <div class="header-content">
                <a href="{{ route('dashboard') }}" class="header-logo">SYNAPSE</a>
                <nav class="header-nav">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Inicio</a></li>
                        @if (Route::has('evaluaciones.index'))
                            <li><a href="{{ route('evaluaciones.index') }}">Explorar Retos</a></li>
                        @endif
                        @if (Route::has('rankings.index'))
                            <li><a href="{{ route('rankings.index') }}">Ranking</a></li>
                        @endif
                    </ul>
                </nav>
                <div class="header-actions">
                    @auth
                        @php
                            $userRole = Auth::user()->getRoleNames()->first();
                            $buttonText = '';
                            $buttonRoute = '';
                            switch ($userRole) {
                                case 'Admin':
                                    $buttonText = 'PANEL ADMIN';
                                    $buttonRoute = route('admin.dashboard');
                                    break;
                                case 'Coach':
                                    $buttonText = 'PANEL DOCENTE';
                                    $buttonRoute = route('coach.dashboard');
                                    break;
                                case 'Student':
                                    $buttonText = 'MI PROGRESO';
                                    $buttonRoute = route('student.progress');
                                    break;
                                default:
                                    $buttonText = 'DASHBOARD';
                                    $buttonRoute = route('dashboard');
                                    break;
                            }
                        @endphp
                        <a href="{{ $buttonRoute }}" class="btn-accent">{{ $buttonText }}</a>

                        {{-- Icono de perfil con iniciales del usuario --}}
                        @if (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="profile-icon" title="Perfil de {{ Auth::user()->name }}">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">Salir</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-accent">Iniciar Sesión</a>
                        {{-- Opcional: botón de registro si se quiere destacar --}}
                        {{-- <a href="{{ route('register') }}" class="btn-accent" style="background-color: transparent; border: 1px solid var(--color-accent);">Registrarse</a> --}}
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="main-content-wrapper container-main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container-main">
            <div class="footer-content">
                <div class="footer-left">
                    <a href="{{ route('dashboard') }}" class="footer-logo">SYNAPSE</a>
                    <p class="mb-0">© {{ date('Y') }} Synapse CTF MVP. Todos los derechos reservados.</p>
                </div>
                <div class="footer-right">
                    <ul>
                        @if (Route::has('about'))
                            <li><a href="{{ route('about') }}">Acerca de</a></li>
                        @endif
                        @if (Route::has('support'))
                            <li><a href="{{ route('support') }}">Soporte</a></li>
                        @endif
                        @if (Route::has('terms'))
                            <li><a href="{{ route('terms') }}">Términos</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>