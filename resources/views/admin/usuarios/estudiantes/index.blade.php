@extends('layouts.dashboard')

@section('title', 'Gestión de Estudiantes')

@section('content_header')
    <h1>Gestión de Estudiantes</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Estudiantes Registrados</h3>
            <div class="card-tools">
                <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Crear Nuevo Estudiante
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            {{-- Formulario de Búsqueda y Filtro --}}
            <div class="p-3">
                <form action="{{ route('admin.estudiantes.index') }}" method="GET" class="form-inline">
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
                        <a href="{{ route('admin.estudiantes.index') }}" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                    @endif

                    {{-- Botones de Ordenamiento --}}
                    <a href="{{ route('admin.estudiantes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'asc'])) }}" class="btn btn-default btn-sm ml-2 mb-2" title="Ordenar por ID Ascendente">
                        <i class="fas fa-sort-numeric-up-alt"></i> ID Asc
                    </a>
                    <a href="{{ route('admin.estudiantes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_direction' => 'desc'])) }}" class="btn btn-default btn-sm ml-1 mb-2" title="Ordenar por ID Descendente">
                        <i class="fas fa-sort-numeric-down-alt"></i> ID Desc
                    </a>

                    {{-- Botones de Exportación --}}
                    <a href="{{ route('admin.estudiantes.exportPdf', request()->query()) }}" class="btn btn-danger btn-sm ml-2 mb-2" target="_blank" title="Exportar a PDF">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.estudiantes.exportExcel', request()->query()) }}" class="btn btn-success btn-sm ml-1 mb-2" title="Exportar a Excel">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </form>
            </div>
            {{-- Fin del Formulario de Búsqueda y Filtro --}}

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nro Estudiantes</th> {{-- Nueva columna --}}
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estudiantes as $index => $estudiante) {{-- Usar $index para la numeración --}}
                            <tr>
                                <td>{{ $loop->iteration + ($estudiantes->currentPage() - 1) * $estudiantes->perPage() }}</td> {{-- Numeración 1, 2, 3... --}}
                                <td>{{ $estudiante->id }}</td>
                                <td>{{ $estudiante->name }}</td>
                                <td>{{ $estudiante->app_usu }}</td>
                                <td>{{ $estudiante->apm_usu }}</td>
                                <td>{{ $estudiante->email }}</td>
                                <td>
                                    <form action="{{ route('admin.estudiantes.toggle-status', $estudiante->id) }}" method="POST" class="toggle-status-form" id="toggle-status-form-{{ $estudiante->id }}" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-xs {{ $estudiante->activo_usu ? 'btn-success' : 'btn-danger' }}">
                                            {{ $estudiante->activo_usu ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.estudiantes.edit', $estudiante->id) }}" class="btn btn-info btn-xs mr-1" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- El botón de eliminar se ha quitado porque las eliminaciones son lógicas (activo/inactivo) --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No hay estudiantes registrados.</td> {{-- colspan ajustado a 8 --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $estudiantes->links('pagination::bootstrap-4') }} {{-- Asegúrate de tener una vista de paginación compatible --}}
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes añadir CSS adicional si es necesario --}}
@stop

@section('js')
    @include('components.scripts.toggle-status')
@stop
