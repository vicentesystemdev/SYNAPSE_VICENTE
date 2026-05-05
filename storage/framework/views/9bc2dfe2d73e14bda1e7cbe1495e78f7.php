

<?php $__env->startSection('title', 'Auditoría del Sistema'); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    Auditoría y Registros de Sesión
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Logins</h5>
                    <h2 class="mb-0"><?php echo e(number_format($stats['total_logins'])); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Logouts</h5>
                    <h2 class="mb-0"><?php echo e(number_format($stats['total_logouts'])); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Logins Hoy</h5>
                    <h2 class="mb-0"><?php echo e(number_format($stats['logins_hoy'])); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Activos Hoy</h5>
                    <h2 class="mb-0"><?php echo e(number_format($stats['usuarios_activos'])); ?></h2>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.auditoria.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="accion">Acción</label>
                        <select name="accion" id="accion" class="form-control">
                            <option value="">Todas</option>
                            <option value="login" <?php echo e(request('accion') == 'login' ? 'selected' : ''); ?>>Login</option>
                            <option value="logout" <?php echo e(request('accion') == 'logout' ? 'selected' : ''); ?>>Logout</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="ip">IP Address</label>
                        <input type="text" name="ip" id="ip" class="form-control" value="<?php echo e(request('ip')); ?>" placeholder="192.168.1.1">
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_desde">Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="fecha_hasta">Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="<?php echo e(route('admin.auditoria.index')); ?>" class="btn btn-secondary">Limpiar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Historial de Sesiones</h5>
        </div>
        <div class="card-body">
            <?php if($logs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Fecha/Hora</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->id_audit); ?></td>
                                    <td>
                                        <?php if($log->user): ?>
                                            <strong><?php echo e($log->user->nombre_usu); ?></strong><br>
                                            <small class="text-muted"><?php echo e($log->user->email); ?></small><br>
                                            <span class="badge badge-secondary">
                                                <?php echo e($log->payload_audit['rol'] ?? 'N/A'); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Usuario eliminado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($log->accion_audit == 'login'): ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-sign-in-alt"></i> Login
                                            </span>
                                        <?php elseif($log->accion_audit == 'logout'): ?>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-info"><?php echo e($log->accion_audit); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code><?php echo e($log->ip_address ?? 'N/A'); ?></code>
                                    </td>
                                    <td>
                                        <small class="text-muted" title="<?php echo e($log->user_agent); ?>">
                                            <?php echo e(Str::limit($log->user_agent ?? 'N/A', 40)); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <?php echo e($log->created_at->format('d/m/Y H:i:s')); ?><br>
                                        <small class="text-muted"><?php echo e($log->created_at->diffForHumans()); ?></small>
                                    </td>
                                    <td>
                                        <?php if($log->accion_audit == 'logout' && isset($log->payload_audit['duracion_sesion_minutos'])): ?>
                                            <small class="text-muted">
                                                Duración: <?php echo e($log->payload_audit['duracion_sesion_minutos']); ?> min
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="mt-3">
                    <?php echo e($logs->links()); ?>

                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    No se encontraron registros de auditoría con los filtros seleccionados.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/auditoria/index.blade.php ENDPATH**/ ?>