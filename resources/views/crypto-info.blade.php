<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Criptografía Práctica para CTF</title>
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
                <h2 class="section-title glitch" data-text="Criptografía Práctica para CTF">
                    Criptografía Práctica para CTF
                </h2>
                <p class="section-subtitle">
                    Aprende a reconocer patrones, descifrar transformaciones y automatizar procesos.
                </p>
            </div>

            <div class="content-grid">
                <!-- Sección 1: Transformaciones básicas -->
                <section class="info-section info-with-image-left">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/1Crypto.jpg') }}" alt="Transformaciones básicas de criptografía" class="info-image" loading="lazy" />
                    </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg> Transformaciones básicas
                        </h3>
                        <p class="info-body"> Desde Base64 y hexadecimal hasta rotaciones simples como ROT13, estas son las
                            piezas fundamentales. Aprender a identificarlas y convertirlas es el primer paso para
                            descifrar mensajes más complejos. </p>
                    </div>
                </section>
                <!-- Sección 2: Cifrados clásicos -->
                <section class="info-section info-with-image-right">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/2Crypto.jpg') }}" alt="Cifrado clásico Vigenère" class="info-image" loading="lazy" />
                    </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 9V5c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-4m0-4l4 4m0-4l-4 4" />
                            </svg> Cifrados clásicos
                        </h3>
                        <p class="info-body"> Cifrados como Vigenère, XOR y los basados en desplazamiento (shift-ciphers)
                            son recurrentes. Entender su lógica y cómo se utilizan las claves repetitivas o efímeras es
                            crucial para el criptoanálisis. </p>
                    </div>
                </section>
                <!-- Sección 3: Identificación de patrones -->
                <section class="info-section info-with-image-left">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/3Crypto.jpg') }}" alt="Patrones en datos cifrados" class="info-image" loading="lazy" />
                    </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 17l10-12 10 12" />
                                <path d="M12 3v18" />
                                <path d="M3.5 17h17" />
                            </svg> Identificación de patrones
                        </h3>
                        <p class="info-body"> Los datos cifrados a menudo revelan patrones si sabes dónde buscar:
                            repeticiones, distribuciones anómalas de caracteres o comportamientos específicos de XOR pueden
                            ser la clave para encontrar la vulnerabilidad. </p>
                    </div>
                </section>
                <!-- Sección 4: Scripting en retos CRYPTO -->
                <section class="info-section info-with-image-right">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/4Crypto.jpg') }}" alt="Scripting para criptografía" class="info-image" loading="lazy" />
                    </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 18h2a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2h2" />
                                <path d="M11 18v-6a1 1 0 011-1h0a1 1 0 011 1v6" />
                                <path d="M13 14h-2" />
                            </svg> Scripting en retos CRYPTO
                        </h3>
                        <p class="info-body"> Usar pequeños scripts (preferiblemente en Python) para automatizar el
                            descifrado de un gran número de posibles claves o realizar ataques de fuerza bruta es una
                            habilidad que te dará una ventaja significativa en este tipo de retos. </p>
                    </div>
                </section>
                <!-- Sección 5: Relación con Synapse CTF -->
                <section class="info-section info-with-image-left">
                    <div class="info-image-wrapper">
                        <img src="{{ asset('images/CTF.webp') }}" alt="Importancia de la criptografía en CTF" class="info-image" loading="lazy" />
                    </div>
                    <div class="info-content">
                        <h3 class="info-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg> Relación con Synapse CTF
                        </h3>
                        <p class="info-body"> Esta categoría de retos es fundamental para desarrollar la capacidad de
                            análisis lógico, la identificación de estructuras ocultas en datos y la aplicación de
                            herramientas de criptoanálisis. </p>
                    </div>
                </section>
            </div>
        </section>
    </main>

  </body>
</html>
