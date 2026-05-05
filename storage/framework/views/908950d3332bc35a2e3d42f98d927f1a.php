<!DOCTYPE html>
<html lang="en">
  <head>
    <title>INTELECTA — La Evolución de las Evaluaciones en Evaluación Matemática</title>
    <meta property="og:title" content="INTELECTA — La Evolución de las Evaluaciones en Evaluación Matemática" />
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
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  </head>
  <body>
    <video autoplay muted loop id="background-video" class="background-video">
      <source src="<?php echo e(asset('images/Fondo2.mp4')); ?>" type="video/mp4">
      Tu navegador no soporta el elemento de video.
    </video>
    <link rel="stylesheet" href="<?php echo e(asset('css/estudiante_dashbord/style.css')); ?>" />
    <div>
      <link href="<?php echo e(asset('css/estudiante_dashbord/index.css')); ?>" rel="stylesheet" />

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
                <a href="<?php echo e(route('dashboard')); ?>">
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
                  <a href="<?php echo e(route('estudiante.evaluaciones.index')); ?>">
                    <div class="navigation-link">
                      <span class="navigation-link-text">Evaluaciones</span>
                      <span class="navigation-link-glow"></span>
                    </div>
                  </a>
                  <a href="<?php echo e(route('estudiante.intentos.index')); ?>">
                    <div class="navigation-link">
                      <span class="navigation-link-text">Intentos</span>
                      <span class="navigation-link-glow"></span>
                    </div>
                  </a>
                  <a href="<?php echo e(route('estudiante.rankings.index')); ?>">
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
                    <a href="<?php echo e(route('profile.edit')); ?>">
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
                  <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
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
                  <a href="<?php echo e(route('profile.edit')); ?>">
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
                  <form method="POST" action="<?php echo e(route('logout')); ?>">
                      <?php echo csrf_field(); ?>
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
              <a href="<?php echo e(route('profile.edit')); ?>">
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
              <form method="POST" action="<?php echo e(route('logout')); ?>">
                  <?php echo csrf_field(); ?>
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
<?php
    $categoria = optional($evaluacion->categoria);
    $dificultad = optional($evaluacion->dificultad);
    $categoriaLabel = strtoupper($categoria->codigo_cat ?? $categoria->nombre_cat ?? 'Evaluación lógico-matemática');
    $nivelValor = $dificultad->orden_dif ?? $evaluacion->dificultad_id ?? '3';
    $nivelNombre = $dificultad->nombre_dif ?? 'Nivel de dificultad media';
    $metadata = $evaluacion->metadata_eval ?? [];
    $archivos = $metadata['archivos'] ?? [];
?>

<div class="w-full bg-slate-950 text-slate-100 px-4 py-10 md:px-6">
  <div class="mx-auto max-w-5xl space-y-8">
    <div class="flex items-center justify-between gap-4">
      <div class="space-y-1">
        <p class="text-xs font-semibold tracking-[0.3em] text-emerald-400 uppercase">
          INTELECTA · Evaluación
        </p>
        <h1 class="text-3xl font-extrabold tracking-tight text-white">
          <?php echo e($evaluacion->titulo_eval ?? 'Título de la evaluación / reto'); ?>

        </h1>
      </div>

      <div class="hidden sm:flex flex-col items-end gap-2 text-xs text-slate-400">
        <span>Sesión adaptativa en curso</span>
        <span class="inline-flex items-center gap-1 rounded-full border border-emerald-500/50 px-3 py-1 text-emerald-300">
          <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
          Motor IRT + Markov activo
        </span>
      </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
      <span class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold tracking-wide">
        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
        <?php echo e($categoriaLabel); ?>

      </span>

      <span class="inline-flex items-center rounded-full bg-slate-900/80 px-3 py-1 text-xs font-semibold tracking-wide text-amber-300">
        Nivel <?php echo e($nivelValor); ?> · <?php echo e($nivelNombre); ?>

      </span>

      <span class="inline-flex items-center rounded-full bg-slate-900/80 px-3 py-1 text-[11px] font-medium text-slate-300">
        ID evaluación: #<?php echo e($evaluacion->id_eval ?? $evaluacion->id ?? '0001'); ?>

      </span>
    </div>

    <div class="grid gap-6 md:grid-cols-[minmax(0,2fr)_minmax(0,1.1fr)]">
      <section
        class="relative overflow-hidden rounded-2xl border border-emerald-500/40 bg-gradient-to-br from-slate-950 via-slate-950 to-emerald-950/40 shadow-[0_0_35px_rgba(16,185,129,0.35)]">
        <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-emerald-500/20 blur-3xl"></div>

        <div class="relative flex flex-col">
          <div class="flex items-center justify-between border-b border-emerald-500/30 bg-slate-950/90 px-4 py-2">
            <div class="flex items-center gap-1.5">
              <span class="h-2.5 w-2.5 rounded-full bg-rose-500/80"></span>
              <span class="h-2.5 w-2.5 rounded-full bg-amber-400/80"></span>
              <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"></span>
            </div>
            <p class="font-mono text-[11px] text-emerald-300">
              /ctf/evaluaciones/<?php echo e($evaluacion->id_eval ?? 'XXXX'); ?>

            </p>
          </div>

          <div class="space-y-4 px-4 py-5 md:px-6 md:py-6">
            <p class="font-mono text-xs text-emerald-300">
              &gt; cargando_enunciado_eval<span class="animate-pulse">_</span>
            </p>

            <div class="space-y-3 rounded-lg bg-slate-950/60 p-4 md:p-5 border border-slate-800/80">
              <p class="font-mono text-[13px] text-slate-100 leading-relaxed whitespace-pre-line">
                <?php echo e($evaluacion->enunciado_eval ?? $evaluacion->descripcion_eval ?? 'Aquí irá el enunciado de la evaluación...'); ?>

              </p>

              <p class="font-mono text-[11px] text-slate-400">
                Ejemplo: Se ha detectado tráfico sospechoso en el servidor de la organización. Analiza los artefactos proporcionados y encuentra la respuesta con formato <span class="text-emerald-300">synapse{...}</span>.
              </p>
            </div>

            <div class="grid gap-3 text-[11px] text-slate-400 md:grid-cols-3">
              <div class="space-y-1">
                <p class="font-mono text-slate-500 uppercase tracking-wide">
                  Área
                </p>
                <p class="font-mono text-emerald-300">
                  <?php echo e($categoriaLabel); ?>

                </p>
              </div>

              <div class="space-y-1">
                <p class="font-mono text-slate-500 uppercase tracking-wide">
                  Nivel de dificultad estimada
                </p>
                <p class="font-mono text-amber-300">
                  Nivel <?php echo e($nivelValor); ?> · <?php echo e($nivelNombre); ?>

                </p>
              </div>

              <div class="space-y-1">
                <p class="font-mono text-slate-500 uppercase tracking-wide">
                  Tiempo sugerido
                </p>
                <p class="font-mono text-slate-200">
                  20 - 30 min
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <aside class="space-y-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 shadow-lg">
          <h2 class="text-sm font-semibold text-slate-100 tracking-wide">
            Resumen de la evaluación
          </h2>
          <p class="mt-2 text-xs text-slate-400">
            Esta evaluación forma parte de tu ruta adaptativa. Completarla ayudará a refinar la estimación de tu nivel en esta área.
          </p>

          <dl class="mt-4 space-y-2 text-xs text-slate-300">
            <div class="flex items-center justify-between">
              <dt class="text-slate-400">Tipo de sesión</dt>
              <dd class="font-mono text-emerald-300">Adaptativa</dd>
            </div>
            <div class="flex items-center justify-between">
              <dt class="text-slate-400">Intentos permitidos</dt>
              <dd class="font-mono">Ilimitados</dd>
            </div>
            <div class="flex items-center justify-between">
              <dt class="text-slate-400">Puntaje base</dt>
              <dd class="font-mono text-indigo-300"><?php echo e($evaluacion->puntaje_base_eval ?? 100); ?> pts</dd>
            </div>
          </dl>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950/80 p-5 shadow-lg">
          <h2 class="text-sm font-semibold text-slate-100 tracking-wide flex items-center gap-2">
            Recursos del ejercicio
            <span class="text-[10px] font-normal text-slate-500">(descargables)</span>
          </h2>

          <ul class="mt-3 space-y-2 text-xs">
            <?php $__empty_1 = true; $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li
                  class="flex items-center justify-between rounded-lg border border-slate-800 bg-slate-900/70 px-3 py-2 hover:border-emerald-500/60 hover:bg-slate-900 transition">
                  <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    <span class="font-mono text-slate-200"><?php echo e($archivo); ?></span>
                  </div>
                  <a href="<?php echo e(route('estudiante.evaluaciones.descargar_recurso', [$evaluacion->id_eval ?? $evaluacion->id, $idx])); ?>"
                     class="text-[11px] font-medium text-emerald-300 hover:text-emerald-200">
                    Descargar
                  </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="rounded-lg border border-slate-800 bg-slate-900/70 px-3 py-2 text-[11px] text-slate-400">
                  Esta evaluación no requiere recursos adicionales.
                </li>
            <?php endif; ?>
          </ul>

          <p class="mt-3 text-[11px] text-slate-500 font-mono">
            Nota: Algunos recursos pueden tardar en descargarse según tu conexión.
          </p>
        </div>

        <div class="rounded-2xl border border-emerald-500/40 bg-gradient-to-r from-emerald-900/40 via-slate-950 to-slate-950 p-5 shadow-[0_0_25px_rgba(16,185,129,0.35)]">
          <p class="text-xs font-mono text-slate-300">
            Cuando estés listo, inicia la evaluación. El contador de tiempo y el registro de intentos comenzarán en el siguiente paso.
          </p>

          <a href="<?php echo e(route('estudiante.evaluaciones.realizar', $evaluacion->id_eval ?? $evaluacion->id)); ?>"
            class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-emerald-500/40 hover:bg-emerald-400 active:scale-[0.97] transition">
            Iniciar evaluación
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
        <?php echo $__env->make('layouts.partials.footer_estudiante', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <link
        rel="canonical"
        href="https://experienced-enlightened-nightingale-4x499e.teleporthq.app/"
      />
    </div>
  </body>
</html>
<?php /**PATH C:\laragon\www\synapse\resources\views/estudiante/evaluaciones/show.blade.php ENDPATH**/ ?>