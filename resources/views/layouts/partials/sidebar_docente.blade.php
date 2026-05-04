@if(Auth::user()->hasRole('docente'))
    <li class="nav-item">
        <a href="{{ route('docente.dashboard') }}" class="nav-link {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard Docente</p>
        </a>
    </li>

    <li class="nav-header">GESTIÓN ACADÉMICA</li>
    <li class="nav-item">
        <a href="{{ route('docente.estudiantes.index') }}" class="nav-link {{ request()->routeIs('docente.estudiantes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Mis Estudiantes</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.evaluaciones.index') }}" class="nav-link {{ request()->routeIs('docente.evaluaciones.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>Gestionar Evaluaciones</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.intentos.index') }}" class="nav-link {{ request()->routeIs('docente.intentos.*') ? 'active' : '' }}">
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
        <a href="{{ route('docente.reportes_irt.index') }}" class="nav-link {{ request()->routeIs('docente.reportes_irt.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reportes de Desempeño</p>
        </a>
    </li>
@endif
