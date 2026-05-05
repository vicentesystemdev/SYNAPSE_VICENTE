<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ranking General - INTELECTA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo e(asset('css/estudiante_dashbord/style.css')); ?>" />
    <link href="<?php echo e(asset('css/estudiante_dashbord/index.css')); ?>" rel="stylesheet" />
  </head>
  <body>
    <video autoplay muted loop id="background-video" class="background-video">
      <source src="<?php echo e(asset('images/Fondo2.mp4')); ?>" type="video/mp4">
      Tu navegador no soporta el elemento de video.
    </video>

    <header id="main-header" role="banner" class="navigation-unifranz">
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
                <a href="<?php echo e(route('evaluaciones.index')); ?>">
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
                <a href="<?php echo e(route('rankings.index')); ?>">
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
                            <form id="filter-form" action="<?php echo e(route('rankings.index')); ?>" method="GET" class="flex flex-wrap items-center gap-4 mb-6">
                                <div class="form-field">
                                    <label for="periodo_id" class="input-label">Periodo:</label>
                                    <select name="periodo_id" id="periodo_id" class="text-input">
                                        <?php $__currentLoopData = $periodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($periodo->id_per); ?>" <?php echo e($filters['periodo_id'] == $periodo->id_per ? 'selected' : ''); ?>>
                                                <?php echo e($periodo->nombre_per); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label for="skill_id" class="input-label">Área:</label>
                                    <select name="skill_id" id="skill_id" class="text-input">
                                        <option value="">Todas</option>
                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($skill->id_cat); ?>" <?php echo e($filters['skill_id'] == $skill->id_cat ? 'selected' : ''); ?>>
                                                <?php echo e($skill->categoria); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php $__empty_1 = true; $__currentLoopData = $dataset; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="<?php echo e((isset($userRanking) && $userRanking['ranking']->user->id === $item['ranking']->user->id) ? 'highlight-user' : ''); ?>">
                                                <td><?php echo e($item['ranking']->posicion); ?></td>
                                                <td><?php echo e($item['ranking']->user->name ?? 'N/D'); ?></td>
                                                <td><?php echo e(number_format($item['ranking']->puntaje_total, 2)); ?></td>
                                                <td><?php echo e($item['evaluaciones']); ?></td>
                                                <td><?php echo e(optional($item['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No hay datos de ranking para los filtros seleccionados en el Top 10.</td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if(isset($userRanking) && !$dataset->contains(function ($item) use ($userRanking) { return $item['ranking']->user->id === $userRanking['ranking']->user->id; })): ?>
                                            <tr class="highlight-user">
                                                <td><?php echo e($userRanking['ranking']->posicion); ?></td>
                                                <td><?php echo e($userRanking['ranking']->user->name ?? 'N/D'); ?> (Tú)</td>
                                                <td><?php echo e(number_format($userRanking['ranking']->puntaje_total, 2)); ?></td>
                                                <td><?php echo e($userRanking['evaluaciones']); ?></td>
                                                <td><?php echo e(optional($userRanking['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D'); ?></td>
                                            </tr>
                                        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\synapse\resources\views/estudiante/rankings/index.blade.php ENDPATH**/ ?>