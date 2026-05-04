<!DOCTYPE html>
<html lang="en">
  <head>
    <title>INTELECTA — La Evolución de las Evaluaciones en Evaluación Matemática</title>
    <meta property="og:title" content="INTELECTA — La Evolución de las Evaluaciones en Evaluación Matemática" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta property="twitter:card" content="summary_large_image" />

    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;  -webkit-font-smoothing: antialiased;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type=\"button\"],[type=\"reset\"],[type=\"submit\"] {  -webkit-appearance: button;  color: inherit;}button::-moz-focus-inner,[type=\"button\"]::-moz-focus-inner,[type=\"reset\"]::-moz-focus-inner,[type=\"submit\"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type=\"button\"]:-moz-focus,[type=\"reset\"]:-moz-focus,[type=\"submit\"]:-moz-focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}pre {  white-space: normal;}input {  padding: 2px 4px;}img {  display: block;}details {  display: block;  margin: 0;  padding: 0;}summary::-webkit-details-marker {  display: none;}[data-thq=\"accordion\"] [data-thq=\"accordion-content\"] {  max-height: 0;  overflow: hidden;  transition: max-height 0.3s ease-in-out;  padding: 0;}[data-thq=\"accordion\"] details[data-thq=\"accordion-trigger\"][open] + [data-thq=\"accordion-content\"] {  max-height: 1000vh;}details[data-thq=\"accordion-trigger\"][open] summary [data-thq=\"accordion-icon\"] {  transform: rotate(180deg);}html { scroll-behavior: smooth  }
    </style>
    <style data-tag="default-style-sheet">
      html {
        font-family: Montserrat;
        font-size: 1rem;
      }

      body {
        font-weight: 400;
        font-style:normal;
        text-decoration: undefined;
        text-transform: undefined;
        letter-spacing: normal;
        line-height: 1.55;
        color: var(--color-on-surface);
        background: transparent !important;

        fill: var(--color-on-surface);
      }
    </style>
    <link
      rel="stylesheet"
      href="https://unpkg.com/animate.css@4.1.1/animate.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/@teleporthq/teleport-custom-scripts/dist/style.css"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <video autoplay muted loop id="background-video" class="background-video">
      <source src="{{ asset('images/Fondo2.mp4') }}" type="video/mp4">
      Tu navegador no soporta el elemento de video.
    </video>
    <link rel="stylesheet" href="{{ asset('css/estudiante_dashbord/style.css') }}" />
    <div>
      <link href="{{ asset('css/estudiante_dashbord/index.css') }}" rel="stylesheet" />

      <div class="home-container1">
        <navigation-wrapper class="navigation-wrapper">
          <!--Navigation component-->
          <div class="navigation-container1">
            <div class="navigation-container2">
              <div class="navigation-container3">
                <style>
                  @media (prefers-reduced-motion: reduce) {
                  .navigation-unifranz *, .navigation-unifranz *::before, .navigation-unifranz *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                  }
                  }
                </style>
              </div>
            </div>
            <nav id="navigation-unifranz" class="navigation-unifranz">
              <div class="navigation-container">
                <a href="{{ route('dashboard') }}">
                  <div
                    aria-label="Unifranz INTELECTA Homepage"
                    class="navigation-logo"
                  >
                    <span class="navigation-logo-left">unifranz</span>
                    <span class="navigation-logo-divider"></span>
                    <span class="navigation-logo-right">intelecta</span>
                  </div>
                </a>
                <div class="navigation-links">
                  <a href="{{ route('estudiante.evaluaciones.index') }}">
                    <div class="navigation-link">
                      <span class="navigation-link-text">Evaluaciones</span>
                      <span class="navigation-link-glow"></span>
                    </div>
                  </a>
                  <a href="{{ route('estudiante.intentos.index') }}">
                    <div class="navigation-link">
                      <span class="navigation-link-text">Intentos</span>
                      <span class="navigation-link-glow"></span>
                    </div>
                  </a>
                  <a href="{{ route('estudiante.rankings.index') }}">
                    <div class="navigation-link">
                      <span class="navigation-link-text">Clasificaciones</span>
                      <span class="navigation-link-glow"></span>
                    </div>
                  </a>
                  <!-- Eliminados WEB, CRYPTO, HISTORIAL -->
                </div>
                <div class="navigation-user-menu">
                  <button
                    id="navigation-user-toggle"
                    aria-expanded="false"
                    aria-haspopup="true"
                    class="navigation-user-button"
                  >
                    <span class="navigation-navigation-user-icon">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <path
                            d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                          ></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </g>
                      </svg>
                    </span>
                    <span class="navigation-navigation-user-chevron">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m18 15l-6-6l-6 6"
                        ></path>
                      </svg>
                    </span>
                  </button>
                  <div
                    id="navigation-user-dropdown"
                    aria-hidden="true"
                    class="navigation-user-dropdown"
                  >
                    <a href="{{ route('profile.edit') }}">
                      <div class="navigation-dropdown-item">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20"
                          height="20"
                          viewBox="0 0 24 24"
                        >
                          <g
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        >
                          <path
                            d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                          ></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </g>
                      </svg>
                      <span>Perfil</span>
                    </div>
                  </a>
                  <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                          <div
                            class="navigation-dropdown-item navigation-dropdown-item-logout"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="20"
                              height="20"
                              viewBox="0 0 24 24"
                            >
                              <g
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                              >
                                <path
                                  d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"
                                ></path>
                                <path d="M9 12h12l-3-3m0 6l3-3"></path>
                              </g>
                            </svg>
                            <span>Cerrar Sesión</span>
                          </div>
                        </a>
                    </form>
                  </div>
                </div>
                <button
                  id="navigation-mobile-toggle"
                  aria-expanded="false"
                  aria-label="Toggle mobile menu"
                  class="navigation-mobile-toggle"
                >
                  <span
                    class="navigation-navigation-mobile-icon1 navigation-mobile-icon-menu"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 5h16M4 12h16M4 19h16"
                      ></path>
                    </svg>
                  </span>
                  <span class="navigation-navigation-mobile-icon2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M18 6L6 18M6 6l12 12"
                      ></path>
                    </svg>
                  </span>
                </button>
              </div>
              <div
                id="navigation-mobile-menu"
                aria-hidden="true"
                class="navigation-mobile-menu"
              >
                <div class="navigation-mobile-links">
                  <!-- Eliminados WEB, CRYPTO, HISTORIAL -->
                  <div class="navigation-mobile-divider"></div>
                  <a href="{{ route('profile.edit') }}">
                    <div class="navigation-mobile-link">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <path
                            d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                          ></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </g>
                      </svg>
                      <span>Perfil</span>
                    </div>
                  </a>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <div
                          class="navigation-mobile-link navigation-mobile-link-logout"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                          >
                            <g
                              fill="none"
                              stroke="currentColor"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                            >
                              <path
                                d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"
                              ></path>
                              <path d="M9 12h12l-3-3m0 6l3-3"></path>
                            </g>
                          </svg>
                          <span>Cerrar Sesión</span>
                        </div>
                      </a>
                  </form>
                </div>
              </div>
              <div class="navigation-glow-effect"></div>
            </nav>
            <div class="navigation-container4">
              <div class="navigation-container5">
                <style>
                          @keyframes navigation-pulse {0%,100% {opacity: 0;}
                  50% {opacity: 1;}}@keyframes navigation-divider-glow {0%,100% {opacity: 0.5;
                  box-shadow: 0 0 8px var(--color-accent);}
                  50% {opacity: 1;
                  box-shadow: 0 0 16px var(--color-accent),
                          0 0 24px color-mix(in srgb, var(--color-accent) 50%, transparent);}}
                </style>
              </div>
            </div>
            <div class="navigation-container6">
              <div class="navigation-container7">
                <script defer="" data-name="navigation-unifranz">
                  document.addEventListener('DOMContentLoaded', function() {
                    (function(){
                      const navigationUserToggle = document.getElementById("navigation-user-toggle")
                      const navigationUserDropdown = document.getElementById(
                        "navigation-user-dropdown"
                      )
                      const navigationMobileToggle = document.getElementById(
                        "navigation-mobile-toggle"
                      )
                      const navigationMobileMenu = document.getElementById("navigation-mobile-menu")

                      // User Menu Dropdown Toggle
                      if (navigationUserToggle && navigationUserDropdown) {
                        navigationUserToggle.addEventListener("click", function (e) {
                          e.stopPropagation()
                          const isExpanded = this.getAttribute("aria-expanded") === "true"
                          this.setAttribute("aria-expanded", !isExpanded)
                          navigationUserDropdown.setAttribute("aria-hidden", isExpanded)
                        })

                        // Close dropdown when clicking outside
                        document.addEventListener("click", function (e) {
                          if (
                            !navigationUserToggle.contains(e.target) &&
                            !navigationUserDropdown.contains(e.target)
                          ) {
                            navigationUserToggle.setAttribute("aria-expanded", "false")
                            navigationUserDropdown.setAttribute("aria-hidden", "true")
                          }
                        })
                      }

                      // Mobile Menu Toggle
                      if (navigationMobileToggle && navigationMobileMenu) {
                        navigationMobileToggle.addEventListener("click", function () {
                          const isExpanded = this.getAttribute("aria-expanded") === "true"
                          this.setAttribute("aria-expanded", !isExpanded)
                          navigationMobileMenu.setAttribute("aria-hidden", isExpanded)
                        })

                        // Close mobile menu when clicking a link
                        const mobileLinks = navigationMobileMenu.querySelectorAll(
                          ".navigation-mobile-link"
                        )
                        mobileLinks.forEach(function (link) {
                          link.addEventListener("click", function () {
                            navigationMobileToggle.setAttribute("aria-expanded", "false")
                            navigationMobileMenu.setAttribute("aria-hidden", "true")
                          })
                        })

                        // Close mobile menu when window is resized to desktop size
                        let resizeTimer
                        window.addEventListener("resize", function () {
                          clearTimeout(resizeTimer)
                          resizeTimer = setTimeout(function () {
                            if (window.innerWidth > 991) {
                              navigationMobileToggle.setAttribute("aria-expanded", "false")
                              navigationMobileMenu.setAttribute("aria-hidden", "true")
                            }
                          }, 250)
                        })
                      }

                      // Close dropdowns when pressing Escape key
                      document.addEventListener("keydown", function (e) {
                        if (e.key === "Escape") {
                          if (navigationUserToggle) {
                            navigationUserToggle.setAttribute("aria-expanded", "false")
                          }
                          if (navigationUserDropdown) {
                            navigationUserDropdown.setAttribute("aria-hidden", "true")
                          }
                          if (navigationMobileToggle) {
                            navigationMobileToggle.setAttribute("aria-expanded", "false")
                          }
                          if (navigationMobileMenu) {
                            navigationMobileMenu.setAttribute("aria-hidden", "true")
                          }
                        }
                      })
                    })()
                  });
                </script>
              </div>
            </div>
          </div>
        </navigation-wrapper>
        <div class="home-container2">
          <div class="home-container3">
            <style>
              * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
              }
              body {
                font-family: var(--font-family-body);
                /* background: var(--color-surface); */
                color: var(--color-on-surface);
                overflow-x: hidden;
                position: relative;
              }
              #main-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
                background: var(--color-surface-elevated);
                border-bottom: 1px solid var(--color-border);
                box-shadow: var(--shadow-level-2);
                backdrop-filter: blur(12px);
              }
              @media (prefers-reduced-motion: reduce) {
              *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
              }
              }
            </style>
          </div>
        </div>
        <header id="main-header" role="banner">
          <div class="header-container">
            <div class="header-brand">
              <span class="brand-left">unifranz</span>
              <span class="brand-separator"></span>
              <span class="brand-right">intelecta</span>
            </div>
            <button
              id="menu-toggle"
              aria-label="Toggle menu"
              aria-expanded="false"
              aria-controls="dropdown-menu"
              class="menu-toggle"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
              >
                <path
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 5h16M4 12h16M4 19h16"
                ></path>
              </svg>
            </button>
            <div
              id="dropdown-menu"
              role="menu"
              aria-label="User menu"
              class="dropdown-menu"
            >
              <a href="{{ route('profile.edit') }}">
                <div role="menuitem" class="dropdown-item">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                  >
                    <g
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                    >
                      <path
                        d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                      ></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </g>
                  </svg>
                  <span>Perfil</span>
                </div>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    <div role="menuitem" class="dropdown-item">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <path
                            d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"
                          ></path>
                          <path d="M9 12h12l-3-3m0 6l3-3"></path>
                        </g>
                      </svg>
                      <span>Cerrar sesión</span>
                    </div>
                  </a>
              </form>
            </div>
          </div>
        </header>
        <!-- Barra lateral izquierda eliminada -->
        <main id="main-content" class="main-content">
@php
    $categoria = optional($evaluacion->categoria);
    $dificultad = optional($evaluacion->dificultad);
    $categoriaLabel = strtoupper($categoria->codigo_cat ?? $categoria->nombre_cat ?? 'Evaluación lógico-matemática');
    $nivelValor = $dificultad->orden_dif ?? $evaluacion->dificultad_id ?? '3';
    $nivelNombre = $dificultad->nombre_dif ?? 'Nivel de dificultad media';
    
    // Verificar si ya completó
    $userId = Auth::id();
    $yaCompleto = false;
    $score = null;
    
    if ($userId) {
        // Verificar si existe un intento correcto (la única forma válida de completar)
        $yaCompleto = \App\Models\Intento::where('user_id', $userId)
            ->where('evaluacion_id', $evaluacion->id_eval)
            ->where('es_correcto_int', true)
            ->exists();
        
        // Obtener el score solo si ya completó
        if ($yaCompleto) {
            $score = \App\Models\Score::where('user_id', $userId)
                ->where('evaluacion_id', $evaluacion->id_eval)
                ->first();
        }
    }
@endphp

<div class="w-full bg-slate-950 text-slate-100 px-4 py-10">
  <div class="mx-auto max-w-6xl space-y-10">
    <header class="space-y-2">
      <h1 class="text-3xl font-extrabold tracking-tight text-white">
        {{ $evaluacion->titulo_eval ?? 'Reto Evaluación lógico-matemática' }}
      </h1>

      <div class="flex flex-wrap items-center gap-3 text-xs">
        <span class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1 font-semibold tracking-wide">
          <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
          {{ $categoriaLabel }}
        </span>

        <span class="inline-flex rounded-full bg-slate-900/80 px-3 py-1 font-semibold tracking-wide text-amber-300">
          Nivel {{ $nivelValor }} · {{ $nivelNombre }}
        </span>

        @if($yaCompleto)
          <span class="inline-flex items-center rounded-full bg-emerald-900/50 px-3 py-1 text-[11px] font-medium text-emerald-300">
            ✓ Completado
          </span>
        @else
        <span class="inline-flex items-center rounded-full bg-slate-900/80 px-3 py-1 text-[11px] font-medium text-slate-300">
          Intento actual · Sesión adaptativa
        </span>
        @endif
      </div>
    </header>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-[minmax(0,2fr)_minmax(0,1.2fr)]">
      <section
        class="relative overflow-hidden rounded-2xl border {{ $yaCompleto ? 'border-emerald-500/60' : 'border-emerald-500/40' }} bg-gradient-to-br from-slate-950 via-slate-950 to-emerald-950/30 shadow-[0_0_25px_rgba(16,185,129,0.3)]">
        <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-emerald-500/20 blur-3xl"></div>

        <div class="relative flex items-center justify-between border-b border-emerald-500/30 bg-slate-950/80 px-4 py-2">
          <div class="flex items-center gap-1.5">
            <span class="h-2.5 w-2.5 rounded-full bg-rose-500/80"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-amber-400/80"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"></span>
          </div>
          <p class="font-mono text-[11px] text-emerald-300">/ctf/ingreso_flag</p>
        </div>

        <div class="relative px-5 py-6 space-y-6 md:px-7">
          @if($yaCompleto)
            <!-- Mensaje de completado -->
            <div class="rounded-lg border border-emerald-500/50 bg-emerald-500/20 p-6 text-center">
              <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-emerald-300 mb-2">¡Evaluación Completada!</h3>
              <p class="text-sm text-emerald-200 mb-4">
                Ya resolviste correctamente esta evaluación. No puedes enviar más intentos.
              </p>
              @if($score)
                <p class="text-xs text-emerald-300/80 font-mono">
                  Puntaje obtenido: {{ number_format($score->puntaje, 2) }} ({{ number_format($score->porcentaje, 1) }}%)
                </p>
              @endif
              <div class="mt-6 flex gap-3 justify-center">
                <a href="{{ route('estudiante.evaluaciones.index') }}"
                  class="inline-flex justify-center rounded-lg bg-emerald-500 px-6 py-2 text-sm font-semibold text-slate-950 shadow hover:bg-emerald-400 transition">
                  Ver más evaluaciones
                </a>
                <a href="{{ route('estudiante.evaluaciones.show', $evaluacion->id_eval) }}"
                  class="inline-flex justify-center rounded-lg border border-emerald-500/50 px-6 py-2 text-sm font-semibold text-emerald-300 hover:bg-emerald-500/10 transition">
                  Ver detalles
                </a>
              </div>
            </div>
          @else
            <!-- Formulario normal -->
          <div class="rounded-lg border border-slate-800 bg-slate-950/60 p-4">
            <p class="font-mono text-[13px] text-slate-100 leading-relaxed">
                {{ $evaluacion->descripcion_eval ?? 'Analiza los recursos proporcionados y encuentra la respuesta correcta.' }}
            </p>
            
            @if($evaluacion->archivo_adjunto)
            <div class="mt-4 pt-4 border-t border-slate-800">
                <a href="{{ asset('storage/' . $evaluacion->archivo_adjunto) }}" target="_blank" 
                   class="inline-flex items-center gap-2 rounded-lg bg-emerald-500/10 px-4 py-2 text-xs font-medium text-emerald-400 hover:bg-emerald-500/20 transition border border-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Descargar Recurso del Reto
                </a>
            </div>
            @endif
          </div>

          <p class="font-mono text-xs text-emerald-300">
            &gt; ingresa tu respuesta con formato <span class="text-emerald-200">synapse{...}</span>
            <span class="animate-pulse">_</span>
          </p>

            @if (session('mensaje'))
                <div class="rounded-lg border {{ session('status') === 'correcta' ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-300' : 'border-rose-500/40 bg-rose-500/10 text-rose-300' }} px-4 py-2 text-xs font-mono">
                    {{ session('mensaje') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-rose-500/50 bg-rose-500/10 px-4 py-2 text-xs text-rose-200 font-mono">
                    {{ $errors->first('respuesta') }}
                </div>
            @endif


          <form action="{{ route('estudiante.intentos.store', $evaluacion->id_eval ?? $evaluacion->id) }}" method="POST" class="space-y-4" id="respuesta-form">
            @csrf
            <!-- Campo oculto para tracking de tiempo -->
            <input type="hidden" name="tiempo_inicio" id="tiempo-inicio" value="">
            <input type="hidden" name="latencia_segundos" id="latencia-segundos" value="">
            
            <div class="space-y-2">
              <input
                type="text"
                name="respuesta"
                placeholder="synapse{...}"
                  class="w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 font-mono text-sm text-slate-200 placeholder-slate-500 shadow-inner focus:border-emerald-400 focus:ring-emerald-400/30 focus:outline-none transition"
                  value="{{ old('respuesta') }}" />

              <p class="text-[11px] font-mono text-slate-500">
                Formato requerido: <span class="text-slate-300">respuesta_correcta</span>
              </p>
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-emerald-500/30 hover:bg-emerald-400 active:scale-[0.97] transition">
              Enviar respuesta
            </button>
          </form>

          {{-- Botón de SKIP solo para Calibración --}}
          @php
              $intentosCount = \App\Models\Intento::where('user_id', Auth::id())->count();
          @endphp
          @if($intentosCount < 5)
            <div class="mt-4 pt-4 border-t border-slate-800 text-center">
                <p class="text-[10px] text-slate-500 mb-2">MODO CALIBRACIÓN</p>
                <form action="{{ route('estudiante.calibracion.skip') }}" method="POST">
                    @csrf
                    <input type="hidden" name="evaluacion_id" value="{{ $evaluacion->id_eval }}">
                    <button type="submit" 
                            class="text-xs text-slate-400 hover:text-slate-200 underline decoration-slate-600 hover:decoration-slate-400 transition">
                        No sé la respuesta / Saltar pregunta
                    </button>
                </form>
            </div>
          @endif
          
          <script>
            // Registrar tiempo de inicio cuando se carga la página
            (function() {
              const tiempoInicio = Date.now();
              document.getElementById('tiempo-inicio').value = tiempoInicio;
              
              // Calcular latencia al enviar el formulario
              const form = document.getElementById('respuesta-form');
              if (form) {
                form.addEventListener('submit', function() {
                  const tiempoFin = Date.now();
                  const latenciaMs = tiempoFin - tiempoInicio;
                  const latenciaSegundos = Math.floor(latenciaMs / 1000);
                  document.getElementById('latencia-segundos').value = latenciaSegundos;
                });
              }
            })();
          </script>
            @endif
        </div>
      </section>

      <aside class="space-y-6">
        <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 shadow-lg">
          <h2 class="text-sm font-semibold text-slate-100 tracking-wide mb-3">
            Intentos recientes
          </h2>

          <ul class="space-y-2 text-xs">
            @forelse ($intentos as $intento)
                @php
                    $esCorrecto = (bool) $intento->es_correcto_int;
                    $resultadoTexto = $esCorrecto ? 'Correcto' : 'Incorrecto';
                    $resultadoColor = $esCorrecto ? 'text-emerald-400' : 'text-rose-400';
                @endphp
                <li class="flex items-center justify-between rounded-lg border border-slate-800 bg-slate-900/70 px-3 py-2">
                  <span class="font-mono text-slate-300">Intento #{{ $intento->nro_intento_int }} · {{ optional($intento->created_at)->format('H:i') }}</span>
                  <span class="font-mono {{ $resultadoColor }}">{{ $resultadoTexto }}</span>
                  <span class="font-mono text-slate-400">{{ $intento->latencia_seg_int ? $intento->latencia_seg_int . 's' : '--' }}</span>
                </li>
            @empty
                <li class="rounded-lg border border-dashed border-slate-800 bg-slate-900/40 px-3 py-4 text-center text-[11px] text-slate-500 font-mono">
                  Aún no registras intentos para este ejercicio.
                </li>
            @endforelse
          </ul>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 shadow-lg">
          <h2 class="text-sm font-semibold text-slate-100 tracking-wide mb-3">
            Tips del ejercicio
          </h2>

          <ul class="space-y-2 text-xs text-slate-400">
            <li class="flex items-start gap-2">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 mt-1"></span>
              Revisa patrones repetitivos o cadenas inusuales en los recursos.
            </li>

            <li class="flex items-start gap-2">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 mt-1"></span>
              Usa herramientas como strings, binwalk o Wireshark si aplica.
            </li>

            <li class="flex items-start gap-2">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 mt-1"></span>
              La respuesta siempre empieza con synapse{...}.
            </li>
          </ul>
        </div>

        <div class="space-y-1 text-xs text-slate-500 font-mono">
          <a href="{{ route('estudiante.evaluaciones.show', $evaluacion->id_eval ?? $evaluacion->id) }}" class="hover:text-slate-300 transition">
            &gt; Ver detalles del ejercicio
          </a>
          <br>
          <a href="{{ route('estudiante.evaluaciones.index') }}" class="hover:text-slate-300 transition">
            &gt; Volver a Evaluaciones
          </a>
        </div>
      </aside>
    </div>
  </div>
</div>
        </main>
        <div class="home-container5">
          <div class="home-container6">
            <style>
                      @keyframes pulse-glow {0%,100% {box-shadow: var(--shadow-level-2), 0 0 0 var(--color-primary);}
              50% {box-shadow: var(--shadow-level-2), 0 0 20px var(--color-primary);}}@keyframes float-morph {0% {transform: translateY(0) rotate(0deg);
              border-radius: --border-radius-md;}
              50% {transform: translateY(-12px) rotate(2deg);
              border-radius: --border-radius-xl;}
              100% {transform: translateY(0) rotate(0deg);
              border-radius: --border-radius-md;}}@keyframes hero-entrance {0% {opacity: 0;
              transform: translateY(20px);}
              100% {opacity: 1;
              transform: translateY(0);}}@keyframes card-morph {0% {opacity: 0;
              transform: scale(0.98);}
              100% {opacity: 1;
              transform: scale(1);}}@keyframes scanline-move {0% {transform: translateY(0);}
              100% {transform: translateY(8px);}}@keyframes pulse-entrance {0% {opacity: 0;
              transform: translateY(12px) scale(0.995);}
              60% {opacity: 1;
              transform: translateY(6px) scale(1.001);}
              100% {transform: translateY(0) scale(1);}}@keyframes glow-pulse {0% {box-shadow: --shadow-level-2;}
              100% {box-shadow: var(--shadow-level-2), 0 0 16px var(--color-accent);}}
            </style>
          </div>
        </div>
        <div class="home-container7">
          <div class="home-container8">
            <script defer="" data-name="homepage-interactions">
              document.addEventListener('DOMContentLoaded', function() {
                (function(){
                  // Menu Toggle
                  const menuToggle = document.getElementById("menu-toggle")
                  const dropdownMenu = document.getElementById("dropdown-menu")

                  if (menuToggle && dropdownMenu) {
                    menuToggle.addEventListener("click", function () {
                      const isExpanded = this.getAttribute("aria-expanded") === "true"
                      this.setAttribute("aria-expanded", !isExpanded)
                      dropdownMenu.classList.toggle("active")
                    })

                    // Close dropdown when clicking outside
                    document.addEventListener("click", function (event) {
                      if (
                        !menuToggle.contains(event.target) &&
                        !dropdownMenu.contains(event.target)
                      ) {
                        menuToggle.setAttribute("aria-expanded", "false")
                        dropdownMenu.classList.remove("active")
                      }
                    })
                  }

                  // Option Button Selection
                  const optionButtons = document.querySelectorAll(".option-btn")
                  const continueButton = document.querySelector(".onboard-content .btn")

                  if (optionButtons && continueButton) {
                  optionButtons.forEach((button) => {
                    button.addEventListener("click", function () {
                      // Deselect all options in the same group
                      const parent = this.parentElement
                      const siblings = parent.querySelectorAll(".option-btn")

                      siblings.forEach((sibling) => {
                        sibling.setAttribute("aria-pressed", "false")
                      })

                      // Select clicked option
                      this.setAttribute("aria-pressed", "true")

                      // Enable continue button
                      if (continueButton) {
                        continueButton.removeAttribute("disabled")
                      }
                    })
                  })
                  }

                  // Carousel Card Interactions
                  const carouselCards = document.querySelectorAll(".coverflow .card")

                  carouselCards.forEach((card, index) => {
                    card.addEventListener("click", function () {
                      // Remove featured class from all cards
                      carouselCards.forEach((c) => c.classList.remove("card-featured"))

                      // Add featured class to clicked card
                      this.focus(); // Simplemente enfocar la tarjeta
                    })
                  })

                  // Parallax Effect for Hero Banner
                  const heroBanner = document.querySelector(".hero-banner-backplate")

                  if (heroBanner) {
                    window.addEventListener("scroll", function () {
                      const scrolled = window.pageYOffset
                      const rate = scrolled * 0.1

                      if (rate <= window.innerHeight) {
                        heroBanner.style.transform = `translateX(-10%) translateY(${rate}px)`
                      }
                    })
                  }

                  // Smooth Entrance Animations on Scroll
                  const observerOptions = {
                    root: null,
                    rootMargin: "0px",
                    threshold: 0.1,
                  }

                  const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                      if (entry.isIntersecting) {
                        entry.target.style.opacity = "1"
                        entry.target.style.transform = "translateY(0)"
                      }
                    })
                  }, observerOptions)

                  const animatedElements = document.querySelectorAll(
                    ".card, .card-horizontal, .update-card"
                  )
                  animatedElements.forEach((el) => {
                    el.style.opacity = "0"
                    el.style.transform = "translateY(16px)"
                    el.style.transition = "opacity 0.6s ease, transform 0.6s ease"
                    observer.observe(el)
                  })

                  // Keyboard Navigation for Carousel
                  const coverflow = document.querySelector(".coverflow")

                  if (coverflow) {
                    coverflow.addEventListener("keydown", function (e) {
                      const cards = Array.from(this.querySelectorAll(".card"))
                      const focusedCard = document.activeElement
                      const currentIndex = cards.indexOf(focusedCard)

                      if (e.key === "ArrowRight" && currentIndex < cards.length - 1) {
                        e.preventDefault()
                        cards[currentIndex + 1].focus()
                      } else if (e.key === "ArrowLeft" && currentIndex > 0) {
                        e.preventDefault()
                        cards[currentIndex - 1].focus()
                      }
                    })

                    // Make cards keyboard focusable
                    carouselCards.forEach((card) => {
                      card.setAttribute("tabindex", "0")
                    })
                  }

                  // Update Progress Bar dynamically
                  const progressFill = document.querySelector(".progress-fill")
                  const progressLabel = document.querySelector(".progress-label")

                  function updateProgress(current, total) {
                    if (progressFill && progressLabel) {
                      const percentage = (current / total) * 100
                      progressFill.style.width = `${percentage}%`
                      progressLabel.textContent = `Pregunta ${current} de ${total}`

                      const progressBar = progressFill.parentElement
                      progressBar.setAttribute("aria-valuenow", percentage)
                    }
                  }

                  // Initialize progress
                  updateProgress(1, 6)
                })()
              });
            </script>
          </div>
        </div>
        @include('layouts.partials.footer_estudiante')
      </div>
      <link
        rel="canonical"
        href="https://experienced-enlightened-nightingale-4x499e.teleporthq.app/"
      />
    </div>
  </body>
</html>
