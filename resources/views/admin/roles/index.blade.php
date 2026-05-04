@extends('layouts.dashboard')

@section('title', 'Gestión de Roles')

@section('content_header')
    <h1>Gestión de Roles</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles Registrados</h3>
            <div class="card-tools">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Crear Nuevo Rol
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            {{-- Formulario de Búsqueda y Filtro --}}
            <div class="p-3">
                <form action="{{ route('admin.roles.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm mr-2 mb-2">
                        <input type="text" name="search" class="form-control float-right" placeholder="Buscar por nombre" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                    @if (request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                    @endif
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
                        @forelse ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @forelse ($role->permissions->take(5) as $permission)
                                        <span class="badge badge-info">{{ $permission->name }}</span>
                                    @empty
                                        <span class="badge badge-secondary">Sin permisos</span>
                                    @endforelse
                                    @if($role->permissions->count() > 5)
                                        <span class="badge badge-secondary">+{{ $role->permissions->count() - 5 }} más</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.roles.toggle-status', $role->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-xs {{ $role->estado == 1 ? 'btn-success' : 'btn-danger' }}" title="Cambiar Estado">
                                            {{ $role->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-info btn-xs" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay roles registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $roles->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop
