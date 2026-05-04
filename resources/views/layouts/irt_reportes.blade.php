<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Reportes IRT')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro (o la que uses, el prompt sugiere Inter/Roboto) -->
    <!-- Para un look más moderno, sugiero Inter o Roboto. AdminLTE ya usa Source Sans Pro. -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- O si quieres Inter: -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons (usado por AdminLTE) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    @yield('css') {{-- Aquí se inyectarán los estilos específicos de la vista --}}

    <style>
        /* ========================================================================
           Variables de Paleta de Colores y Tipografía para tema Oscuro/Naranja/Blanco
           ======================================================================== */
        :root {
            --color-black: #0D1117; /* Fondo principal muy oscuro, casi negro */
            --color-dark-gray: #161B22; /* Fondo de tarjetas, un poco más claro que el black */
            --color-medium-gray: #21262D; /* Para bordes, sombras internas */
            --color-light-gray: #C9D1D9; /* Para texto secundario, bordes claros */
            --color-white: #F0F6FC; /* Texto principal, elementos destacados */
            
            --color-orange-primary: #FF8C00; /* Naranja vibrante para acentos y actividad */
            --color-orange-hover: #FFA500; /* Naranja más brillante para estados hover */
            --color-orange-gradient-start: #FF8C00; /* Inicio del degradado naranja */
            --color-orange-gradient-end: #FF6347; /* Fin del degradado naranja (tomate) */

            --color-text-primary: var(--color-white);
            --color-text-secondary: var(--color-light-gray);

            --font-family-primary: 'Inter', sans-serif; /* Usando Inter para un look moderno */
            --font-size-base: 0.95rem;
            --border-radius-base: 8px;
            --box-shadow-light: 0 2px 5px rgba(0, 0, 0, 0.2);
            --box-shadow-dark: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        /* ========================================================================
           Estilos Generales y del Body (AdminLTE Base Override)
           ======================================================================== */
        body {
            font-family: var(--font-family-primary);
            font-size: var(--font-size-base);
            background-color: var(--color-black) !important; /* Fondo principal muy oscuro */
            color: var(--color-text-primary); /* Texto principal blanco */
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Evitar scroll horizontal */
        }
        
        .wrapper {
            background-color: transparent;
        }

        /* Contenido principal */
        .content-wrapper {
            background-color: var(--color-black) !important; /* Mismo fondo que el body */
            color: var(--color-text-primary);
            padding: 1.5rem;
        }

        /* Header de contenido */
        .content-header {
            background: linear-gradient(90deg, var(--color-orange-gradient-start) 0%, var(--color-orange-gradient-end) 100%) !important;
            padding: 20px 1.5rem;
            margin-bottom: 2rem;
            border-bottom-left-radius: var(--border-radius-base);
            border-bottom-right-radius: var(--border-radius-base);
            box-shadow: var(--box-shadow-dark);
            color: var(--color-white) !important; /* Texto blanco para el header */
            position: relative;
            overflow: hidden; /* Para contener efectos de fondo si se añaden */
            backdrop-filter: blur(5px); /* Efecto de vidrio esmerilado sutil */
            -webkit-backdrop-filter: blur(5px);
        }
        .content-header h1 {
            color: var(--color-white) !important;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
        }
        .content-header h1 i {
            color: var(--color-white) !important; /* Iconos también blancos */
            margin-right: 15px;
            font-size: 1.5em;
        }

        /* ========================================================================
           Sidebar Styling
           ======================================================================== */
        .main-sidebar {
            background-color: var(--color-black) !important;
            border-right: 1px solid var(--color-medium-gray) !important;
            box-shadow: var(--box-shadow-dark);
            color: var(--color-text-secondary);
        }
        .main-sidebar .brand-link {
            background-color: var(--color-black) !important;
            border-bottom: 1px solid var(--color-medium-gray) !important;
        }
        .main-sidebar .brand-text {
            color: var(--color-orange-primary) !important; /* Naranja para el texto de la marca */
            font-weight: 900;
            font-size: 1.5rem;
            text-shadow: 0 0 5px rgba(255,140,0,0.5); /* Pequeño brillo naranja */
        }
        .user-panel .info a {
            color: var(--color-text-primary);
        }
        .user-panel .info a:hover {
            color: var(--color-orange-primary);
        }

        .sidebar .nav-sidebar .nav-item .nav-link {
            color: var(--color-text-secondary) !important;
            transition: all 0.3s ease;
            margin-bottom: 3px;
            border-radius: var(--border-radius-base);
            padding: 10px 15px;
            font-weight: 500;
        }
        .sidebar .nav-sidebar .nav-item .nav-link:hover {
            background-color: rgba(255, 140, 0, 0.1) !important; /* Fondo naranja muy sutil en hover */
            color: var(--color-orange-primary) !important;
            transform: translateX(5px);
            box-shadow: none;
            backdrop-filter: blur(3px); /* Efecto de vidrio esmerilado en hover */
            -webkit-backdrop-filter: blur(3px);
        }
        .sidebar .nav-sidebar .nav-item .nav-link.active {
            background: linear-gradient(90deg, var(--color-orange-primary) 0%, var(--color-orange-gradient-end) 100%) !important;
            color: var(--color-white) !important;
            box-shadow: var(--box-shadow-light);
            border: none;
            text-shadow: 0 0 5px rgba(255,140,0,0.3);
        }
        .sidebar .nav-sidebar .nav-item .nav-link.active p,
        .sidebar .nav-sidebar .nav-item .nav-link.active i {
            color: var(--color-white) !important;
        }
        .nav-header {
            color: var(--color-light-gray) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
            letter-spacing: 1px;
            padding: 15px 15px 5px 15px;
            border-bottom: 1px solid var(--color-medium-gray);
            margin-bottom: 10px;
        }

        /* ========================================================================
           Navbar (Top) Styling
           ======================================================================== */
        .main-header.navbar {
            background-color: var(--color-black) !important;
            border-bottom: 1px solid var(--color-medium-gray) !important;
            box-shadow: var(--box-shadow-dark);
            color: var(--color-text-primary);
        }
        .main-header .nav-link {
            color: var(--color-text-primary);
            transition: color 0.3s ease;
        }
        .main-header .nav-link:hover {
            color: var(--color-orange-primary);
        }
        .user-menu .dropdown-menu {
            background-color: var(--color-dark-gray); /* Fondo oscuro para el dropdown */
            border: 1px solid var(--color-medium-gray);
            box-shadow: var(--box-shadow-dark);
        }
        .user-menu .dropdown-menu .user-header {
            background: linear-gradient(90deg, var(--color-orange-primary) 0%, var(--color-orange-gradient-end) 100%) !important;
            color: var(--color-white) !important;
        }
        .user-menu .dropdown-menu .user-header p,
        .user-menu .dropdown-menu .user-header small {
            color: var(--color-white) !important;
        }
        .user-menu .dropdown-menu .user-footer {
            background-color: var(--color-dark-gray);
            border-top: 1px solid var(--color-medium-gray);
        }
        .user-menu .dropdown-menu .user-footer a {
            color: var(--color-text-primary);
            background-color: var(--color-medium-gray);
            border: 1px solid var(--color-medium-gray);
            transition: all 0.3s ease;
        }
        .user-menu .dropdown-menu .user-footer a:hover {
            background-color: var(--color-orange-hover);
            color: var(--color-white);
            border-color: var(--color-orange-hover);
        }

        /* ========================================================================
           Card Styling (Neumorphic / Glassmorphic inspired)
           ======================================================================== */
        .card {
            border-radius: var(--border-radius-base);
            background-color: var(--color-dark-gray) !important; /* Fondo de tarjeta oscuro */
            color: var(--color-text-primary) !important; /* Texto principal blanco */
            border: 1px solid var(--color-medium-gray) !important;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.4), -5px -5px 10px rgba(40,40,40,0.2) !important; /* Neumórfico suave */
            transition: all 0.3s ease;
            backdrop-filter: blur(3px); /* Efecto de vidrio esmerilado en cards */
            -webkit-backdrop-filter: blur(3px);
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 8px 8px 15px rgba(0,0,0,0.5), -8px -8px 15px rgba(50,50,50,0.3) !important;
        }
        .card-header {
            background-color: var(--color-medium-gray) !important; /* Header de tarjeta más gris */
            color: var(--color-text-primary) !important;
            border-bottom: 1px solid var(--color-dark-gray) !important;
            border-top-left-radius: var(--border-radius-base);
            border-top-right-radius: var(--border-radius-base);
            padding: 1rem 1.25rem;
            font-weight: 600;
            display: flex; /* Para alinear título y herramientas */
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            color: var(--color-orange-primary) !important;
            font-weight: 700;
            font-size: 1.25rem;
        }
        .card-title i {
            color: var(--color-orange-primary) !important;
        }
        .card-body {
            padding: 1.5rem;
            color: var(--color-text-primary);
        }
        .card-body p {
            color: var(--color-text-secondary);
            margin-bottom: 1rem;
        }
        /* Texto secundario en cards */
        .text-white-50 {
            color: var(--color-text-secondary) !important;
        }
        /* Iconos y texto naranja */
        .text-orange-600, .text-orange-400, .text-orange-300 {
            color: var(--color-orange-primary) !important;
        }
        
        /* ========================================================================
           Buttons and Links (Neumorphic Orange)
           ======================================================================== */
        .btn {
            border-radius: var(--border-radius-base);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 3px 3px 6px rgba(0,0,0,0.3), -3px -3px 6px rgba(40,40,40,0.1) !important;
            border: 1px solid var(--color-medium-gray) !important;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 5px 5px 10px rgba(0,0,0,0.4), -5px -5px 10px rgba(50,50,50,0.2) !important;
        }

        .btn-primary, .custom-btn-teal { /* Botón principal, de acción */
            background: linear-gradient(90deg, var(--color-orange-primary) 0%, var(--color-orange-gradient-end) 100%) !important;
            border-color: var(--color-orange-primary) !important;
            color: var(--color-white) !important;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        .btn-primary:hover, .custom-btn-teal:hover {
            background: linear-gradient(90deg, var(--color-orange-hover) 0%, var(--color-orange-primary) 100%) !important;
            border-color: var(--color-orange-hover) !important;
        }
        .btn-secondary, .btn-default {
            background-color: var(--color-medium-gray) !important;
            border-color: var(--color-medium-gray) !important;
            color: var(--color-text-primary) !important;
        }
        .btn-secondary:hover, .btn-default:hover {
            background-color: var(--color-dark-gray) !important;
            border-color: var(--color-orange-primary) !important;
            color: var(--color-orange-primary) !important;
        }
        .btn-tool {
            color: var(--color-text-secondary) !important;
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }
        .btn-tool:hover {
            color: var(--color-orange-primary) !important;
            transform: scale(1.1);
        }

        /* Pequeños botones teal-sm se convierten a naranja-sm */
        .custom-btn-teal-sm {
            background: linear-gradient(90deg, var(--color-orange-primary) 0%, var(--color-orange-gradient-end) 100%) !important;
            border-color: var(--color-orange-primary) !important;
            color: var(--color-white) !important;
            font-size: 0.75rem;
            padding: 0.25rem 0.6rem;
            border-radius: 5px;
            box-shadow: 2px 2px 4px rgba(0,0,0,0.2), -2px -2px 4px rgba(40,40,40,0.1) !important;
        }
        .custom-btn-teal-sm:hover {
            background: linear-gradient(90deg, var(--color-orange-hover) 0%, var(--color-orange-primary) 100%) !important;
            border-color: var(--color-orange-hover) !important;
            transform: translateY(-1px);
        }

        /* ========================================================================
           Table and Data Visualization Styling
           ======================================================================== */
        .table {
            font-size: 0.9rem;
            color: var(--color-text-primary);
        }
        .table th {
            font-weight: 700;
            color: var(--color-orange-primary); /* Encabezados de tabla naranjas */
            text-transform: uppercase;
            font-size: 0.8rem;
            background-color: var(--color-dark-gray);
            border-bottom: 2px solid var(--color-orange-gradient-end) !important;
            padding: 12px 1.25rem;
            text-align: left;
        }
        .table td {
            vertical-align: middle;
            color: var(--color-text-secondary);
            padding: 10px 1.25rem;
            border-top: 1px solid var(--color-medium-gray) !important;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 140, 0, 0.03) !important; /* Franjas sutiles con tono naranja */
        }
        .table-dark th, .table-dark td, .table-dark thead th { /* Para tablas dentro de cards oscuros */
            background-color: var(--color-dark-gray) !important;
            color: var(--color-text-primary) !important;
            border-color: var(--color-medium-gray) !important;
        }
        .table-dark thead th {
             background-color: var(--color-dark-gray) !important;
             color: var(--color-orange-primary) !important;
             border-bottom-color: var(--color-orange-gradient-end) !important;
        }
        
        /* Badges for levels (neumorphic-like) */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: .4em .7em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 50rem; /* Más redondeado */
            transition: all 0.2s ease-in-out;
            box-shadow: 2px 2px 4px rgba(0,0,0,0.3), -2px -2px 4px rgba(40,40,40,0.1) !important;
        }
        .badge-bajo {
            background-color: #EF4444 !important; /* Rojo vibrante */
            color: var(--color-white) !important;
        }
        .badge-medio {
            background-color: #FACC15 !important; /* Amarillo vibrante */
            color: var(--color-black) !important; /* Texto oscuro para el amarillo */
        }
        .badge-alto {
            background-color: #22C55E !important; /* Verde vibrante */
            color: var(--color-white) !important;
        }

        /* List Group para recomendaciones */
        .list-group-item.bg-dark {
            background-color: var(--color-dark-gray) !important;
            border: 1px solid var(--color-medium-gray) !important;
            color: var(--color-text-primary) !important;
            margin-bottom: 5px;
            border-radius: var(--border-radius-base);
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.2), inset -2px -2px 5px rgba(40,40,40,0.1) !important; /* Sombra interna para neumorfismo */
            transition: all 0.2s ease;
        }
        .list-group-item.bg-dark:hover {
            background-color: var(--color-medium-gray) !important;
            transform: translateY(-2px);
        }
        .list-group-item small {
            color: var(--color-text-secondary) !important;
        }

        /* ========================================================================
           Footer Styling
           ======================================================================== */
        .main-footer {
            background-color: var(--color-black) !important;
            border-top: 1px solid var(--color-medium-gray) !important;
            color: var(--color-text-secondary);
            padding: 1rem 1.5rem;
            font-size: 0.85em;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
        }
        .main-footer strong {
            color: var(--color-text-primary);
        }

        /* ========================================================================
           Info Panel Styling
           ======================================================================== */
        .info-panel {
            background-color:rgba(244, 107, 8, 0.45) !important; /* Un tono café/naranja oscuro para el fondo */
            border-radius: var(--border-radius-base);
            padding: 1.5rem;
            margin-top: 1.5rem; /* Margen superior para separarlo del título */
            border: 1px solidrgba(191, 104, 17, 0.78) !important; /* Borde sutil */
            box-shadow: 4px 4px 8px rgba(0,0,0,0.3), -4px -4px 8px rgba(60,50,40,0.1) !important; /* Sombra neumórfica */
            color: var(--color-text-secondary) !important; /* Texto secundario para el cuerpo */
            font-size: 0.95em;
            line-height: 1.6;
        }
        .info-panel p {
            color: var(--color-text-secondary) !important; /* Asegura el color del texto del párrafo */
            margin-bottom: 0; /* Elimina margen inferior extra si lo hubiera */
        }

        /* Custom styles for the new search input */
        .custom-input-dark {
            background-color: var(--color-dark-gray) !important;
            color: var(--color-text-primary) !important;
            border: 1px solid var(--color-medium-gray) !important;
            border-right: none !important; /* Quitar borde derecho para el input */
        }
        .custom-input-dark::placeholder {
            color: var(--color-text-secondary);
        }
        .custom-input-dark:focus {
            background-color: var(--color-dark-gray);
            color: var(--color-white);
            border-color: var(--color-orange-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 0, 0.25); /* Resaltado naranja en foco */
        }
  
        .custom-btn-dark-outline {
            background-color: var(--color-medium-gray) !important;
            border-color: var(--color-medium-gray) !important;
            color: var(--color-text-primary) !important;
            transition: all 0.3s ease;
        }
        .custom-btn-dark-outline:hover {
            background-color: var(--color-dark-gray) !important;
            border-color: var(--color-orange-primary) !important;
            color: var(--color-orange-primary) !important;
        }
        .custom-btn-dark-outline .fas {
            color: var(--color-orange-primary) !important; /* Color de la lupa */
        }
  
        /* Estilos para el contenedor de sugerencias */
        #student_suggestions_container {
            border-radius: var(--border-radius-base);
            box-shadow: var(--box-shadow-dark);
            border: 1px solid var(--color-medium-gray);
            background-color: var(--color-dark-gray);
            z-index: 1050; /* Asegurar que esté por encima de otros elementos */
        }
        #student_suggestions_container .list-group-item {
            background-color: var(--color-dark-gray) !important;
            border-color: var(--color-medium-gray) !important;
            color: var(--color-text-secondary) !important;
        }
        #student_suggestions_container .list-group-item:hover {
            background-color: var(--color-medium-gray) !important;
            color: var(--color-orange-primary) !important;
            cursor: pointer;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">
        <!-- Navbar (Top) -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                </li>
                <li class="nav-item">
                </li>

                <!-- User Menu (logout) -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0;">
                        <li class="user-header bg-primary" style="background-color: var(--color-orange-primary) !important; color: var(--color-white) !important;">
                            <p style="color: var(--color-white) !important;">
                                {{ Auth::user()->name ?? 'Admin' }}
                                <small style="color: rgba(255,255,255,0.7) !important;">{{ Auth::user()->email ?? 'admin@example.com' }}</small>
                            </p>
                        </li>
                        <li class="user-footer" style="background-color: var(--color-light-gray); border-top: 1px solid var(--color-border-subtle);">
                            <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat" style="background-color: var(--color-light-gray); color: var(--color-text-dark); border: 1px solid var(--color-border-subtle);">Profile</a>
                            <a class="btn btn-default btn-flat float-right" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               style="background-color: var(--color-light-gray); color: var(--color-text-dark); border: 1px solid var(--color-border-subtle);">
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">Synapse CTF</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">REPORTES IRT</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reportes_irt.index') }}" class="nav-link {{ Request::routeIs('admin.reportes_irt.index') ? 'active' : '' }}"> {{-- Se actualizó la ruta y se añadió lógica para la clase 'active' --}}
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Visión General y Demostración IRT</p> {{-- Se actualizó el texto --}}
                            </a>
                        </li>
                        {{-- La siguiente sección se elimina ya que la 'Visión General IRT' ahora incluye la demostración --}}
                        {{--
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard.demostracion') }}" class="nav-link">
                                <i class="nav-icon fas fa-lightbulb"></i>
                                <p>Demostración IRT</p>
                            </a>
                        </li>
                        --}}
                        <li class="nav-header mt-4">Navegación General</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard Principal</p>
                            </a>
                        </li>
                        {{-- Puedes añadir más ítems al sidebar aquí si tienes más secciones --}}
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
                            <h1 class="m-0">@yield('content_header_irt')</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content_irt')
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 SYNAPSE - BY JARVIS.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    
    @yield('js')
</body>
</html>
