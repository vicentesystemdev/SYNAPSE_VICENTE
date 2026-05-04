@if(Auth::user()->hasRole('admin'))
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard global</p>
        </a>
    </li>

    <li class="nav-header">USUARIOS</li>
    <li class="nav-item">
        <a href="{{ route('admin.estudiantes.index') }}" class="nav-link {{ request()->routeIs('admin.estudiantes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Estudiantes</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.docentes.index') }}" class="nav-link {{ request()->routeIs('admin.docentes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Docentes</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Administradores</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-id-card"></i>
            <p>Roles del sistema</p>
        </a>
    </li>

    <li class="nav-header">RETOS</li>
    <li class="nav-item">
        <a href="{{ route('evaluaciones.index') }}" class="nav-link {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-respuesta"></i>
            <p>Evaluaciones</p>
        </a>
    </li>
    <!--<li class="nav-item">
        <a href="{{ route('admin.plantillas.index') }}" class="nav-link {{ request()->routeIs('admin.plantillas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Plantillas</p>
        </a>-->
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.intentos.index') }}" class="nav-link {{ request()->routeIs('admin.intentos.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-history"></i>
            <p>Intentos</p>
        </a>
    </li>

    <li class="nav-header">REPORTES</li>
    <li class="nav-item">
        <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-trophy"></i>
            <p>Rankings</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.reportes_irt.index') }}" class="nav-link {{ request()->routeIs('admin.reportes_irt.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reportes IRT</p>
        </a>
    </li>
    <!--<li class="nav-item">
        <a href="{{ route('admin.exportaciones.index') }}" class="nav-link {{ request()->routeIs('admin.exportaciones.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-export"></i>
            <p>Exportaciones</p>-->
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.auditoria.index') }}" class="nav-link {{ request()->routeIs('admin.auditoria.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Auditoría</p>
        </a>
    </li>
@endif
