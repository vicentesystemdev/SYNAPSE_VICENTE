<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Seguridad Web: Fundamentos y Análisis Práctico</title>
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
        <section class="section-spacing section-container">
            <div class="section-header">
                <h2 class="section-title glitch" data-text="Seguridad Web: Fundamentos y Análisis Práctico">
                    Seguridad Web: Fundamentos y Análisis Práctico
                </h2>
                <p class="section-subtitle">
                    Comprende cómo se construyen, se atacan y se defienden las aplicaciones modernas.
                  </p>
                </div>
            <div class="content-grid">
                <!-- Sección 1: Rutas expuestas -->
                <section class="info-section info-with-image-left">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/1Web.jpg') }}" alt="Redes y código seguro" class="info-image" loading="lazy" />
              </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                            </svg> Rutas expuestas y parámetros inseguros
                        </h3>
                        <p class="info-body"> Una aplicación mal configurada puede exponer endpoints sensibles como
                            <code>/admin</code>, IDs secuenciales (<code>?user_id=123</code>), o permitir inyección en
                            parámetros GET/POST. Esto facilita ataques de enumeración y escalada de privilegios. </p>
            </div>
          </section>
                <!-- Sección 2: Inspección manual -->
                <section class="info-section info-with-image-right">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/2Web.jpg') }}" alt="Herramientas de desarrollo del navegador" class="info-image" loading="lazy" />
              </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg> Inspección manual y análisis con navegador
                        </h3>
                        <p class="info-body"> Usa las DevTools: revisa el código fuente, la pestaña <em>Network</em> para
                            peticiones ocultas, headers sensibles, cookies sin <code>HttpOnly</code> o <code>Secure</code>,
                            y respuestas con información de servidor (como <code>X-Powered-By</code>). </p>
            </div>
          </section>
                <!-- Sección 3: Fallos comunes -->
                <section class="info-section info-with-image-left">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/3Web.png') }}" alt="Terminal con código vulnerable" class="info-image" loading="lazy" />
              </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg> Fallos comunes en aplicaciones reales
                        </h3>
                        <ul class="info-list">
                            <li>ID Enumeration (IDs predecibles)</li>
                            <li>Exposición de rutas internas (e.g., <code>/backup.zip</code>)</li>
                            <li>Falta de sanitización  XSS o inyecciones</li>
                            <li>Archivos sensibles accesibles (e.g., <code>.env</code>, <code>config.php~</code>)</li>
                        </ul>
            </div>
          </section>
                <!-- Sección 4: Synapse CTF -->
                <section class="info-section info-with-image-right">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/CTF.webp') }}" alt="Competencia de CTF ciberseguridad" class="info-image" loading="lazy" />
              </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg> Importancia dentro de Synapse CTF
                        </h3>
                        <p class="info-body"> Los retos <strong>WEB</strong> entrenan pensamiento crítico, análisis de flujo
                            HTTP, manipulación de parámetros y reconocimiento de patrones de vulnerabilidad  habilidades
                            esenciales para pentesters y desarrolladores seguros. </p>
            </div>
          </section>
            </div>
          </section>
        </main>

    <footer-wrapper class="footer-wrapper">
          <!--Footer component-->
          <div class="footer-container1">
            <div class="footer-container2">
              <div class="footer-container3">
                <style>
                  @media (prefers-reduced-motion: reduce) {
                    .footer-grid-bg, .footer-glow-orb, .footer-divider-glow, .footer-newsletter::before {
                      animation: none;
                    }
                    .footer-social-link, .footer-nav-link, .footer-back-to-top {
                      transition: none;
                    }
                  }
                </style>
              </div>
            </div>
            <footer id="footer-main" class="footer">
              <div class="footer-container">
                <div class="footer-grid-bg"></div>
                <div class="footer-glow-orb footer-glow-orb-1"></div>
                <div class="footer-glow-orb footer-glow-orb-2"></div>
                <div class="footer-content">
                  <div class="footer-brand-section">
                    <div class="footer-logo-wrapper">
                      <span class="footer-logo-text footer-logo-uni">
                        UNIFRANZ
                      </span>
                      <span class="footer-logo-divider"></span>
                      <span class="footer-logo-text footer-logo-synapse">
                        SYNAPSE
                      </span>
                    </div>
                    <p class="footer-tagline">
                      Innovación digital para el futuro
                    </p>
                    <div class="footer-social-links">
                      <a href="#">
                        <div aria-label="Facebook" class="footer-social-link">
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
                              d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                            ></path>
                          </svg>
                        </div>
                      </a>
                      <a href="#">
                        <div aria-label="Twitter" class="footer-social-link">
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
                              d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6c2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4c-.9-4.2 4-6.6 7-3.8c1.1 0 3-1.2 3-1.2"
                            ></path>
                          </svg>
                        </div>
                      </a>
                      <a href="#">
                        <div aria-label="LinkedIn" class="footer-social-link">
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
                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2a2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6M2 9h4v12H2z"
                              ></path>
                              <circle cx="4" cy="4" r="2"></circle>
                            </g>
                          </svg>
                        </div>
                      </a>
                      <a href="#">
                        <div aria-label="Instagram" class="footer-social-link">
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
                              <rect
                                width="20"
                                height="20"
                                x="2"
                                y="2"
                                rx="5"
                                ry="5"
                              ></rect>
                              <path
                                d="M16 11.37A4 4 0 1 1 12.63 8A4 4 0 0 1 16 11.37m1.5-4.87h.01"
                              ></path>
                            </g>
                          </svg>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="footer-nav-section">
                    <div class="footer-nav-column">
                      <h3 class="footer-nav-title">Categorías CTF</h3>
                      <ul class="footer-nav-list">
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.web.info') }}">
                            <div class="footer-nav-link">
                              <span>Seguridad Web</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.crypto.info') }}">
                            <div class="footer-nav-link">
                              <span>Criptografía</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.stego.info') }}">
                            <div class="footer-nav-link">
                              <span>Esteganografía</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.forens.info') }}">
                            <div class="footer-nav-link">
                              <span>Análisis Forense</span>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="footer-nav-column">
                      <h3 class="footer-nav-title">Recursos</h3>
                      <ul class="footer-nav-list">
                        <li class="footer-nav-item">
                        <a href="{{ route('estudiante.informacion.documentacion') }}">
                            <div class="footer-nav-link">
                              <span>Documentación</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.manual_estudiante') }}">
                            <div class="footer-nav-link">
                              <span>Manual del Estudiante</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.manual_docente') }}">
                            <div class="footer-nav-link">
                              <span>Manual del Docente</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.politicas_evaluacion') }}">
                            <div class="footer-nav-link">
                              <span>Políticas de Evaluación</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.preguntas_frecuentes') }}">
                            <div class="footer-nav-link">
                              <span>Preguntas Frecuentes</span>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="footer-nav-column">
                      <h3 class="footer-nav-title">Synapse CTF</h3>
                      <ul class="footer-nav-list">
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.sobre_proyecto') }}">
                            <div class="footer-nav-link">
                              <span>Sobre el Proyecto</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.proposito_academico') }}">
                            <div class="footer-nav-link">
                              <span>Propósito Académico</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.modelo_evaluacion_adaptativa') }}">
                            <div class="footer-nav-link">
                              <span>Modelo de Evaluación Adaptativa</span>
                            </div>
                          </a>
                        </li>
                        <li class="footer-nav-item">
                          <a href="{{ route('estudiante.informacion.metodologia_referencias') }}">
                            <div class="footer-nav-link">
                              <span>Metodología y Referencias</span>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="footer-contact-section">
                    <h3 class="footer-nav-title">Contacto</h3>
                    <div class="footer-contact-items">
                      <div class="footer-contact-item">
                        <div class="footer-contact-icon">
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
                                d="m22 7l-8.991 5.727a2 2 0 0 1-2.009 0L2 7"
                              ></path>
                              <rect
                                width="20"
                                height="16"
                                x="2"
                                y="4"
                                rx="2"
                              ></rect>
                            </g>
                          </svg>
                        </div>
                        <a href="mailto:contact@unifranzsynapse.com?subject=">
                          <div class="footer-contact-link">
                            <span>contact@unifranzsynapse.com</span>
                          </div>
                        </a>
                      </div>
                      <div class="footer-contact-item">
                        <div class="footer-contact-icon">
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
                                d="M17.97 9.304A8 8 0 0 0 2 10c0 4.69 4.887 9.562 7.022 11.468m12.356-4.842a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"
                              ></path>
                              <circle cx="10" cy="10" r="3"></circle>
                            </g>
                          </svg>
                        </div>
                        <span class="footer-contact-text">La Paz, Bolivia</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="footer-bottom">
                  <div class="footer-bottom-content">
                    <p class="footer-copyright">
                       2025 Unifranz Synapse. Todos los derechos reservados.
                    </p>
                    <div class="footer-legal-links">
                      <a href="#">
                        <div class="footer-legal-link">
                          <span>Privacidad</span>
                        </div>
                      </a>
                      <span class="footer-legal-divider"></span>
                      <a href="#">
                        <div class="footer-legal-link">
                          <span>Términos</span>
                        </div>
                      </a>
                      <span class="footer-legal-divider"></span>
                      <a href="#">
                        <div class="footer-legal-link">
                          <span>Cookies</span>
                        </div>
                      </a>
                    </div>
                  </div>
                  <button
                    id="backToTop"
                    aria-label="Volver arriba"
                    class="footer-back-to-top"
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
                        d="m5 12l7-7l7 7m-7 7V5"
                      ></path>
                    </svg>
                  </button>
                </div>
              </div>
            </footer>
            <div class="footer-container4">
              <div class="footer-container5">
                <style>
                  @keyframes footer-grid-move {
                    0% { transform: translate(0, 0); }
                    100% { transform: translate(50px, 50px); }
                  }
                  @keyframes footer-glow-pulse {
                    0%, 100% { opacity: 0.1; transform: scale(1); }
                    50% { opacity: 0.2; transform: scale(1.2); }
                  }
                  @keyframes footer-divider-glow {
                    0%, 100% { box-shadow: 0 0 10px var(--color-primary); }
                    50% { box-shadow: 0 0 20px var(--color-primary), 0 0 30px var(--color-primary); }
                  }
                  @keyframes footer-newsletter-scan {
                    0% { left: -100%; }
                    100% { left: 100%; }
                  }
                </style>
              </div>
            </div>
            <div class="footer-container6">
              <div class="footer-container7">
                <script defer="" data-name="footer">
                  document.addEventListener('DOMContentLoaded', function() {
                    (function(){
                      // Back to Top Button Functionality
                      const backToTopBtn = document.getElementById("backToTop")

                      if (backToTopBtn) {
                        // Show/hide button based on scroll position
                        const handleScroll = () => {
                          if (window.pageYOffset > 300) {
                            backToTopBtn.classList.add("footer-visible")
                          } else {
                            backToTopBtn.classList.remove("footer-visible")
                          }
                        }

                        window.addEventListener("scroll", handleScroll, { passive: true })

                        // Scroll to top functionality
                        backToTopBtn.addEventListener("click", () => {
                          window.scrollTo({
                            top: 0,
                            behavior: "smooth",
                          })
                        })
                      }

                      // Newsletter form submission
                      const newsletterForm = document.querySelector(".footer-newsletter-form")

                      if (newsletterForm) {
                        newsletterForm.addEventListener("submit", (e) => {
                          e.preventDefault()
                          const emailInput = newsletterForm.querySelector(
                            ".footer-newsletter-input"
                          )
                          const email = emailInput.value

                          // Add your newsletter submission logic here
                          console.log("Newsletter subscription:", email)

                          // Show success feedback
                          const originalBtnHTML = newsletterForm.querySelector(
                            ".footer-newsletter-btn"
                          ).innerHTML
                          newsletterForm.querySelector(".footer-newsletter-btn").innerHTML =
                            '<span style="font-size: 12px;"></span>'

                          setTimeout(() => {
                            newsletterForm.querySelector(".footer-newsletter-btn").innerHTML =
                              originalBtnHTML
                            emailInput.value = ""
                          }, 2000)
                        })
                      }

                      // Add glowing effect on hover for social links
                      const socialLinks = document.querySelectorAll(".footer-social-link")
                      socialLinks.forEach((link) => {
                        link.addEventListener("mouseenter", () => {
                          link.style.filter = "drop-shadow(0 0 12px var(--color-primary))"
                        })

                        link.addEventListener("mouseleave", () => {
                          link.style.filter = "none"
                        })
                      })
                    })()
                  });
                </script>
              </div>
            </div>
          </div>
        </footer-wrapper>
  </body>
</html>
