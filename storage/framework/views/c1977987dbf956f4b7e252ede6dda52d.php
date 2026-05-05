

<?php $__env->startSection('title', 'Gestión de Roles'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Gestión de Roles</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles Registrados</h3>
            <div class="card-tools">
                <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Crear Nuevo Rol
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            
            <div class="p-3">
                <form action="<?php echo e(route('admin.roles.index')); ?>" method="GET" class="form-inline">
                    <div class="input-group input-group-sm mr-2 mb-2">
                        <input type="text" name="search" class="form-control float-right" placeholder="Buscar por nombre" value="<?php echo e(request('search')); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos los estados</option>
                            <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Activo</option>
                            <option value="2" <?php echo e(request('status') === '2' ? 'selected' : ''); ?>>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                    <?php if(request()->has('search') || request()->has('status')): ?>
                        <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nombre del Rol</th>
                            <th>Permisos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($role->id); ?></td>
                                <td><?php echo e($role->name); ?></td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = $role->permissions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span class="badge badge-info"><?php echo e($permission->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="badge badge-secondary">Sin permisos</span>
                                    <?php endif; ?>
                                    <?php if($role->permissions->count() > 5): ?>
                                        <span class="badge badge-secondary">+<?php echo e($role->permissions->count() - 5); ?> más</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?php echo e(route('admin.roles.toggle-status', $role->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-xs <?php echo e($role->estado == 1 ? 'btn-success' : 'btn-danger'); ?>" title="Cambiar Estado">
                                            <?php echo e($role->estado == 1 ? 'Activo' : 'Inactivo'); ?>

                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.roles.edit', $role->id)); ?>" class="btn btn-info btn-xs" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay roles registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($roles->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>