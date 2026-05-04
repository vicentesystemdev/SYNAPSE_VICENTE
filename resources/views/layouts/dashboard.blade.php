<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Vite / TailwindCSS - AGREGAR ESTO -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 (asegúrate de que esté configurado en config/adminlte.php si necesitas las traducciones/plugins) -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    
    @yield('css')
    <style>
            :root {
                /* Paleta INTELECTA — Académica */
                --color-primary: #3b5bdb;         /* Índigo principal */
                --color-primary-dark: #2f4ac2;
                --color-primary-light: #748ffc;
                --color-secondary: #4dabf7;       /* Celeste */
                --color-accent: #51cf66;          /* Verde éxito */
                --color-surface: #f8f9fa;         /* Fondo gris claro */
                --color-surface-dark: #1e2a45;   /* Sidebar oscuro */
                --color-on-surface: #212529;
                --color-on-surface-light: #495057;
                --color-border: rgba(59, 91, 219, 0.18);

                /* Compatibilidad hacia atrás */
                --neon-blue: var(--color-primary);
                --neon-purple: var(--color-primary-light);
                --neon-white: #f8f9fa;
                --dark-bg: var(--color-surface-dark);
                --light-bg: rgba(59, 91, 219, 0.06);
                --emerald-green: var(--color-accent);
                --neon-glow: 0 0 10px rgba(59, 91, 219, 0.25);
            }

            /* General Body and Wrapper Styling */
            body {
                font-family: 'Rajdhani', sans-serif;
                background-color: transparent;
                color: var(--neon-white);
                line-height: 1.6;
                margin: 0;
                padding: 0;
            }

            .background-video {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                z-index: -1;
                object-fit: cover;
                opacity: 0.4; /* Adjust opacity as needed */
            }

            .wrapper {
                background-color: var(--color-surface);
                min-height: 100vh;
            }

            /* Main Sidebar - Gradient and Shadows */
            /* Main Sidebar - Glassmorphism */
            /* Main Sidebar - Glassmorphism */
            /* Main Sidebar - Glassmorphism */
            .main-sidebar {
                background-color: var(--color-surface-dark) !important;
                box-shadow: 2px 0 12px rgba(0,0,0,0.18);
                border-right: 1px solid rgba(59,91,219,0.15);
            }
            
            .content-wrapper {
                background-color: transparent !important; /* Make content wrapper transparent */
            }
            /* Ensure neon-white text on dark background */
            .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link,
            .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
                color: var(--neon-white); /* Neon white text for better contrast */
            }

            /* Brand Logo and Text */
            .brand-link {
                background-color: transparent !important;
                color: var(--neon-white) !important;
                border-bottom: 1px solid var(--color-border);
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
            }
            .brand-link:hover {
                background-color: rgba(255, 140, 43, 0.1) !important;
                box-shadow: 0 0 10px rgba(255, 140, 43, 0.2);
            }
            .brand-text {
                font-weight: 700 !important;
                color: var(--color-primary) !important;
                font-family: 'Roboto Mono', monospace;
                letter-spacing: 1px;
            }

            /* Sidebar Nav Items */
            .nav-sidebar .nav-item .nav-link {
                transition: all 0.3s ease;
                margin-bottom: 5px;
                border-radius: 8px;
                padding: 10px 15px;
                border: 1px solid transparent;
            }
            .nav-sidebar .nav-item .nav-link p,
            .nav-sidebar .nav-item .nav-link i {
                color: var(--color-on-surface);
                transition: color 0.3s ease;
            }

            .nav-sidebar .nav-item .nav-link:hover {
                background-color: rgba(255, 140, 43, 0.15) !important;
                color: var(--color-primary) !important;
                transform: translateX(5px);
                border-color: rgba(255, 140, 43, 0.3);
                box-shadow: 0 0 15px rgba(255, 140, 43, 0.1);
            }
            .nav-sidebar .nav-item .nav-link:hover p,
            .nav-sidebar .nav-item .nav-link:hover i {
                color: var(--color-primary) !important;
            }

            .nav-sidebar > .nav-item > .nav-link.active,
            .nav-sidebar > .nav-item > .nav-link.active:hover {
                background: linear-gradient(90deg, rgba(255, 140, 43, 0.2), transparent) !important;
                color: var(--color-primary) !important;
                box-shadow: -2px 0 0 var(--color-primary);
                transform: translateX(0);
                border: 1px solid rgba(255, 140, 43, 0.2);
            }
            .nav-sidebar > .nav-item > .nav-link.active p,
            .nav-sidebar > .nav-item > .nav-link.active i {
                color: var(--color-primary) !important;
                font-weight: 600;
            }

            /* Nav Headers */
            .nav-header {
                color: var(--neon-purple) !important; /* Electrifying purple for headers */
                font-weight: bold;
                text-transform: uppercase;
                padding: 10px 15px 5px 15px;
                letter-spacing: 1px;
                font-size: 0.85rem;
                text-shadow: 0 0 5px var(--neon-purple); /* Subtle neon text shadow */
            }

            /* Navbar (Top) styling */
            .main-header.navbar {
                background-color: var(--color-surface-dark);
                border-bottom: 2px solid var(--color-primary);
                box-shadow: 0 2px 8px rgba(59, 91, 219, 0.2);
            }
            .main-header .nav-link {
                color: var(--neon-white); /* Texto neón blanco para navbar items */
                transition: color 0.3s ease, text-shadow 0.3s ease;
            }
            .main-header .nav-link:hover {
                color: var(--neon-blue);
                text-shadow: 0 0 5px rgba(0, 229, 255, 0.7);
            }

            /* User menu in navbar */
            .user-header.bg-primary {
                background-color: var(--neon-blue) !important;
                color: var(--dark-bg) !important; /* Texto oscuro para el user header */
            }
            .user-header.bg-primary p {
                color: var(--dark-bg) !important;
            }

            /* Cards and Content Area - Minimalist and Aesthetic */
            .card {
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 229, 255, 0.3); /* De tu contenedor de ejemplo */
                border: 1px solid var(--neon-blue);
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                background-color: var(--light-bg); /* Fondo claro para las tarjetas */
            }
            .card:hover {
                transform: translateY(-3px);
                box-shadow: 0 0 25px rgba(0, 229, 255, 0.8), 0 0 40px rgba(174, 0, 255, 0.4); /* De tu formula hover */
            }
            .card-header {
                background-color: var(--dark-bg); /* Fondo oscuro para el header de la tarjeta */
                color: var(--neon-white);
                border-bottom: 1px solid var(--neon-blue);
                border-top-left-radius: 9px;
                border-top-right-radius: 9px;
                padding: 1rem 1.25rem;
            }
            .card-title {
                font-weight: 600;
                color: var(--neon-blue);
            }

            /* Buttons */
            .btn-primary {
                background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple)) !important;
                border: none !important; /* Eliminar el borde predeterminado */
                color: var(--neon-white) !important;
                box-shadow: 0 0 15px rgba(0, 229, 255, 0.7); /* De tu botón de ejemplo */
                transition: all 0.4s ease; /* Transición más suave */
            }
            .btn-primary:hover {
                background: linear-gradient(45deg, var(--neon-purple), var(--neon-blue)) !important;
                transform: scale(1.02) translateY(-3px); /* Efecto de escala y elevación */
                box-shadow: 0 0 20px rgba(0, 229, 255, 1), 0 0 30px rgba(174, 0, 255, 0.8) !important; /* De tu botón de ejemplo */
            }

            .btn-secondary {
                background-color: #6c757d !important;
                border-color: #6c757d !important;
                color: #fff !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            }
            .btn-secondary:hover {
                background-color: #5a6268 !important;
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }

            .btn-info { /* Used for edit buttons */
                background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple)) !important;
                border: none !important; /* Eliminar el borde predeterminado */
                color: var(--neon-white) !important;
                box-shadow: 0 0 15px rgba(0, 229, 255, 0.7); /* De tu botón de ejemplo */
                transition: all 0.4s ease; /* Transición más suave */
            }
            .btn-info:hover {
                background: linear-gradient(45deg, var(--neon-purple), var(--neon-blue)) !important;
                transform: scale(1.02) translateY(-3px); /* Efecto de escala y elevación */
                box-shadow: 0 0 20px rgba(0, 229, 255, 1), 0 0 30px rgba(174, 0, 255, 0.8) !important; /* De tu botón de ejemplo */
            }

            /* Status Badges/Buttons (Activo/Inactivo) */
            .btn-success, .badge.bg-success {
                background-color: var(--neon-blue) !important; /* Usando neón azul para éxito */
                border-color: var(--neon-blue) !important;
                color: var(--dark-bg) !important;
                box-shadow: 0 0 8px rgba(0, 229, 255, 0.7); /* Sombra neón para éxito */
            }
            .btn-danger, .badge.bg-danger {
                background-color: var(--neon-purple) !important; /* Usando neón púrpura para peligro */
                border-color: var(--neon-purple) !important;
                color: var(--neon-white) !important;
                box-shadow: 0 0 8px rgba(174, 0, 255, 0.7); /* Sombra neón para peligro */
            }
            
            /* Minimalist Table Text */
            .table {
                font-size: 0.9rem;
                color: var(--neon-white); /* Texto de tabla neón blanco */
            }
            .table th {
                font-weight: 600;
                color: var(--neon-blue); /* Encabezados de tabla neón azul */
                text-transform: uppercase;
                font-size: 0.8rem;
                background-color: rgba(0, 229, 255, 0.1); /* Fondo sutil con neón azul */
                text-shadow: 0 0 5px rgba(0, 229, 255, 0.3);
            }
            .table td {
                vertical-align: middle;
                color: var(--neon-white); /* Texto de celda neón blanco */
            }

            /* Content Header */
            .content-header h1 {
                color: var(--color-primary);
                font-weight: 700;
                letter-spacing: 0.5px;
            }

            /* Footer */
            .main-footer {
                background-color: var(--color-surface-dark);
                border-top: 2px solid var(--color-primary);
                color: #adb5bd;
                padding: 15px 25px;
                font-size: 0.9em;
            }
            .main-footer strong {
                color: var(--neon-white);
            }
        </style>
        <style>
            @keyframes neon-glow {
                0%, 100% {
                    text-shadow: 0 0 5px var(--neon-white), 0 0 10px var(--neon-blue), 0 0 20px var(--neon-blue), 0 0 40px var(--neon-purple);
                }
                50% {
                    text-shadow: 0 0 10px var(--neon-white), 0 0 20px var(--neon-blue), 0 0 30px var(--neon-blue), 0 0 50px var(--neon-purple);
                }
            }

            /* Custom User Menu Styles */
            .custom-user-menu .nav-link {
                transition: all 0.3s ease;
                border-radius: 50px; /* Pill shape for trigger */
                padding: 5px 15px !important;
                border: 1px solid transparent;
            }
            .custom-user-menu .nav-link:hover {
                background: rgba(255, 255, 255, 0.05);
                border-color: var(--neon-blue);
                box-shadow: 0 0 10px rgba(0, 229, 255, 0.2);
            }
            .user-avatar-glow {
                display: flex;
                align-items: center;
                justify-content: center;
                filter: drop-shadow(0 0 2px var(--neon-blue));
            }

            .custom-dropdown-content {
                background-color: rgba(12, 11, 18, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid var(--neon-blue);
                box-shadow: 0 0 20px rgba(0, 229, 255, 0.15);
                border-radius: 12px;
                padding: 8px;
                min-width: 240px;
                margin-top: 10px;
            }

            .dropdown-header-custom {
                padding: 12px 16px;
                text-align: left;
            }
            .dropdown-header-custom .user-name {
                color: var(--neon-white);
                font-size: 1rem;
                font-weight: 700;
                margin: 0;
            }
            .dropdown-header-custom .user-email {
                color: var(--color-on-surface);
                font-size: 0.8rem;
                opacity: 0.7;
                margin: 0;
            }

            .dropdown-divider-custom {
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--neon-blue), transparent);
                opacity: 0.3;
                margin: 8px 0;
            }

            .dropdown-item-custom {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 16px;
                color: var(--neon-white);
                border-radius: 8px;
                transition: all 0.2s ease;
                text-decoration: none;
                font-weight: 500;
            }
            .dropdown-item-custom:hover {
                background: rgba(0, 229, 255, 0.1);
                color: var(--neon-blue);
                transform: translateX(4px);
            }
            .dropdown-item-custom svg {
                transition: transform 0.2s ease;
            }
            .dropdown-item-custom:hover svg {
                transform: scale(1.1);
            }

            .logout-item:hover {
                background: rgba(255, 50, 50, 0.1);
                color: #ff4d4d;
            }
        </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <video autoplay muted loop id="background-video" class="background-video">
        <source src="{{ asset('images/Fondo2.mp4') }}" type="video/mp4">
    </video>

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- Puedes añadir más items aquí si quieres que la barra superior los tenga --}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Menu (logout) -->
            <!-- Custom User Menu -->
            <li class="nav-item dropdown custom-user-menu">
                <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center; gap: 8px;">
                     <div class="user-avatar-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="color: var(--neon-blue);">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </g>
                        </svg>
                     </div>
                     <span class="d-none d-md-inline" style="font-weight: 600; font-family: 'Rajdhani', sans-serif; letter-spacing: 0.5px;">{{ Auth::user()->name ?? 'Guest' }}</span>
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" style="opacity: 0.7;">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9l6 6l6-6"></path>
                     </svg>
                </a>
                
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right custom-dropdown-content">
                    <div class="dropdown-header-custom">
                         <p class="user-name">{{ Auth::user()->name ?? 'Guest' }}</p>
                         @if(Auth::user())
                            <p class="user-email">{{ Auth::user()->email }}</p>
                         @endif
                    </div>
                    
                    <div class="dropdown-divider-custom"></div>
                    
                    <a href="{{ route('profile.edit') }}" class="dropdown-item-custom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </g>
                        </svg>
                        <span>Perfil</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item-custom logout-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"></path>
                                    <path d="M9 12h12l-3-3m0 6l3-3"></path>
                                </g>
                            </svg>
                            <span>Cerrar Sesión</span>
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <span class="brand-text" style="font-weight:800; letter-spacing:1px; color:#748ffc;">INTELECTA</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    {{-- Aquí es donde se inyectará el menú específico de cada dashboard --}}
                    @yield('sidebar_menu')
                </ul>
            </nav>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('content_header')</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>INTELECTA &copy; {{ date('Y') }}</strong> — Plataforma de Evaluación Lógico-Matemática.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('js')
</body>
</html>
