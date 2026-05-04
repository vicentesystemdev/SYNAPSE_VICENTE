<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ranking General - Synapse Evaluación lógico-matemática</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/estudiante_dashbord/style.css') }}" />
    <link href="{{ asset('css/estudiante_dashbord/index.css') }}" rel="stylesheet" />
  </head>
  <body>
    <video autoplay muted loop id="background-video" class="background-video">
      <source src="{{ asset('images/Fondo2.mp4') }}" type="video/mp4">
      Tu navegador no soporta el elemento de video.
    </video>

    <header id="main-header" role="banner" class="navigation-unifranz">
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
            </form>
        </div>
    </header>

    <main id="main-content" class="main-content">
        <section id="rankings-section" class="section-spacing">
            <div class="section-container">
                <div class="section-header">
                    <h2 class="section-title">Ranking general</h2>
                    <p class="section-subtitle">Consulta tu posición en el período actual y tu desempeño por área.</p>
                </div>

                <div class="card-container">
                    <div class="p-6">
                        <div class="ranking-card">
                            <h3 class="text-xl font-semibold mb-4 section-title">Filtros de Ranking</h3>
                            <form id="filter-form" action="{{ route('rankings.index') }}" method="GET" class="flex flex-wrap items-center gap-4 mb-6">
                                <div class="form-field">
                                    <label for="periodo_id" class="input-label">Periodo:</label>
                                    <select name="periodo_id" id="periodo_id" class="text-input">
                                        @foreach($periodos as $periodo)
                                            <option value="{{ $periodo->id_per }}" {{ $filters['periodo_id'] == $periodo->id_per ? 'selected' : '' }}>
                                                {{ $periodo->nombre_per }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label for="skill_id" class="input-label">Área:</label>
                                    <select name="skill_id" id="skill_id" class="text-input">
                                        <option value="">Todas</option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id_cat }}" {{ $filters['skill_id'] == $skill->id_cat ? 'selected' : '' }}>
                                                {{ $skill->categoria }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn-primary">Aplicar Filtros</button>
                            </form>

                            <div class="overflow-x-auto">
                                <table class="ranking-table">
                                    <thead>
                                        <tr>
                                            <th>Posición</th>
                                            <th>Estudiante</th>
                                            <th>Puntaje Total</th>
                                            <th># Evaluaciones</th>
                                            <th>Última Actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dataset as $item)
                                            <tr class="{{ (isset($userRanking) && $userRanking['ranking']->user->id === $item['ranking']->user->id) ? 'highlight-user' : '' }}">
                                                <td>{{ $item['ranking']->posicion }}</td>
                                                <td>{{ $item['ranking']->user->name ?? 'N/D' }}</td>
                                                <td>{{ number_format($item['ranking']->puntaje_total, 2) }}</td>
                                                <td>{{ $item['evaluaciones'] }}</td>
                                                <td>{{ optional($item['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No hay datos de ranking para los filtros seleccionados en el Top 10.</td>
                                            </tr>
                                        @endforelse
                                        @if(isset($userRanking) && !$dataset->contains(function ($item) use ($userRanking) { return $item['ranking']->user->id === $userRanking['ranking']->user->id; }))
                                            <tr class="highlight-user">
                                                <td>{{ $userRanking['ranking']->posicion }}</td>
                                                <td>{{ $userRanking['ranking']->user->name ?? 'N/D' }} (Tú)</td>
                                                <td>{{ number_format($userRanking['ranking']->puntaje_total, 2) }}</td>
                                                <td>{{ $userRanking['evaluaciones'] }}</td>
                                                <td>{{ optional($userRanking['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D' }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
  </body>
</html>
