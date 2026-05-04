@if(Auth::user()->hasRole('docente'))
    <li class="nav-item">
        <a href="{{ route('docente.dashboard') }}" class="nav-link {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>DASHBOARD DOCENTE</p>
        </a>
    </li>

    <li class="nav-header">MIS ESTUDIANTES</li>
    <li class="nav-item">
        <a href="{{ route('docente.estudiantes.index') }}" class="nav-link {{ request()->routeIs('docente.estudiantes.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Listado</p>
        </a>
    </li>

    <li class="nav-header">RETOS</li>
    <li class="nav-item">
        <a href="{{ route('docente.evaluaciones.index') }}" class="nav-link {{ request()->routeIs('docente.evaluaciones.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-respuesta"></i>
            <p>Evaluaciones</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.intentos.index') }}" class="nav-link {{ request()->routeIs('docente.intentos.*') ? 'active' : '' }}">
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
        <a href="{{ route('docente.reportes_irt.index') }}" class="nav-link {{ request()->routeIs('docente.reportes_irt.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reportes IRT</p>
        </a>
    </li>
@endif
