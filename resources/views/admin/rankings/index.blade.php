@extends('layouts.dashboard')

@section('title', 'Rankings Globales')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-fw fa-trophy text-orange-600"></i> Rankings Globales
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card bg-dark custom-card-dark shadow-lg">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white">
                    <i class="fas fa-list-ol mr-1 text-orange-400"></i> Vista de Ranking
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                {{-- Sección del Formulario de Filtrado --}}
                <form action="{{ route('rankings.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="periodo_id" class="text-white-50">Período:</label>
                                <select name="periodo_id" id="periodo_id" class="form-control form-control-sm custom-select-dark">
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id_per }}" @selected(($filters['periodo_id'] ?? null) == $periodo->id_per)>
                                            {{ $periodo->nombre_per }} ({{ $periodo->gestion_per }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="skill_id" class="text-white-50">Categoría (Skill):</label>
                                <select name="skill_id" id="skill_id" class="form-control form-control-sm custom-select-dark">
                                    <option value="">Todas</option> {{-- Opción para no filtrar por categoría --}}
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id_cat }}" @selected(($filters['skill_id'] ?? null) == $skill->id_cat)>
                                            {{ $skill->nombre_cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Nuevo Filtro por Nivel --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nivel" class="text-white-50">Nivel de Prueba:</label>
                                <select name="nivel" id="nivel" class="form-control form-control-sm custom-select-dark">
                                    <option value="">Todos los niveles</option>
                                    <option value="alto" @selected(($filters['nivel'] ?? null) == 'alto')>Alto</option>
                                    <option value="medio" @selected(($filters['nivel'] ?? null) == 'medio')>Medio</option>
                                    <option value="bajo" @selected(($filters['nivel'] ?? null) == 'bajo')>Bajo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3"> {{-- Nueva fila para los botones y que no se desordenen --}}
                        <div class="col-md-12 d-flex justify-content-end"> {{-- Alineación a la derecha para los botones --}}
                            <button type="submit" class="btn btn-primary custom-btn-orange mr-2">
                                <i class="fas fa-filter mr-2"></i> Filtrar Ranking
                            </button>
                            <a href="{{ route('rankings.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-sync-alt mr-2"></i> Resetear
                            </a>

                            {{-- Botones de Exportación --}}
                            <div class="btn-group ml-3" role="group">
                                <a href="{{ route('rankings.csv', $filters) }}" class="btn btn-success custom-btn-excel mr-1" title="Exportar a CSV/Excel">
                                    <i class="fas fa-file-excel mr-1"></i> Excel
                                </a>
                                <a href="{{ route('rankings.pdf', $filters) }}" class="btn btn-danger custom-btn-pdf" title="Exportar a PDF">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Tabla de Ranking --}}
                <table class="table table-dark table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Estudiante</th>
                            <th>Puntaje Total</th>
                            <th>Evaluaciones</th>
                            <th>Última Actualización</th>
                            <th>Nivel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataset as $item)
                            @php
                                $rankingData = (object) $item['ranking'];
                                $userData = (object) $rankingData->user;

                                $nivelColor = 'secondary';
                                $nivelTexto = 'N/D';
                                
                                // Lógica para determinar el nivel basada en theta_global
                                if (isset($rankingData->theta_global)) {
                                     if ($rankingData->theta_global > 1) {
                                        $nivelColor = 'success'; // Alto
                                        $nivelTexto = 'Alto';
                                    } elseif ($rankingData->theta_global >= 0) {
                                        $nivelColor = 'warning'; // Medio
                                        $nivelTexto = 'Medio';
                                    } else {
                                        $nivelColor = 'danger'; // Bajo
                                        $nivelTexto = 'Bajo';
                                    }
                                } elseif (isset($rankingData->puntaje_total)) { // Fallback si no hay theta_global
                                    if ($rankingData->puntaje_total > 200) { // Umbral de ejemplo
                                        $nivelColor = 'success';
                                        $nivelTexto = 'Alto';
                                    } elseif ($rankingData->puntaje_total > 100) { // Umbral de ejemplo
                                        $nivelColor = 'warning';
                                        $nivelTexto = 'Medio';
                                    } else {
                                        $nivelColor = 'danger';
                                        $nivelTexto = 'Bajo';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $rankingData->posicion ?? 'N/D' }}</td>
                                <td>{{ $userData->name ?? 'N/D' }} {{ $userData->app_usu ?? '' }}</td>
                                <td><span class="badge badge-success custom-badge-success">{{ number_format($rankingData->puntaje_total ?? 0, 2) }}</span></td>
                                <td>{{ $item['evaluaciones'] ?? 0 }}</td>
                                <td>{{ optional($item['ultima_actualizacion'])->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D' }}</td>
                                <td><span class="badge badge-{{ $nivelColor }}">{{ $nivelTexto }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-white-50">No hay datos de ranking disponibles para los filtros seleccionados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent text-center">
                {{-- Opciones de paginación o más enlaces --}}
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos personalizados para el selector oscuro */
        .custom-select-dark {
            background-color: #3f4a59 !important;
            color: #ffffff !important;
            border: 1px solid #5a6470 !important;
        }
        .custom-select-dark option {
            background-color: #3f4a59;
            color: #ffffff;
        }
        /* Estilos para el botón naranja */
        .custom-btn-orange {
            background-color: #fb8c00 !important;
            border-color: #fb8c00 !important;
            color: #ffffff !important;
        }
        .custom-btn-orange:hover {
            background-color: #e67c00 !important;
            border-color: #e67c00 !important;
        }
        /* Estilos generales de tarjeta oscura */
        .custom-card-dark {
            background-color: #2d3748 !important; /* Tono oscuro para el card */
            color: #ffffff;
        }
        .custom-card-dark .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-card-dark .card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .custom-card-dark .table {
            color: #ffffff;
        }
        .custom-card-dark .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        /* Insignias personalizadas */
        .badge-success.custom-badge-success {
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        /* Estilos personalizados para botones de Exportación */
        .custom-btn-excel {
            background-color: #28a745 !important; /* Verde de Excel */
            border-color: #28a745 !important;
            color: #ffffff !important;
        }
        .custom-btn-excel:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        .custom-btn-pdf {
            background-color: #dc3545 !important; /* Rojo de PDF */
            border-color: #dc3545 !important;
            color: #ffffff !important;
        }
        .custom-btn-pdf:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
        }
    </style>
@stop

@section('js')
    {{-- Aquí puedes añadir scripts si fueran necesarios --}}
@stop
