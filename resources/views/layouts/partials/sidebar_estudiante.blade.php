<li class="nav-item">
    <a href="{{ route('estudiante.dashboard') }}" class="nav-link {{ request()->routeIs('estudiante.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Inicio</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('evaluaciones.index') }}" class="nav-link {{ request()->routeIs('evaluaciones.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-flag"></i>
        <p>Evaluaciones</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('estudiante.intentos.index') }}" class="nav-link {{ request()->routeIs('estudiante.intentos.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>Intentos</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Perfil</p>
    </a>
</li>
