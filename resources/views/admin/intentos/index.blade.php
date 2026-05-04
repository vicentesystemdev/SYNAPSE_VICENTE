@extends('layouts.dashboard')

@section('title', 'Intentos de estudiantes')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Auditoría de intentos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Intentos</h3>
            </div>
            <div class="card-body p-0">
                {{-- Formulario de Búsqueda y Filtro --}}
                <div class="p-3">
                    <form action="{{ route('admin.intentos.index') }}" method="GET" class="form-inline">
                        <div class="input-group input-group-sm mr-2 mb-2">
                            <input type="text" name="search" class="form-control float-right" placeholder="Buscar estudiante o evaluación" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Todos los estados</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Correcto</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Incorrecto</option>
                            </select>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <select name="evaluacion_id" class="form-control form-control-sm">
                                <option value="">Todas las Evaluaciones</option>
                                @foreach ($evaluaciones as $evaluacion)
                                    <option value="{{ $evaluacion->id_eval }}" {{ request('evaluacion_id') == $evaluacion->id_eval ? 'selected' : '' }}>
                                        {{ $evaluacion->titulo_eval }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm mb-2">Filtrar</button>
                        @if (request()->has('search') || request()->has('status') || request()->has('evaluacion_id'))
                            <a href="{{ route('admin.intentos.index') }}" class="btn btn-secondary btn-sm ml-2 mb-2">Limpiar</a>
                        @endif
                        {{-- Botón de Exportar a PDF --}}
                        <a href="{{ route('admin.intentos.exportPdf', request()->query()) }}" class="btn btn-danger btn-sm ml-2 mb-2" target="_blank">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </a>

                        {{-- Botones de Ordenamiento --}}
                        <a href="{{ route('admin.intentos.index', array_merge(request()->query(), ['sort_by' => 'id_int', 'sort_direction' => 'asc'])) }}" class="btn btn-default btn-sm ml-2 mb-2" title="Ordenar por ID Ascendente">
                            <i class="fas fa-sort-numeric-up-alt"></i> ID Asc
                        </a>
                        <a href="{{ route('admin.intentos.index', array_merge(request()->query(), ['sort_by' => 'id_int', 'sort_direction' => 'desc'])) }}" class="btn btn-default btn-sm ml-1 mb-2" title="Ordenar por ID Descendente">
                            <i class="fas fa-sort-numeric-down-alt"></i> ID Desc
                        </a>
                    </form>
                </div>
                {{-- Fin del Formulario de Búsqueda y Filtro --}}

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Intento</th>
                                <th>Estudiante</th>
                                <th>Categoría Evaluación</th> {{-- Texto del encabezado cambiado --}}
                                <th>Nro Intento</th>
                                <th>Respuesta</th>
                                <th>Correcto</th>
                                <th>Fecha Envío</th>
                                <th>Latencia (seg)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($intentos as $intento)
                                <tr>
                                    <td>{{ $intento->id_int }}</td>
                                    <td>{{ $intento->user->name }} {{ $intento->user->app_usu }}</td>
                                    <td>{{ $intento->evaluacion->categoria->nombre_cat ?? 'N/A' }}</td> {{-- Acceder a la categoría de la evaluación --}}
                                    <td>{{ $intento->nro_intento_int }}</td>
                                    <td>{{ $intento->respuesta_flag_int }}</td>
                                    <td>
                                        @if ($intento->es_correcto_int)
                                            <span class="badge badge-success">Sí</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::createFromTimestamp($intento->tiempo_envio_int)->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $intento->latencia_seg_int ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.intentos.show', $intento->id_int) }}" class="btn btn-primary btn-xs" title="Ver Detalles">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay intentos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $intentos->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
