

<?php $__env->startSection('title', 'Intentos de estudiantes'); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    Auditoría de intentos
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Intentos</h3>
            </div>
            <div class="card-body p-0">
                
                <div class="p-3">
                    <form action="<?php echo e(route('admin.intentos.index')); ?>" method="GET" class="form-inline">
                        <div class="input-group input-group-sm mr-2 mb-2">
                            <input type="text" name="search" class="form-control float-right" placeholder="Buscar estudiante o evaluación" value="<?php echo e(request('search')); ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Todos los estados</option>
                                <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Correcto</option>
                                <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Incorrecto</option>
                            </select>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <select name="evaluacion_id" class="form-control form-control-sm">
                                <option value="">Todas las Evaluaciones</option>
                                <?php $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($evaluacion->id_eval); ?>" <?php echo e(request('evaluacion_id') == $evaluacion->id_eval ? 'selected' : ''); ?>>
                                        <?php echo e($evaluacion->titulo_eval); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                        <?php if(request()->has('search') || request()->has('status') || request()->has('evaluacion_id')): ?>
                            <a href="<?php echo e(route('admin.intentos.index')); ?>" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('admin.intentos.exportPdf', request()->query())); ?>" class="btn btn-danger btn-sm ml-2 mb-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </a>

                        
                        <a href="<?php echo e(route('admin.intentos.index', array_merge(request()->query(), ['sort_by' => 'id_int', 'sort_direction' => 'asc']))); ?>" class="btn btn-default btn-sm ml-2 mb-2" title="Ordenar por ID Ascendente">
                            <i class="fas fa-sort-numeric-up-alt"></i> ID Asc
                        </a>
                        <a href="<?php echo e(route('admin.intentos.index', array_merge(request()->query(), ['sort_by' => 'id_int', 'sort_direction' => 'desc']))); ?>" class="btn btn-default btn-sm ml-1 mb-2" title="Ordenar por ID Descendente">
                            <i class="fas fa-sort-numeric-down-alt"></i> ID Desc
                        </a>
                    </form>
                </div>
                

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Intento</th>
                                <th>Estudiante</th>
                                <th>Área Evaluación</th> 
                                <th>Nro Intento</th>
                                <th>Respuesta</th>
                                <th>Correcto</th>
                                <th>Fecha Envío</th>
                                <th>Latencia (seg)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $intentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($intento->id_int); ?></td>
                                    <td><?php echo e($intento->user->name); ?> <?php echo e($intento->user->app_usu); ?></td>
                                    <td><?php echo e($intento->evaluacion->categoria->nombre_cat ?? 'N/A'); ?></td> 
                                    <td><?php echo e($intento->nro_intento_int); ?></td>
                                    <td><?php echo e($intento->respuesta_flag_int); ?></td>
                                    <td>
                                        <?php if($intento->es_correcto_int): ?>
                                            <span class="badge badge-success">Sí</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(\Carbon\Carbon::createFromTimestamp($intento->tiempo_envio_int)->format('d/m/Y H:i:s')); ?></td>
                                    <td><?php echo e($intento->latencia_seg_int ?? 'N/A'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.intentos.show', $intento->id_int)); ?>" class="btn btn-primary btn-xs" title="Ver Detalles">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center">No hay intentos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <?php echo e($intentos->appends(request()->query())->links('pagination::bootstrap-4')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/intentos/index.blade.php ENDPATH**/ ?>