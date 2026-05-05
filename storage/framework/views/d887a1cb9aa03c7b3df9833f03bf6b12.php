

<?php $__env->startSection('title', 'Rankings Globales'); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="m-0 text-dark">
        <i class="fas fa-fw fa-trophy text-orange-600"></i> Rankings Globales
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="card bg-dark custom-card-dark shadow-lg">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white">
                    <i class="fas fa-list-ol mr-1 text-orange-400"></i> Vista de Ranking
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                
                <form action="<?php echo e(route('rankings.index')); ?>" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo_id" class="text-white-50">Período:</label>
                                <select name="periodo_id" id="periodo_id" class="form-control form-control-sm custom-select-dark">
                                    <?php $__currentLoopData = $periodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($periodo->id_per); ?>" <?php if(($filters['periodo_id'] ?? null) == $periodo->id_per): echo 'selected'; endif; ?>>
                                            <?php echo e($periodo->nombre_per); ?> (<?php echo e($periodo->gestion_per); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="skill_id" class="text-white-50">Área (Skill):</label>
                                <select name="skill_id" id="skill_id" class="form-control form-control-sm custom-select-dark">
                                    <option value="">Todas</option> 
                                    <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($skill->id_cat); ?>" <?php if(($filters['skill_id'] ?? null) == $skill->id_cat): echo 'selected'; endif; ?>>
                                            <?php echo e($skill->nombre_cat); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nivel" class="text-white-50">Nivel de Prueba:</label>
                                <select name="nivel" id="nivel" class="form-control form-control-sm custom-select-dark">
                                    <option value="">Todos los niveles</option>
                                    <option value="alto" <?php if(($filters['nivel'] ?? null) == 'alto'): echo 'selected'; endif; ?>>Alto</option>
                                    <option value="medio" <?php if(($filters['nivel'] ?? null) == 'medio'): echo 'selected'; endif; ?>>Medio</option>
                                    <option value="bajo" <?php if(($filters['nivel'] ?? null) == 'bajo'): echo 'selected'; endif; ?>>Bajo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3"> 
                        <div class="col-md-12 d-flex justify-content-end"> 
                            <button type="submit" class="btn btn-primary custom-btn-orange mr-2">
                                <i class="fas fa-filter mr-2"></i> Filtrar Ranking
                            </button>
                            <a href="<?php echo e(route('rankings.index')); ?>" class="btn btn-secondary ml-2">
                                <i class="fas fa-sync-alt mr-2"></i> Resetear
                            </a>

                            
                            <div class="btn-group ml-3" role="group">
                                <a href="<?php echo e(route('rankings.csv', $filters)); ?>" class="btn btn-success custom-btn-excel mr-1" title="Exportar a CSV/Excel">
                                    <i class="fas fa-file-excel mr-1"></i> Excel
                                </a>
                                <a href="<?php echo e(route('rankings.pdf', $filters)); ?>" class="btn btn-danger custom-btn-pdf" title="Exportar a PDF">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                
                <table class="table table-dark table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Estudiante</th>
                            <th>Puntaje Total</th>
                            <th>Evaluaciones</th>
                            <th>Última Actualización</th>
                            <th>Nivel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dataset; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $rankingData = (object) $item['ranking'];
                                $userData = (object) $rankingData->user;

                                $nivelColor = 'secondary';
                                $nivelTexto = 'N/D';
                                
                                // Lógica para determinar el nivel basada en theta_global
                                if (isset($rankingData->theta_global)) {
                                     if ($rankingData->theta_global > 1) {
                                        $nivelColor = 'success'; // Alto
                                        $nivelTexto = 'Alto';
                                    } elseif ($rankingData->theta_global >= 0) {
                                        $nivelColor = 'warning'; // Medio
                                        $nivelTexto = 'Medio';
                                    } else {
                                        $nivelColor = 'danger'; // Bajo
                                        $nivelTexto = 'Bajo';
                                    }
                                } elseif (isset($rankingData->puntaje_total)) { // Fallback si no hay theta_global
                                    if ($rankingData->puntaje_total > 200) { // Umbral de ejemplo
                                        $nivelColor = 'success';
                                        $nivelTexto = 'Alto';
                                    } elseif ($rankingData->puntaje_total > 100) { // Umbral de ejemplo
                                        $nivelColor = 'warning';
                                        $nivelTexto = 'Medio';
                                    } else {
                                        $nivelColor = 'danger';
                                        $nivelTexto = 'Bajo';
                                    }
                                }
                            ?>
                            <tr>
                                <td><?php echo e($rankingData->posicion ?? 'N/D'); ?></td>
                                <td><?php echo e($userData->name ?? 'N/D'); ?> <?php echo e($userData->app_usu ?? ''); ?></td>
                                <td><span class="badge badge-success custom-badge-success"><?php echo e(number_format($rankingData->puntaje_total ?? 0, 2)); ?></span></td>
                                <td><?php echo e($item['evaluaciones'] ?? 0); ?></td>
                                <td><?php echo e(optional($item['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D'); ?></td>
                                <td><span class="badge badge-<?php echo e($nivelColor); ?>"><?php echo e($nivelTexto); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-white-50">No hay datos de ranking disponibles para los filtros seleccionados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent text-center">
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        /* Estilos personalizados para el selector oscuro */
        .custom-select-dark {
            background-color: #3f4a59 !important;
            color: #ffffff !important;
            border: 1px solid #5a6470 !important;
        }
        .custom-select-dark option {
            background-color: #3f4a59;
            color: #ffffff;
        }
        /* Estilos para el botón naranja */
        .custom-btn-orange {
            background-color: #fb8c00 !important;
            border-color: #fb8c00 !important;
            color: #ffffff !important;
        }
        .custom-btn-orange:hover {
            background-color: #e67c00 !important;
            border-color: #e67c00 !important;
        }
        /* Estilos generales de tarjeta oscura */
        .custom-card-dark {
            background-color: #2d3748 !important; /* Tono oscuro para el card */
            color: #ffffff;
        }
        .custom-card-dark .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-card-dark .card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-card-dark .table {
            color: #ffffff;
        }
        .custom-card-dark .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        /* Insignias personalizadas */
        .badge-success.custom-badge-success {
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        /* Estilos personalizados para botones de Exportación */
        .custom-btn-excel {
            background-color: #28a745 !important; /* Verde de Excel */
            border-color: #28a745 !important;
            color: #ffffff !important;
        }
        .custom-btn-excel:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .custom-btn-pdf {
            background-color: #dc3545 !important; /* Rojo de PDF */
            border-color: #dc3545 !important;
            color: #ffffff !important;
        }
        .custom-btn-pdf:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/rankings/index.blade.php ENDPATH**/ ?>