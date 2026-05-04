<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Historial de Intentos - Synapse Evaluación lógico-matemática</title>
    <meta property="og:title" content="Historial de Intentos - Synapse Evaluación lógico-matemática" />
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
<div class="w-full bg-slate-950 text-slate-100 px-4 py-10">
  <div class="mx-auto max-w-6xl space-y-8">
    <header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div class="space-y-1">
        <h1 class="text-3xl font-extrabold tracking-tight text-white">
          Historial de intentos
        </h1>
        <p class="text-sm text-slate-400">
          Revisa tus últimos resultados y el progreso en cada evaluación Evaluación lógico-matemática.
        </p>
      </div>

      <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold text-emerald-300 border border-emerald-500/40">
        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
        Tus últimos resultados
      </span>
    </header>

    <section class="rounded-2xl border border-slate-800 bg-slate-900/70 shadow-lg">
      <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-slate-100 tracking-wide">
          Intentos recientes
        </h2>
        <p class="text-[11px] font-mono text-slate-500">
          Ordenado por fecha descendente
        </p>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-800">
          <thead class="bg-slate-950/60">
            <tr class="text-xs font-semibold uppercase tracking-wide text-slate-400">
              <th scope="col" class="px-4 py-3 text-left font-mono">#</th>
              <th scope="col" class="px-4 py-3 text-left font-mono">Fecha</th>
              <th scope="col" class="px-4 py-3 text-left font-mono">Área</th>
              <th scope="col" class="px-4 py-3 text-left font-mono">Ejercicio</th>
              <th scope="col" class="px-4 py-3 text-left font-mono">Resultado</th>
              <th scope="col" class="px-4 py-3 text-left font-mono">Tiempo</th>
              <th scope="col" class="px-4 py-3 text-right font-mono">Acción</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-800 bg-slate-950/40 text-xs">
            @forelse ($intentos as $intento)
                @php
                    $eval = $intento->evaluacion;
                    $categoriaModel = optional($eval->categoria);
                    $categoria = strtoupper($categoriaModel->codigo_cat ?? $categoriaModel->nombre_cat ?? 'N/A');
                    $titulo = $eval->titulo_eval ?? 'Sin título';
                    $correcto = (bool) $intento->es_correcto_int;
                    $claseResultado = $correcto
                        ? 'inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-1 text-[11px] font-semibold text-emerald-300 border border-emerald-500/40'
                        : 'inline-flex items-center rounded-full bg-rose-500/10 px-2.5 py-1 text-[11px] font-semibold text-rose-300 border border-rose-500/40';
                    $resultadoTexto = $correcto ? 'Correcto' : 'Incorrecto';
                    $fecha = optional($intento->created_at)->format('Y-m-d H:i') ?? '--';
                    $tiempo = $intento->latencia_seg_int ? $intento->latencia_seg_int . 's' : '--';
                    $rowNumber = $loop->iteration + ($intentos->currentPage() - 1) * $intentos->perPage();
                @endphp
                <tr class="hover:bg-slate-900/70 transition">
                  <td class="whitespace-nowrap px-4 py-3 font-mono text-slate-300">
                    {{ $rowNumber }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 font-mono text-slate-300">
                    {{ $fecha }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3">
                    <span class="inline-flex items-center rounded-full bg-slate-900 px-2 py-1 text-[11px] font-semibold text-emerald-300">
                    {{ $categoria }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-slate-200">
                    {{ $titulo }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3">
                    <span class="{{ $claseResultado }}">
                      {{ $resultadoTexto }}
                    </span>
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 font-mono text-slate-300">
                    {{ $tiempo }}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 text-right">
                    <a href="{{ route('estudiante.evaluaciones.show', $eval->id_eval ?? $eval->id ?? null) }}"
                      class="inline-flex items-center rounded-lg bg-slate-800 px-3 py-1.5 text-[11px] font-semibold text-slate-100 hover:bg-slate-700 hover:text-white transition">
                      Ver reto
                    </a>
                  </td>
                </tr>
            @empty
                <tr>
                  <td colspan="7" class="px-4 py-6 text-center text-[11px] text-slate-500 font-mono">
                    No tienes intentos registrados aún.
                  </td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="flex flex-col items-start justify-between gap-2 border-t border-slate-800 px-4 py-3 text-[11px] text-slate-500 sm:flex-row sm:items-center">
        <p class="font-mono">
          Mostrando {{ $intentos->count() }} de {{ $intentos->total() }} intentos
        </p>
        <div class="text-slate-300">
          {{ $intentos->links() }}
        </div>
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
