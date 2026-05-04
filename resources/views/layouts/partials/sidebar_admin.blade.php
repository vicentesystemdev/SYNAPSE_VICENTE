@if(Auth::user()->hasRole('admin'))
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
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
            <p>Roles y Permisos</p>
        </a>
    </li>

    <li class="nav-header">EVALUACIONES</li>
    <li class="nav-item">
        <a href="{{ route('evaluaciones.index') }}" class="nav-link {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>Gestionar Evaluaciones</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.intentos.index') }}" class="nav-link {{ request()->routeIs('admin.intentos.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-pen-alt"></i>
            <p>Resultados de Estudiantes</p>
        </a>
    </li>

    <li class="nav-header">REPORTES Y ANÁLISIS</li>
    <li class="nav-item">
        <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-trophy"></i>
            <p>Ranking Académico</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.reportes_irt.index') }}" class="nav-link {{ request()->routeIs('admin.reportes_irt.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reportes de Desempeño</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.auditoria.index') }}" class="nav-link {{ request()->routeIs('admin.auditoria.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Auditoría</p>
        </a>
    </li>
@endif
