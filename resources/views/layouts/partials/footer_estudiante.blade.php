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
                      <h3 class="footer-nav-title">Áreas de evaluación</h3>
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
                      <h3 class="footer-nav-title">Synapse Evaluación lógico-matemática</h3>
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
                            <span>synapserecuperacion@gmail.com</span>
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
                      © 2025 Unifranz Synapse. Todos los derechos reservados.
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
                          @keyframes footer-grid-move {0% {transform: translate(0, 0);}
                  100% {transform: translate(50px, 50px);}}@keyframes footer-glow-pulse {0%,100% {opacity: 0.1;
                  transform: scale(1);}
                  50% {opacity: 0.2;
                  transform: scale(1.2);}}@keyframes footer-divider-glow {0%,100% {box-shadow: 0 0 10px var(--color-primary);}
                  50% {box-shadow: 0 0 20px var(--color-primary), 0 0 30px var(--color-primary);}}@keyframes footer-newsletter-scan {0% {left: -100%;}
                  100% {left: 100%;}}
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
                            '<span style="font-size: 12px;">✓</span>'

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
