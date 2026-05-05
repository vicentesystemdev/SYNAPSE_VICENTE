

<?php $__env->startSection('title', 'Gestión de Docentes'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Gestión de Docentes</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Docentes Registrados</h3>
            <div class="card-tools">
                <a href="<?php echo e(route('admin.docentes.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Registrar Nuevo Docente
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            
            <div class="p-3">
                <form action="<?php echo e(route('admin.docentes.index')); ?>" method="GET" class="form-inline">
                    <div class="input-group input-group-sm mr-2 mb-2">
                        <input type="text" name="search" class="form-control float-right" placeholder="Buscar por nombre o apellido" value="<?php echo e(request('search')); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos los estados</option>
                            <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Activo</option>
                            <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                    <?php if(request()->has('search') || request()->has('status')): ?>
                        <a href="<?php echo e(route('admin.docentes.index')); ?>" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(route('admin.docentes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'asc']))); ?>" class="btn btn-default btn-sm ml-2 mb-2" title="Ordenar por ID Ascendente">
                        <i class="fas fa-sort-numeric-up-alt"></i> ID Asc
                    </a>
                    <a href="<?php echo e(route('admin.docentes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'desc']))); ?>" class="btn btn-default btn-sm ml-1 mb-2" title="Ordenar por ID Descendente">
                        <i class="fas fa-sort-numeric-down-alt"></i> ID Desc
                    </a>

                    
                    <a href="<?php echo e(route('admin.docentes.exportPdf', request()->query())); ?>" class="btn btn-danger btn-sm ml-2 mb-2" target="_blank" title="Exportar a PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="<?php echo e(route('admin.docentes.exportExcel', request()->query())); ?>" class="btn btn-success btn-sm ml-1 mb-2" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </form>
            </div>
            

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nro Docente</th> 
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                            <tr>
                                <td><?php echo e($loop->iteration + ($docentes->currentPage() - 1) * $docentes->perPage()); ?></td> 
                                <td><?php echo e($docente->id); ?></td>
                                <td><?php echo e($docente->name); ?> <?php echo e($docente->app_usu); ?> <?php echo e($docente->apm_usu); ?></td>
                                <td><?php echo e($docente->email); ?></td>
                                <td>
                                    <form action="<?php echo e(route('admin.docentes.toggle-status', $docente->id)); ?>" method="POST" class="toggle-status-form" id="toggle-status-form-<?php echo e($docente->id); ?>" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-xs <?php echo e($docente->activo_usu ? 'btn-success' : 'btn-danger'); ?>">
                                            <?php echo e($docente->activo_usu ? 'Activo' : 'Inactivo'); ?>

                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.docentes.edit', $docente->id)); ?>" class="btn btn-info btn-xs mr-1" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">No hay docentes registrados.</td> 
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($docentes->links('pagination::bootstrap-4')); ?> 
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('components.scripts.toggle-status', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/usuarios/docentes/index.blade.php ENDPATH**/ ?>