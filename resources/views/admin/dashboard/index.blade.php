@extends('layouts.dashboard')

@section('title', 'Dashboard del Administrador')

@section('content_header')
    <h1 class="m-0 text-dark">
            <i class="fas fa-fw fa-tachometer-alt" style="color:#3b5bdb"></i> PANEL DE ADMINISTRACIÓN — INTELECTA
    </h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    <div class="container-fluid">
        {{-- Sección de Bienvenida y Resumen General --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-dark custom-gradient-bg border-0 shadow-lg"> {{-- Clase custom-gradient-bg para el color --}}
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white">
                            <i class="fas fa-chart-pie mr-2" style="color:#748ffc"></i> Visión General del Sistema INTELECTA
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-warning custom-badge-warning text-dark">{{ $periodoActual->nombre_per ?? 'Sin período' }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-white-50">
                            Supervisa el rendimiento global, gestiona usuarios y contenido, y asegura la integridad de la plataforma. Accede a todas las herramientas de gestión desde el menú lateral.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary custom-btn-orange-outline mr-2">
                                <i class="fas fa-user-plus mr-2"></i> Crear Nuevo Administrador
                            </a>
                            <a href="{{ route('evaluaciones.create') }}" class="btn btn-info custom-btn-teal">
                                <i class="fas fa-plus-square mr-2"></i> Crear Nueva Evaluación
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjetas de resumen (small-box) para métricas clave --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info custom-small-box-blue shadow-md">
                    <div class="inner">
                        <h3>{{ $studentCount }}</h3>
                        <p>Total de Estudiantes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('admin.estudiantes.index') }}" class="small-box-footer">Ver estudiantes <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success custom-small-box-green shadow-md">
                    <div class="inner">
                        <h3>{{ $evaluacionesPublicadas }}</h3>
                        <p>Evaluaciones Publicadas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('evaluaciones.index') }}" class="small-box-footer">Gestionar evaluaciones <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning custom-small-box-yellow shadow-md">
                    <div class="inner">
                        <h3>{{ $evaluacionesCerradas }}</h3>
                        <p>Evaluaciones Cerradas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ route('evaluaciones.index') }}" class="small-box-footer">Ver historial <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-orange custom-small-box-orange shadow-md">
                    <div class="inner">
                        <h3>{{ $totalDocentes }}</h3> {{-- Mostrar el total de docentes --}}
                        <p>Total de Docentes</p> {{-- Texto actualizado --}}
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i> {{-- Cambiar el ícono si lo deseas, por ejemplo, a un ícono de persona o grupo --}}
                    </div>
                    <a href="{{ route('admin.docentes.index') }}" class="small-box-footer">Ver docentes <i class="fas fa-arrow-circle-right"></i></a> {{-- Enlace a la gestión de docentes --}}
                </div>
            </div>
        </div>

        {{-- Sección de Gráficos y Tablas dinámicas --}}
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                {{-- Gráfico de Distribución de Habilidades (IRT Global) --}}
                <div class="card bg-white custom-card-white shadow-lg"> {{-- Cambiado a bg-white --}}
                    <div class="card-header border-0">
                        <h3 class="card-title text-black"> {{-- Texto negro --}}
                            <i class="fas fa-chart-line mr-1 text-orange-400"></i>
                            Distribución de Habilidades (IRT Global)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-black" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-secondary text-center">Gráfico de la distribución de estudiantes por niveles (Bajo, Medio, Alto) según su theta global.</p>
                        <div class="chart-responsive">
                            <canvas id="irtAbilityChart" height="300"></canvas>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('admin.reportes_irt.index') }}" class="btn btn-link text-orange-400">Ver Reportes IRT Completos <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{-- Tabla Top 5 Ranking --}}
                <div class="card bg-white custom-card-white shadow-lg"> {{-- Cambiado a bg-white --}}
                    <div class="card-header border-0">
                        <h3 class="card-title text-black"> {{-- Texto negro --}}
                            <i class="fas fa-trophy mr-1 text-orange-400"></i> Top 5 del Ranking (Período Actual)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-black" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-dark table-striped table-valign-middle">
                            <thead class="text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Estudiante</th>
                                    <th>Puntaje</th>
                                    <th>Theta Global</th>
                                    <th>Nivel</th>
                                </tr>
                            </thead>
                            <tbody class="text-white">
                                @forelse($topRanking as $key => $item)
                                    @php
                                        $ranking = $item->get('ranking');
                                        if ($ranking && !$ranking->relationLoaded('user')) {
                                            $ranking->load('user');
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $ranking->user?->name ?? 'N/D' }} {{ $ranking->user?->app_usu ?? '' }}</td>
                                        <td><span class="badge badge-success custom-badge-success">{{ number_format($ranking->puntaje_total, 2) }}</span></td>
                                        <td>{{ number_format($ranking->theta_global, 2) }}</td>
                                        <td>
                                            @php
                                                $nivelColor = 'secondary';
                                                $nivelTexto = 'N/D';
                                                if ($ranking->theta_global > 1) {
                                                    $nivelColor = 'success'; $nivelTexto = 'Alto';
                                                } elseif ($ranking->theta_global >= 0) {
                                                    $nivelColor = 'warning'; $nivelTexto = 'Medio';
                                                } else {
                                                    $nivelColor = 'danger'; $nivelTexto = 'Bajo';
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $nivelColor }}">{{ $nivelTexto }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay datos de ranking para el período actual.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <a href="{{ route('rankings.index') }}" class="btn btn-link text-orange-400">Ver Ranking Completo <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 connectedSortable">
                {{-- Gráfico Heatmap de Puntajes por Área --}}
                <div class="card bg-gradient-primary custom-gradient-primary shadow-lg">
                    <div class="card-header border-0">
                        <h3 class="card-title text-white">
                            <i class="fas fa-grip-lines-vertical mr-1 text-orange-400"></i> Heatmap de Puntajes por Área
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                <i class="far fa-calendar-alt"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-white-50">Visualiza la distribución de puntajes acumulados por área en el período actual.</p>
                        <div class="chart-responsive">
                            <canvas id="categoryHeatmapChart" height="200"></canvas>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between text-white-50">
                            <span>Total por Área</span>
                            <span>{{ $heatmap->sum('total') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actividad Reciente del Sistema (Auditoría) --}}
                <div class="card bg-white custom-card-white shadow-lg"> {{-- Cambiado a bg-white --}}
                    <div class="card-header border-0">
                        <h3 class="card-title text-black"> {{-- Texto negro --}}
                            <i class="fas fa-history mr-1 text-orange-400"></i> Actividad Reciente del Sistema
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-black" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @forelse($recentActivities as $activity)
                                <li class="item">
                                    <div class="product-img">
                                        @php
                                            $icon = 'fa-info-circle';
                                            $color = 'text-info';
                                            if (str_contains($activity->accion_audit, 'login')) { $icon = 'fa-sign-in-alt'; $color = 'text-success'; }
                                            elseif (str_contains($activity->accion_audit, 'logout')) { $icon = 'fa-sign-out-alt'; $color = 'text-danger'; }
                                            elseif (str_contains($activity->accion_audit, 'create')) { $icon = 'fa-plus-circle'; $color = 'text-primary'; }
                                            elseif (str_contains($activity->accion_audit, 'update')) { $icon = 'fa-edit'; $color = 'text-warning'; }
                                            elseif (str_contains($activity->accion_audit, 'delete')) { $icon = 'fa-trash'; $color = 'text-danger'; }
                                            elseif (str_contains($activity->accion_audit, 'evaluacion')) { $icon = 'fa-respuesta-checkered'; $color = 'text-purple'; }
                                        @endphp
                                        <i class="fas {{ $icon }} {{ $color }} fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title text-black">
                                            {{ ucfirst($activity->accion_audit) }} - {{ $activity->entidad_audit }}
                                            <span class="badge badge-warning float-right">{{ $activity->created_at->diffForHumans() }}</span>
                                        </a>
                                        <span class="product-description text-secondary">
                                            Usuario: {{ $activity->user->name ?? 'Sistema' }} - {{ Str::limit(json_encode($activity->payload_audit), 50) }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="item">
                                    <p class="text-center text-muted">No hay actividad reciente registrada.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center bg-transparent">
                        <a href="{{ route('admin.auditoria.index') }}" class="uppercase btn btn-link text-orange-400">Ver todo el registro de auditoría <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </section>
        </div>

    </div><!-- /.container-fluid -->
@stop

@section('js')
    {{-- Aquí irían los scripts para los gráficos (Chart.js recomendado) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            // Datos para el Gráfico de Distribución de Habilidades (IRT Global)
            // Ya el controlador AdminDashboardController pasa estos datos: $habilidadLabels, $habilidadDistribucion
            const irtAbilityLabels = @json($habilidadLabels);
            const irtAbilityDataValues = @json($habilidadDistribucion);

            const irtAbilityData = {
                labels: irtAbilityLabels,
                datasets: [{
                    label: 'Número de Estudiantes',
                    backgroundColor: [
                        '#dc3545', // Bajo (Naranja)
                        '#ffc107', // Medio (Naranja claro)
                        '#28a745'  // Alto (Negro, si quieres destacar el más alto con otro color o usar blanco)
                        // Alternativa: ['#dc3545', '#ffc107', '#28a745'] si quieres Bajo/Medio/Alto con semáforo
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    data: irtAbilityDataValues
                }]
            };

            const irtAbilityOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: 'white' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: 'white' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: 'white' }
                    }
                }
            };

            const irtAbilityCtx = document.getElementById('irtAbilityChart').getContext('2d');
            new Chart(irtAbilityCtx, {
                type: 'bar',
                data: irtAbilityData,
                options: irtAbilityOptions
            });

            // Datos para el Gráfico Heatmap de Puntajes por Área
            // Los datos 'heatmap' ya están disponibles en el controlador: $heatmap
            const categoryLabels = @json($heatmap->pluck('categoria'));
            const categoryData = @json($heatmap->pluck('total'));

            // Definir una paleta de colores para el Heatmap de Áreas de evaluación (naranjas y tonos de gris)
            const categoryColors = [
                '#FF5722', // Naranja primario
                '#FF8A3D', // Naranja claro
                '#F5F5F5', // Blanco/Gris claro
                '#E0E0E0', // Gris muy claro
                '#CCCCCC', // Gris medio
                '#999999', // Gris oscuro
                '#666666'  // Otro gris oscuro
            ];

            const categoryHeatmapData = {
                labels: categoryLabels,
                datasets: [{
                    label: 'Puntaje Total',
                    backgroundColor: categoryColors.slice(0, categoryLabels.length), // Usar colores de la paleta
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    data: categoryData
                }]
            };

            const categoryHeatmapOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: 'white' }
                    }
                }
                // Si es un doughnut/pie, no necesitas escalas x/y
            };

            const categoryHeatmapCtx = document.getElementById('categoryHeatmapChart').getContext('2d');
            new Chart(categoryHeatmapCtx, {
                type: 'doughnut',
                data: categoryHeatmapData,
                options: categoryHeatmapOptions
            });

            // Más inicializaciones de gráficos si los agregas
        });
    </script>
@stop

{{-- Estilos personalizados para la paleta de colores --}}
@section('css')
    <style>
        /* Variables de color de tu proyecto (actualizadas a la nueva paleta) */
        :root {
            --color-black: #1e2a45;
            --color-dark-gray: #2d3f6b;
            --color-light-gray: #f0f4ff;
            --color-white: #ffffff;
            --color-orange-primary: #3b5bdb;
            --color-orange-hover: #2f4ac2;
            --color-orange-light: #748ffc;
            --color-border-subtle: #dee2e6;
            --color-text-dark: #212529;
            --color-text-light: #f8f9fa;
            --font-family-primary: 'Source Sans Pro', sans-serif;
        }

        /* ****** IMPORTANTE: CORREGIR EL COLOR DEL TEXTO PRINCIPAL ****** */
        /* La variable --color-text-dark debería ser un gris oscuro o negro para el contraste */
        /* Si rgb(221, 59, 19) es el color del texto de los párrafos, es un naranja muy brillante. */
        /* Sugiero cambiar --color-text-dark a un gris oscuro o negro: */
        /* --color-text-dark: #333333; */

        /* Puedes revisar los estilos de AdminLTE para small-box y cards */
        /* Asegurarte de que .text-white-50 y otros textos se vean bien con los nuevos fondos */
        .custom-gradient-bg {
            background: linear-gradient(135deg, var(--color-dark-gray) 0%, var(--color-black) 100%) !important;
            color: var(--color-text-light); /* Texto claro sobre este fondo oscuro */
        }
        .custom-badge-warning {
            background-color: var(--color-orange-primary) !important;
            color: var(--color-white) !important;
        }

        /* Small-box colors adaptados */
        .custom-small-box-blue { /* Cambiado a tonos de naranja y negro/gris */
            background: linear-gradient(45deg, var(--color-orange-primary), var(--color-orange-hover)) !important;
            color: var(--color-white);
        }
        .custom-small-box-green { /* Cambiado a tonos de naranja y negro/gris */
            background: linear-gradient(45deg, var(--color-orange-light), var(--color-orange-primary)) !important;
            color: var(--color-white);
        }
        .custom-small-box-yellow { /* Cambiado a tonos de naranja y negro/gris */
            background: linear-gradient(45deg, var(--color-dark-gray), var(--color-black)) !important;
            color: var(--color-white);
        }
        .custom-small-box-orange { /* Nuevo estilo naranja vivo */
            background: linear-gradient(45deg, #FF9800, #F57C00) !important;
            color: var(--color-white);
        }
        .custom-small-box-red { /* Cambiado a tonos de naranja y negro/gris */
            background: linear-gradient(45deg, var(--color-black), var(--color-dark-gray)) !important;
            color: var(--color-white);
        }
        
        /* Tarjetas (cards) */
        .card {
            background-color: var(--color-white);
            color: var(--color-text-dark); /* Texto oscuro en tarjetas blancas */
            border: 1px solid var(--color-border-subtle);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            background-color: var(--color-light-gray);
            color: var(--color-text-dark);
            border-bottom: 1px solid var(--color-border-subtle);
        }
        .card-title {
            color: var(--color-text-dark);
        }
        .card-title i {
            color: var(--color-orange-primary); /* Iconos de tarjeta naranjas */
        }
        .card-body p {
            color: var(--color-text-dark); /* Párrafos en cards, texto oscuro */
        }
        .custom-card-dark { /* Redefinir para el nuevo tema */
            background-color: var(--color-white) !important;
            color: var(--color-text-dark) !important;
            border: 1px solid var(--color-border-subtle);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .custom-card-dark .card-header {
            background-color: var(--color-light-gray) !important;
            color: var(--color-text-dark) !important;
            border-bottom: 1px solid var(--color-border-subtle) !important;
        }
        .custom-card-dark .table {
            color: var(--color-text-dark) !important;
        }
        .custom-card-dark .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }
        .text-white { /* Asegurar que el texto que usa text-white se ajuste */
            color: var(--color-text-dark) !important;
        }
        .text-white-50 { /* Asegurar que el texto que usa text-white-50 se ajuste */
            color: var(--color-text-dark) !important;
        }
        .text-orange-400, .text-orange-600, .text-orange-300 { /* Mantener el naranja para acentos */
            color: var(--color-orange-primary) !important;
        }

        /* Botones */
        .custom-btn-orange-outline {
            color: var(--color-orange-primary);
            border-color: var(--color-orange-primary);
            background-color: transparent;
        }
        .custom-btn-orange-outline:hover {
            color: var(--color-white);
            background-color: var(--color-orange-hover);
            border-color: var(--color-orange-hover);
        }
        .custom-btn-teal { /* Redefinir para usar naranja */
            background-color: var(--color-orange-primary);
            border-color: var(--color-orange-primary);
            color: var(--color-white);
        }
        .custom-btn-teal:hover {
            background-color: var(--color-orange-hover);
            border-color: var(--color-orange-hover);
        }
        .btn-link { /* Enlaces en el footer de las tarjetas */
            color: var(--color-orange-primary) !important;
        }

        /* Estilos de gráficos */
        .chart-responsive {
            background-color: var(--color-dark-gray); /* Fondo oscuro para el área del gráfico */
            padding: 1rem;
            border-radius: 5px;
        }
        /* Ajustar los colores de las escalas y etiquetas de los gráficos si es necesario */
        canvas {
            color: var(--color-text-light); /* Color general de texto en canvas */
        }
    </style>
@stop
