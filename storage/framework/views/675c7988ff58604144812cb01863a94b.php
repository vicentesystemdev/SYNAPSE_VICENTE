<?php if(Auth::user()->hasRole('docente')): ?>
    <li class="nav-item">
        <a href="<?php echo e(route('docente.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('docente.dashboard') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>DASHBOARD DOCENTE</p>
        </a>
    </li>

    <li class="nav-header">MIS ESTUDIANTES</li>
    <li class="nav-item">
        <a href="<?php echo e(route('docente.estudiantes.index')); ?>" class="nav-link <?php echo e(request()->routeIs('docente.estudiantes.*') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Listado</p>
        </a>
    </li>

    <li class="nav-header">RETOS</li>
    <li class="nav-item">
        <a href="<?php echo e(route('docente.evaluaciones.index')); ?>" class="nav-link <?php echo e(request()->routeIs('docente.evaluaciones.*') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-flag"></i>
            <p>Evaluaciones</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('docente.intentos.index')); ?>" class="nav-link <?php echo e(request()->routeIs('docente.intentos.*') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-history"></i>
            <p>Intentos</p>
        </a>
    </li>

    <li class="nav-header">REPORTES</li>
    <li class="nav-item">
        <a href="<?php echo e(route('rankings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('rankings.index') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-trophy"></i>
            <p>Rankings</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?php echo e(route('docente.reportes_irt.index')); ?>" class="nav-link <?php echo e(request()->routeIs('docente.reportes_irt.*') ? 'active' : ''); ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reportes IRT</p>
        </a>
    </li>
<?php endif; ?>
<?php /**PATH C:\laragon\www\synapse\resources\views/layouts/partials/sidebar_docente.blade.php ENDPATH**/ ?>