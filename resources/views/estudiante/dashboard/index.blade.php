<!DOCTYPE html>
<html lang="en">
  <head>
    <title>INTELECTA — Plataforma de Evaluación Lógico-Matemática</title>
    <meta property="og:title" content="INTELECTA — Plataforma de Evaluación Lógico-Matemática" />
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
                  <a href="{{ route('evaluaciones.index') }}">
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
                  <a href="{{ route('rankings.index') }}">
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
          <section
            id="hero-section"
            role="region"
            aria-label="Hero — start test"
            tabindex="0"
            class="hero-section section-spacing"
          >
            <div class="hero-wrapper">
              <div class="hero-banner-backplate"></div>
              <div aria-hidden="true" class="floating-accent-panel"></div>
              <div class="hero-card">
                <div class="hero-left">
                  <h1 class="home-hero-title hero-title">
                    INTELECTA — Plataforma de Evaluación Lógico-Matemática
                  </h1>
                  <p class="home-hero-subtitle hero-subtitle">
                    Bienvenido a INTELECTA, plataforma de evaluación lógico-matemática orientada al análisis del desempeño académico.
                  </p>
                  <p class="hero-body">
                    Resuelve ejercicios de álgebra, cálculo básico, lógica matemática y razonamiento numérico.
                  </p>
                  @if(isset($proximaEvaluacion) && $proximaEvaluacion)
                      <a href="{{ route('evaluaciones.show', $proximaEvaluacion->id_eval) }}" class="cta-pulse btn btn-primary btn-lg">
                          <span>Ir a Pruebas Personalizadas</span>
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
                        d="m5 12l7-7l7 7m-7 7V5"
                      ></path>
                    </svg>
                      </a>
                  @else
                      <button disabled aria-label="No hay evaluaciones disponibles" class="cta-pulse btn btn-primary btn-lg">
                          <span>No hay evaluaciones disponibles</span>
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
                              d="m5 12l7-7l7 7m-7 7V5"
                        ></path>
                      </svg>
                      </button>
                  @endif
                    </div>
                <div class="hero-right">
                  <div class="skill-preview">
                    @foreach($categorias as $categoria)
                    <div class="skill-chip">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                        ></path>
                      </svg>
                          <span>{{ $categoria->categoria }}</span>
                    </div>
                    @endforeach
                    </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Cuestionario / Encuesta Eliminado -->
          <section
            id="feature-carousel"
            role="region"
            aria-label="Feature carousel"
            aria-roledescription="carousel"
            class="feature-carousel section-spacing"
          >
            <div class="carousel-header">
              <h2 class="section-title">Áreas de Evaluación</h2>
              <p class="section-subtitle">
                Explora las cuatro disciplinas clave que forman el corazón de INTELECTA. Cada área está diseñada para medir tu capacidad de análisis, razonamiento y resolución de problemas matemáticos.
              </p>
            </div>
            <div role="list" class="coverflow">
              <a href="{{ route('estudiante.web.info') }}" class="category-card">
              <article
                role="listitem"
                aria-labelledby="card-html5"
                class="card"
              >
                <div class="card-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                    ></path>
                  </svg>
                </div>
                  <h3 id="card-html5" class="card-title">ÁLGEBRA</h3>
                <p class="card-body">
                    Resuelve ecuaciones, sistemas lineales y problemas de funciones. Evalúa tu capacidad para manipular expresiones y encontrar valores desconocidos.
                </p>
              </article>
              </a>
              <a href="{{ route('estudiante.crypto.info') }}" class="category-card">
              <article role="listitem" aria-labelledby="card-css3" class="card">
                <div class="card-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                    ></path>
                  </svg>
                </div>
                  <h3 id="card-css3" class="card-title">CÁLCULO BÁSICO</h3>
                <p class="card-body">
                    Practica derivadas, límites e integrales simples. Mide tu comprensión del análisis matemático a nivel preuniversitario.
                </p>
              </article>
              </a>
              <a href="{{ route('estudiante.stego.info') }}" class="category-card">
              <article
                role="listitem"
                aria-labelledby="card-php"
                  class="card"
              >
                <div class="card-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                    ></path>
                  </svg>
                </div>
                  <h3 id="card-php" class="card-title">LÓGICA MATEMÁTICA</h3>
                <p class="card-body">
                    Trabaja con proposiciones, tablas de verdad y conectivos lógicos. Ejercita tu capacidad de razonamiento formal y deductivo.
                </p>
              </article>
              </a>
              <a href="{{ route('estudiante.forens.info') }}" class="category-card">
              <article
                role="listitem"
                aria-labelledby="card-python"
                class="card"
              >
                <div class="card-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                    ></path>
                  </svg>
                </div>
                  <h3 id="card-python" class="card-title">RAZONAMIENTO NUMÉRICO</h3>
                <p class="card-body">
                    Secuencias, proporciones, porcentajes y problemas de lógica numérica. Desarrolla tu agilidad mental con problemas de nivel universitario.
                </p>
              </article>
              </a>
              <!-- Las demás tarjetas se mantienen sin cambio, solo se reemplaza texto si hubiera más -->
            </div>
            <div class="chips">
              <button class="chip" title="Interfaz y experiencia de usuario">Interfaz</button>
              <button class="chip" title="Procesamiento interno del sistema">Motor Interno</button>
              <button class="chip" title="Procesos automatizados del sistema adaptativo">Adaptatividad</button>
              <button class="chip" title="Rendimiento del sistema en tiempo real">Rendimiento</button>
              <button class="chip" title="Buenas prácticas y arquitectura segura">Seguridad</button>
            </div>
          </section>
          <section
            id="overview-section"
            role="region"
            aria-label="Overview"
            class="overview-section section-spacing"
          >
            <div class="section-container">
              <div class="section-header">
                <h2 class="section-title">¿Qué es INTELECTA?</h2>
                <p class="section-subtitle">
                  INTELECTA es una plataforma de evaluación adaptativa que mide el desempeño lógico-matemático de los estudiantes a través de ejercicios de álgebra, cálculo básico, lógica matemática y razonamiento numérico.

                  Consulta tus resultados, progreso y posición académica según tu desempeño en cada área.
                </p>
              </div>
              <div class="overview-backplate">
                <div class="cards-grid">
                  <article
                    aria-labelledby="overview-web"
                    class="card-horizontal"
                  >
                    <div class="card-icon-wrapper">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <circle cx="12" cy="10" r="8"></circle>
                          <circle cx="12" cy="10" r="3"></circle>
                          <path d="M7 22h10m-5 0v-4"></path>
                        </g>
                      </svg>
                    </div>
                    <div class="card-content">
                      <span class="card-label">01</span>
                      <h3 id="overview-web" class="card-title">Ejercicios Disponibles</h3>
                      <p class="card-body">
                        Accede a pruebas personalizadas que se ajustan a tu rendimiento: el sistema analiza aciertos, latencias y patrones para ofrecer el siguiente ejercicio que realmente te ayuda a mejorar.
                      </p>
                    </div>
                  </article>
                  <article
                    aria-labelledby="overview-crypto"
                    class="card-horizontal"
                  >
                    <div class="card-icon-wrapper">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"
                        ></path>
                      </svg>
                    </div>
                    <div class="card-content">
                      <span class="card-label">02</span>
                      <h3 id="overview-crypto" class="card-title">Progreso en Evaluación lógico-matemática</h3>
                      <p class="card-body">
                        Tu nivel se estima científicamente (IRT 2PL, Markov, EMA). INTELECTA traduce tu rendimiento en recomendaciones para que avances con sentido.
                      </p>
                    </div>
                  </article>
                  <article
                    aria-labelledby="overview-forense"
                    class="card-horizontal"
                  >
                    <div class="card-icon-wrapper">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <path d="m21 21l-4.34-4.34"></path>
                          <circle cx="11" cy="11" r="8"></circle>
                        </g>
                      </svg>
                    </div>
                    <div class="card-content">
                      <span class="card-label">03</span>
                      <h3 id="overview-forense" class="card-title">Intentos Recientes</h3>
                      <p class="card-body">
                        Consulta tu historial con contexto: dificultad, tiempo invertido y evolución. Cada intento alimenta tu perfil adaptativo.
                      </p>
                    </div>
                  </article>
                  <article
                    aria-labelledby="overview-esteg"
                    class="card-horizontal"
                  >
                    <div class="card-icon-wrapper">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="40"
                        height="40"
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
                            width="18"
                            height="11"
                            x="3"
                            y="11"
                            rx="2"
                            ry="2"
                          ></rect>
                          <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </g>
                      </svg>
                    </div>
                    <div class="card-content">
                      <span class="card-label">04</span>
                      <h3 id="overview-esteg" class="card-title">
                        ¿Qué es INTELECTA?
                      </h3>
                      <p class="card-body">
                        Plataforma de evaluación formativa basada en pruebas reales. Aprende haciendo y mejora con rutas personalizadas por área.
                      </p>
                    </div>
                  </article>
                </div>
              </div>
            </div>
          </section>
          <section
            id="updates-section"
            role="region"
            aria-labelledby="updates-heading"
            class="updates-section section-spacing"
          >
            <div class="updates-container">
              <div class="updates-header">
                <h2 id="updates-heading" class="section-title">
                  Cómo funciona el sistema
                </h2>
                <p class="section-subtitle">
                  El motor adaptativo observa tu desempeño en tiempo real. Cada respuesta encontrada, cada error, cada segundo invertido afecta tu camino. Si dominas un nivel, subes. Si te frustras, ajusta.

                  El sistema combina múltiples modelos matemáticos que trabajan al mismo tiempo para ofrecerte una experiencia personalizada:

                  IRT 2PL: Determina tu habilidad técnica real (theta) en cada área.

                  Markov: Predice tu transición de nivel para asignar el siguiente reto.

                  EMA: Captura tu rendimiento histórico.

                  Regresión Logística: Estima la mejor dificultad inicial para nuevas sesiones.

                  Nada es aleatorio. Todo está calculado para ayudarte a crecer.
                </p>
              </div>
              <div class="updates-lead-lane">
                <article
                  role="article"
                  aria-roledescription="featured update"
                  aria-label="Featured update: Product version 2.4"
                  class="lead-card"
                >
                  <div class="lead-overlay"></div>
                  <img
                    src="https://images.pexels.com/photos/9783346/pexels-photo-9783346.jpeg?auto=compress&amp;cs=tinysrgb&amp;w=1500"
                    alt="Technology interface with data"
                    loading="lazy"
                  />
                  <div class="lead-content">
                    <span class="lead-meta">Misión del sistema</span>
                    <h3 class="lead-title">Empoderar a estudiantes para enfrentar ejercicios reales del mundo digital.</h3>
                    <p class="lead-body">
                      INTELECTA transforma conocimiento en habilidad práctica. Aquí se aprende probando: fallas, refuerzos y progreso medible. Únete: resuelve pruebas reales, mejora tu perfil y compite con propósito.
                    </p>
                    <p class="lead-body">
                      Aprender no es recordar: es poder reproducir la solución bajo presión. Atrévete, falla, refuerza, mejora.
                    </p>
                  </div>
                </article>
              </div>
              <div class="updates-lanes">
                <div
                  tabindex="0"
                  role="region"
                  aria-label="Updates lane 1"
                  class="updates-lane"
                >
                  <article
                    role="article"
                    aria-label="Security bulletin"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"
                        ></path>
                      </svg>
                      <span>SEGURIDAD</span>
                    </span>
                    <h3 class="update-title">
                        Integridad garantizada
                    </h3>
                    <p class="update-body">
                        La plataforma está construida bajo principios de seguridad aplicados en entornos reales. Cada ejercicio pasa por auditorías internas y pruebas automatizadas que garantizan autenticidad, integridad y protección de los datos. Implementamos prácticas modernas adoptadas por equipos profesionales de evaluación matemática en Bolivia y Latinoamérica.
                    </p>
                    </div>
                  </article>
                  <article
                    role="article"
                    aria-label="Learning paths update"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"
                        ></path>
                      </svg>
                      <span>APRENDIZAJE</span>
                    </span>
                    <h3 class="update-title">
                        Rutas inteligentes que evolucionan contigo
                    </h3>
                    <p class="card-body">
                        INTELECTA no solo mide resultados: interpreta tu proceso. Cada intento, acierto o error alimenta el motor adaptativo. El sistema construye rutas personalizadas para reforzar debilidades, potenciar fortalezas y preparar al estudiante para escenarios reales de análisis web, forense, stego y criptografía.
                    </p>
                    </div>
                  </article>
                  <article
                    role="article"
                    aria-label="Case studies"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 6L9 17l-5-5"
                        ></path>
                      </svg>
                      <span>CASOS DE ESTUDIO</span>
                    </span>
                      <h3 class="update-title">Impacto real en el desarrollo profesional</h3>
                    <p class="card-body">
                        La metodología adaptativa usada aquí está inspirada en prácticas aplicadas por instituciones como AGETIC y comunidades internacionales de seguridad. Estudios de aula muestran mejoras en:

                        <br>• tiempos de análisis,
                        <br>• precisión criptográfica,
                        <br>• lectura forense,
                        <br>• identificación de vulnerabilidades web.

                        Esta plataforma transforma teoría en habilidad aplicable.
                    </p>
                    </div>
                  </article>
                </div>
                <div
                  tabindex="0"
                  role="region"
                  aria-label="Updates lane 2"
                  class="updates-lane"
                >
                  <article
                    role="article"
                    aria-label="Events and webinars"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                      >
                        <g
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                        >
                          <circle cx="12" cy="10" r="8"></circle>
                          <circle cx="12" cy="10" r="3"></circle>
                          <path d="M7 22h10m-5 0v-4"></path>
                        </g>
                      </svg>
                      <span>EVENTOS</span>
                    </span>
                      <h3 class="update-title">
                        Formación continua con expertos
                      </h3>
                    <p class="update-body">
                        Accede a talleres, sesiones virtuales y actividades guiadas por especialistas en evaluación matemática. Explora técnicas modernas utilizadas por evaluadores profesionales, participa en mini-competencias y descubre nuevas herramientas que complementan tu desarrollo técnico.
                    </p>
                    </div>
                  </article>
                  <article
                    role="article"
                    aria-label="Community feedback"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
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
                      <span>COMUNIDAD</span>
                    </span>
                      <h3 class="update-title">Construyamos juntos una cultura de evaluación matemática</h3>
                    <p class="card-body">
                        Únete a una red creciente de estudiantes, docentes y entusiastas de la seguridad informática. Comparte soluciones, desarrolla pensamiento crítico y colabora en ejercicios semanales que valoran ingenio, creatividad y buenas prácticas.
                    </p>
                    </div>
                  </article>
                  <article
                    role="article"
                    aria-label="Platform improvements"
                    class="update-card"
                  >
                    <div class="content">
                    <span class="card-meta">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m16 18l6-6l-6-6M8 6l-6 6l6 6"
                        ></path>
                      </svg>
                      <span>PLATAFORMA</span>
                    </span>
                    <h3 class="update-title">
                        Tecnología que evoluciona contigo
                    </h3>
                    <p class="card-body">
                        INTELECTA integra visualizaciones claras de progreso, métricas en tiempo real, paneles interactivos y una arquitectura diseñada para acompañar cada fase de tu aprendizaje. La plataforma crece con nuevas funciones, nuevos ejercicios y herramientas que fortalecen las competencias técnicas del usuario.
                    </p>
                    </div>
                  </article>
                </div>
              </div>
            </div>
          </section>
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
