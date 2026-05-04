@extends('layouts.dashboard')

@section('title', 'Gestión de Administradores')

@section('content_header')
    <h1>Gestión de Administradores</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administradores Registrados</h3>
            <div class="card-tools">
                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Crear Nuevo Administrador
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            {{-- Formulario de Búsqueda y Filtro --}}
            <div class="p-3">
                <form action="{{ route('admin.admins.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm mr-2 mb-2">
                        <input type="text" name="search" class="form-control float-right" placeholder="Buscar por nombre o apellido" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                    @if (request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                    @endif

                    {{-- Botones de Ordenamiento --}}
                    <a href="{{ route('admin.admins.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'asc'])) }}" class="btn btn-default btn-sm ml-2 mb-2" title="Ordenar por ID Ascendente">
                        <i class="fas fa-sort-numeric-up-alt"></i> ID Asc
                    </a>
                    <a href="{{ route('admin.admins.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'desc'])) }}" class="btn btn-default btn-sm ml-1 mb-2" title="Ordenar por ID Descendente">
                        <i class="fas fa-sort-numeric-down-alt"></i> ID Desc
                    </a>

                    {{-- Botones de Exportación --}}
                    <a href="{{ route('admin.admins.exportPdf', request()->query()) }}" class="btn btn-danger btn-sm ml-2 mb-2" target="_blank" title="Exportar a PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.admins.exportExcel', request()->query()) }}" class="btn btn-success btn-sm ml-1 mb-2" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </form>
            </div>
            {{-- Fin del Formulario de Búsqueda y Filtro --}}

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nro Admins</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $index => $admin)
                            <tr>
                                <td>{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <form action="{{ route('admin.admins.toggle-status', $admin->id) }}" method="POST" class="toggle-status-form" id="toggle-status-form-{{ $admin->id }}" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-xs {{ $admin->activo_usu ? 'btn-success' : 'btn-danger' }}">
                                            {{ $admin->activo_usu ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-info btn-xs mr-1" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- El botón de eliminar se ha quitado porque las eliminaciones son lógicas (activo/inactivo) --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No hay administradores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $admins->links('pagination::bootstrap-4') }} {{-- Asegúrate de tener una vista de paginación compatible --}}
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes añadir CSS adicional si es necesario --}}
@stop

@section('js')
    @include('components.scripts.toggle-status')
@stop
