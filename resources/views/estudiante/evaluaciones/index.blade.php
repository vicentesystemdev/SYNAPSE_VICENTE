<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Synapse Evaluación lógico-matemática — La Evolución de las Evaluaciones en Ciberseguridad</title>
    <meta property="og:title" content="Synapse Evaluación lógico-matemática — La Evolución de las Evaluaciones en Ciberseguridad" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta property="twitter:card" content="summary_large_image" />

    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;  -webkit-font-smoothing: antialiased;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type="button"],[type="reset"],[type="submit"] {  -webkit-appearance: button;  color: inherit;}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type="button"]:-moz-focus,[type="reset"]:-moz-focus,[type="submit"]:-moz-focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}pre {  white-space: normal;}input {  padding: 2px 4px;}img {  display: block;}details {  display: block;  margin: 0;  padding: 0;}summary::-webkit-details-marker {  display: none;}[data-thq="accordion"] [data-thq="accordion-content"] {  max-height: 0;  overflow: hidden;  transition: max-height 0.3s ease-in-out;  padding: 0;}[data-thq="accordion"] details[data-thq="accordion-trigger"][open] + [data-thq="accordion-content"] {  max-height: 1000vh;}details[data-thq="accordion-trigger"][open] summary [data-thq="accordion-icon"] {  transform: rotate(180deg);}html { scroll-behavior: smooth  }
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                    aria-label="Unifranz Synapse Homepage"
                    class="navigation-logo"
                  >
                    <span class="navigation-logo-left">unifranz</span>
                    <span class="navigation-logo-divider"></span>
                    <span class="navigation-logo-right">synapse</span>
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
              <span class="brand-right">synapse</span>
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
// Mapear nivel a texto y color
$nivelLabels = [
    'bajo' => ['text' => 'Básico', 'color' => 'bg-amber-900/50 text-amber-300'],
    'medio' => ['text' => 'Medio', 'color' => 'bg-emerald-900/40 text-emerald-300'],
    'alto' => ['text' => 'Avanzado', 'color' => 'bg-blue-900/50 text-blue-300'],
];

// Asegurar que existe el array de niveles (por si no se pasó desde el controlador)
$nivelesPorCategoria = $nivelesPorCategoria ?? [];

// Calcular niveles para cada área (evitar problemas de sintaxis)
$nivelWeb = $nivelesPorCategoria['WEB'] ?? 'medio';
$nivelCrypto = $nivelesPorCategoria['CRYPTO'] ?? 'medio';
$nivelStego = $nivelesPorCategoria['STEGO'] ?? 'medio';
$nivelForens = $nivelesPorCategoria['FORENS'] ?? 'medio';
@endphp

<div class="w-full bg-slate-950 text-slate-100 px-4 py-12 md:px-6">
  <div class="mx-auto max-w-6xl space-y-12">
    @if (session('status'))
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    <!-- HERO IMPACTANTE -->
    <section
      class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-950 to-indigo-950 px-6 py-10 md:px-12 md:py-14 shadow-2xl">
      <!-- Glows decorativos -->
      <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-indigo-500/30 blur-3xl"></div>
      <div class="pointer-events-none absolute -left-10 bottom-0 h-40 w-40 rounded-full bg-cyan-400/20 blur-3xl"></div>

      <div class="relative grid gap-10 md:grid-cols-2 md:items-center">
        <!-- Texto -->
        <div class="space-y-4">
          <p class="text-xs font-semibold tracking-[0.35em] text-indigo-300 uppercase">
            Synapse Evaluación lógico-matemática
          </p>

          <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
            Practica como en un torneo Evaluación lógico-matemática real.
          </h1>

          <p class="text-sm md:text-base text-slate-300 max-w-md">
            Activa la <span class="font-semibold text-indigo-200">ruta adaptativa recomendada</span>:
            Synapse analiza tu desempeño, elige área, ajusta dificultad
            y te envía directo al siguiente ejercicio ideal para ti.
          </p>

          <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
            <a href="{{ route('estudiante.evaluaciones.adaptativa.siguiente') }}"
              class="inline-flex justify-center rounded-xl bg-indigo-500 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/40 hover:bg-indigo-400 hover:shadow-indigo-400/60 active:scale-[0.97] transition-transform transition-shadow duration-300 ease-out">
              Obtener siguiente evaluación
            </a>

            <a href="{{ route('estudiante.evaluaciones.categorias') }}"
              class="inline-flex justify-center rounded-xl border border-slate-600 px-5 py-3 text-sm font-medium text-slate-100 hover:border-slate-300 hover:bg-slate-900/70 active:scale-[0.97] transition-all duration-300 ease-out">
              Ver áreas de práctica
            </a>
          </div>
        </div>

        <!-- Imagen estilo gaming -->
        <div class="relative h-56 md:h-64 lg:h-72">
          <div
            class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500/40 via-slate-900/60 to-cyan-400/30 blur-2xl group-hover:blur-3xl transition">
          </div>

          <div
            class="relative h-full w-full overflow-hidden rounded-2xl border border-slate-700/80 bg-slate-900/80 shadow-2xl transform-gpu transition-all duration-500 ease-out hover:-translate-y-1 hover:shadow-[0_0_45px_rgba(129,140,248,0.7)]">
            <img
              src="{{ asset('images/hero/adaptativo.png') }}"
              alt="Ilustración de ejercicios Evaluación lógico-matemática"
              class="h-full w-full object-cover opacity-80 hover:opacity-100 transition-opacity duration-500" />

            <div
              class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-slate-950/70 via-transparent to-indigo-500/40 mix-blend-screen">
            </div>

            <div class="absolute bottom-4 left-4 space-y-1">
              <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">
                Ruta adaptativa
              </p>
              <p class="text-sm font-medium text-slate-100">
                Motor IRT + Markov seleccionando tu próximo reto.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECCIÓN CATEGORÍAS -->
    <section class="space-y-4">
      <div class="text-center md:text-left">
        <h2 class="text-2xl font-bold text-white">Practicar por área</h2>
        <p class="text-sm text-slate-400 max-w-xl">
          Enfócate en el tipo de ejercicio que quieras mejorar. La dificultad seguirá siendo adaptativa dentro de cada área.
        </p>
      </div>

      <!-- GRID DE CATEGORÍAS -->
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

        <!-- WEB -->
        <article
          class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500/70 hover:shadow-2xl hover:shadow-indigo-500/30">
          <div class="relative h-40 w-full overflow-hidden">
            <img
              src="{{ asset('images/categorias/web.jpeg') }}"
              alt="Retos web"
              class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent"></div>
          </div>

          <div class="p-6 space-y-3">
            <span class="inline-block text-[11px] font-semibold px-2 py-1 bg-slate-800 text-slate-300 rounded uppercase tracking-wide">
              Área
            </span>

            <h3 class="text-lg font-semibold text-white tracking-tight">WEB</h3>

            <p class="text-sm text-slate-400">
              Vulnerabilidades de aplicaciones web: autenticación, inyección, sesiones y lógica de negocio.
            </p>

            <span
              class="inline-block text-[11px] font-medium px-2 py-1 {{ $nivelLabels[$nivelWeb]['color'] }} rounded">
              Nivel actual: {{ $nivelLabels[$nivelWeb]['text'] }}
            </span>

            <div class="flex justify-end pt-2">
              <a href="{{ route('estudiante.evaluaciones.por_categoria', 'web') }}"
                class="inline-flex justify-center rounded-lg bg-indigo-500 px-4 py-2 text-xs font-semibold text-white shadow hover:bg-indigo-400 hover:shadow-indigo-400/60 active:scale-[0.97] transition-all duration-300 ease-out">
                Practicar
              </a>
            </div>
          </div>
        </article>

        <!-- CRYPTO -->
        <article
          class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500/70 hover:shadow-2xl hover:shadow-indigo-500/30">
          <div class="relative h-40 w-full overflow-hidden">
            <img
              src="{{ asset('images/categorias/crypto.jpg') }}"
              alt="Retos de criptografía"
              class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent"></div>
          </div>

          <div class="p-6 space-y-3">
            <span class="inline-block text-[11px] font-semibold px-2 py-1 bg-slate-800 text-slate-300 rounded uppercase tracking-wide">
              Área
            </span>

            <h3 class="text-lg font-semibold text-white tracking-tight">CRYPTO</h3>

            <p class="text-sm text-slate-400">
              Desafíos de cifrados, hashes, claves y análisis criptográfico aplicado a escenarios Evaluación lógico-matemática.
            </p>

            <span
              class="inline-block text-[11px] font-medium px-2 py-1 {{ $nivelLabels[$nivelCrypto]['color'] }} rounded">
              Nivel actual: {{ $nivelLabels[$nivelCrypto]['text'] }}
            </span>

            <div class="flex justify-end pt-2">
              <a href="{{ route('estudiante.evaluaciones.por_categoria', 'crypto') }}"
                class="inline-flex justify-center rounded-lg bg-indigo-500 px-4 py-2 text-xs font-semibold text-white shadow hover:bg-indigo-400 hover:shadow-indigo-400/60 active:scale-[0.97] transition-all duration-300 ease-out">
                Practicar
              </a>
            </div>
          </div>
        </article>

        <!-- STEGO -->
        <article
          class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500/70 hover:shadow-2xl hover:shadow-indigo-500/30">
          <div class="relative h-40 w-full overflow-hidden">
            <img
              src="{{ asset('images/categorias/stego.jpg') }}"
              alt="Retos de esteganografía"
              class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent"></div>
          </div>

          <div class="p-6 space-y-3">
            <span class="inline-block text-[11px] font-semibold px-2 py-1 bg-slate-800 text-slate-300 rounded uppercase tracking-wide">
              Área
            </span>

            <h3 class="text-lg font-semibold text-white tracking-tight">STEGO</h3>

            <p class="text-sm text-slate-400">
              Mensajes ocultos en imágenes, audio y archivos. Aprende a detectarlos y extraer la respuesta.
            </p>

            <span
              class="inline-block text-[11px] font-medium px-2 py-1 {{ $nivelLabels[$nivelStego]['color'] }} rounded">
              Nivel actual: {{ $nivelLabels[$nivelStego]['text'] }}
            </span>

            <div class="flex justify-end pt-2">
              <a href="{{ route('estudiante.evaluaciones.por_categoria', 'stego') }}"
                class="inline-flex justify-center rounded-lg bg-indigo-500 px-4 py-2 text-xs font-semibold text-white shadow hover:bg-indigo-400 hover:shadow-indigo-400/60 active:scale-[0.97] transition-all duration-300 ease-out">
                Practicar
              </a>
            </div>
          </div>
        </article>

        <!-- FORENS -->
        <article
          class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/50 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-indigo-500/70 hover:shadow-2xl hover:shadow-indigo-500/30">
          <div class="relative h-40 w-full overflow-hidden">
            <img
              src="{{ asset('images/categorias/forens.jpg') }}"
              alt="Retos forense"
              class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-500" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent"></div>
          </div>

          <div class="p-6 space-y-3">
            <span class="inline-block text-[11px] font-semibold px-2 py-1 bg-slate-800 text-slate-300 rounded uppercase tracking-wide">
              Área
            </span>

            <h3 class="text-lg font-semibold text-white tracking-tight">FORENS</h3>

            <p class="text-sm text-slate-400">
              Análisis de discos, capturas de red y metadatos para reconstruir qué ocurrió y encontrar la respuesta.
            </p>

            <span
              class="inline-block text-[11px] font-medium px-2 py-1 {{ $nivelLabels[$nivelForens]['color'] }} rounded">
              Nivel actual: {{ $nivelLabels[$nivelForens]['text'] }}
            </span>

            <div class="flex justify-end pt-2">
              <a href="{{ route('estudiante.evaluaciones.por_categoria', 'forens') }}"
                class="inline-flex justify-center rounded-lg bg-indigo-500 px-4 py-2 text-xs font-semibold text-white shadow hover:bg-indigo-400 hover:shadow-indigo-400/60 active:scale-[0.97] transition-all duration-300 ease-out">
                Practicar
              </a>
            </div>
          </div>
        </article>

      </div>
    </section>

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
