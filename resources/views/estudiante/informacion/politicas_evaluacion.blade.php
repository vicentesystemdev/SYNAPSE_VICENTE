<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Políticas de Evaluación</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/estudiante_dashbord/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/estudiante_dashbord/index.css') }}" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
      data-tag="font"
    />
    <style>
        body {
            font-family: Montserrat;
            font-size: 1.05rem;
            background: transparent !important;
            color: var(--color-on-surface);
        }
        /* Custom styles for info pages */
        .info-page-section {
            padding: 4rem 2rem;
            max-width: 960px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            color: #e0e0e0;
        }
        .info-page-section h2 {
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .info-page-section h3 {
            font-size: 1.8rem;
            color: var(--color-accent);
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(var(--color-accent-rgb), 0.5);
            padding-bottom: 0.5rem;
        }
        .info-page-section p, .info-page-section ul {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .info-page-section ul {
            list-style: disc;
            margin-left: 1.5rem;
        }
        .info-page-section ul li {
            margin-bottom: 0.5rem;
        }
        .info-page-section .glitch {
            font-size: 3rem;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <video autoplay muted loop id="background-video" class="background-video">
      <source src="{{ asset('images/Fondo2.mp4') }}" type="video/mp4">
      Tu navegador no soporta el elemento de video.
    </video>

    <!-- Header del Dashboard -->
    <navigation-wrapper class="navigation-wrapper">
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
                        <div aria-label="Unifranz Synapse Homepage" class="navigation-logo">
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
                    </div>
                    <div class="navigation-user-menu">
                        <button id="navigation-user-toggle" aria-expanded="false" aria-haspopup="true" class="navigation-user-button">
                            <span class="navigation-navigation-user-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                            </span>
                            <span class="navigation-navigation-user-chevron">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m18 15l-6-6l-6 6"></path>
                                </svg>
                            </span>
                        </button>
                        <div id="navigation-user-dropdown" aria-hidden="true" class="navigation-user-dropdown">
                            <a href="{{ route('profile.edit') }}">
                                <div class="navigation-dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </g>
                                    </svg>
                                    <span>Perfil</span>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="navigation-dropdown-item navigation-dropdown-item-logout">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"></path>
                                                <path d="M9 12h12l-3-3m0 6l3-3"></path>
                                            </g>
                                        </svg>
                                        <span>Cerrar Sesión</span>
                                    </div>
                                </a>
                            </form>
                        </div>
                    </div>
                    <button id="navigation-mobile-toggle" aria-expanded="false" aria-label="Toggle mobile menu" class="navigation-mobile-toggle">
                        <span class="navigation-navigation-mobile-icon1 navigation-mobile-icon-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5h16M4 12h16M4 19h16"></path>
                            </svg>
                        </span>
                        <span class="navigation-navigation-mobile-icon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18M6 6l12 12"></path>
                            </svg>
                        </span>
                    </button>
                </div>
                <div id="navigation-mobile-menu" aria-hidden="true" class="navigation-mobile-menu">
                    <div class="navigation-mobile-links">
                        <div class="navigation-mobile-divider"></div>
                        <a href="{{ route('profile.edit') }}">
                            <div class="navigation-mobile-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                                <span>Perfil</span>
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="navigation-mobile-link navigation-mobile-link-logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <path d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2"></path>
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

    <main id="main-content" class="main-content">
        <section class="info-page-section">
            <h2 class="section-title glitch" data-text="Políticas de Evaluación">
                Políticas de Evaluación
            </h2>
            <h3>Cálculo del Puntaje</h3>
<ul>
    <li>El puntaje considera:
        <ul>
            <li>Correctitud</li>
            <li>Tiempo de respuesta</li>
            <li>Penalizaciones por repetición</li>
            <li>Nivel dinámico del reto</li>
        </ul>
    </li>
</ul>
<h3>Reglas Generales</h3>
<ul>
    <li>Las flags son personales</li>
    <li>No compartir soluciones</li>
    <li>No manipular tráfico del sistema</li>
    <li>No usar herramientas automatizadas destructivas</li>
</ul>
<h3>Adaptación de Dificultad</h3>
<p>
    El sistema ajusta automáticamente la dificultad según desempeño.
</p>
        </section>
    </main>
    @include('layouts.partials.footer_estudiante')
  </body>
</html>
