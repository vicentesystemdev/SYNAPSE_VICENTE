<li class="nav-item">
    <a href="{{ route('estudiante.dashboard') }}" class="nav-link {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-header">MI APRENDIZAJE</li>
<li class="nav-item">
    <a href="{{ route('evaluaciones.index') }}" class="nav-link {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i>
        <p>Resolver Evaluación</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('estudiante.intentos.index') }}" class="nav-link {{ request()->routeIs('estudiante.intentos.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pen-alt"></i>
        <p>Mis Resultados</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('student.progress') }}" class="nav-link {{ request()->routeIs('student.progress') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>Mi Progreso</p>
    </a>
</li>

<li class="nav-header">COMUNIDAD</li>
<li class="nav-item">
    <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-trophy"></i>
        <p>Ranking Académico</p>
    </a>
</li>

<li class="nav-header">MI CUENTA</li>
<li class="nav-item">
    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-circle"></i>
        <p>Mi Perfil</p>
    </a>
</li>
