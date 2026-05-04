@extends('layouts.dashboard')

@section('title', 'Reportes IRT Avanzados')

@section('content_header')
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-white" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
            <i class="fas fa-fw fa-chart-line mr-3"></i> Reportes IRT Avanzados
        </h1>
      </div>
    </div>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Controles de Selección --}}
        <div class="card shadow-lg mb-4"> {{-- Eliminado bg-dark y custom-card-dark, ya se aplica en el layout --}}
            <div class="card-header"> {{-- Eliminado border-0 y d-flex, ya se aplica en el layout --}}
                <h3 class="card-title"><i class="fas fa-microscope mr-2"></i> Demostración Interactiva IRT</h3> {{-- Icono y texto ya con estilos del layout --}}
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_search_input" class="text-white">Buscar Estudiante:</label>
                            <div class="input-group">
                                <input type="text" id="student_search_input" class="form-control custom-input-dark" placeholder="Buscar por nombre o apellido o email..." autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary custom-btn-dark-outline" type="button" id="student_search_button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- Lista de sugerencias de autocompletado --}}
                            <div id="student_suggestions_container" class="list-group position-absolute w-100 z-index-1000 mt-1" style="display: none; max-height: 200px; overflow-y: auto;">
                                {{-- Las sugerencias se insertarán aquí --}}
                            </div>
                            <input type="hidden" id="selected_student_id" value=""> {{-- Campo oculto para guardar el ID del estudiante seleccionado --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_selector" class="text-white">Seleccionar Área para Matriz de Markov:</label> {{-- Texto label blanco --}}
                            <select id="category_selector" class="form-control custom-select-dark"> {{-- Eliminado form-control-sm --}}
                                <option value="">--- Seleccione una área ---</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_cat }}">{{ $categoria->nombre_cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-4"> {{-- Ajustado margen superior --}}
                        <button id="load_data_btn" class="btn btn-primary custom-btn-teal"><i class="fas fa-sync-alt mr-2"></i> Cargar Datos del Estudiante</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resultados de la Demostración --}}
        <div id="demonstration_results" style="display:none;">
            <div class="row">
                {{-- Tarjeta de Datos del Estudiante --}}
                <div class="col-md-6">
                    <div class="card shadow-lg"> {{-- Eliminado card-primary card-outline custom-card-dark --}}
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-graduate mr-2"></i> Datos del Estudiante Seleccionado</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-4"> {{-- Añadido margen inferior --}}
                                <dt class="col-sm-4 text-white-50">Nombre:</dt>
                                <dd class="col-sm-8 text-white" id="student_name"></dd> {{-- Texto blanco --}}

                                <dt class="col-sm-4 text-white-50">Email:</dt>
                                <dd class="col-sm-8 text-white" id="student_email"></dd> {{-- Texto blanco --}}

                                <dt class="col-sm-4 text-white-50">Theta Global:</dt>
                                <dd class="col-sm-8 text-white" id="student_theta_global"></dd> {{-- Texto blanco --}}

                                <dt class="col-sm-4 text-white-50">Nivel Global:</dt>
                                <dd class="col-sm-8"><span class="badge" id="student_nivel_global"></span></dd>
                            </dl>
                            <h5 class="mt-4 text-orange-primary">Habilidad y Rendimiento por Área:</h5> {{-- Color de texto naranja --}}
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-valign-middle">
                                    <thead>
                                        <tr>
                                            <th>Área</th>
                                            <th>Theta</th>
                                            <th>Nivel</th>
                                            <th>EMA</th>
                                            <th>Muestras EMA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="skill_performance_table_body">
                                        <tr><td colspan="5" class="text-center text-white-50">Seleccione un estudiante para ver el detalle.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de Recomendación y Explicación --}}
                <div class="col-md-6">
                    <div class="card shadow-lg"> {{-- Eliminado card-info card-outline custom-card-dark --}}
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i> Recomendación Adaptativa</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="text-orange-primary">Evaluaciones Recomendadas Por SYNAPSE:</h5> {{-- Color de texto naranja --}}
                            <ul id="recommended_evaluations_list" class="list-group list-group-flush"> {{-- Eliminado bg-dark --}}
                                <li class="list-group-item bg-dark text-white-50">Seleccione un estudiante para ver las recomendaciones.</li>
                            </ul>
                            <h5 class="mt-4 text-orange-primary">Recomendación de SYNAPSE:</h5> {{-- CAMBIADO: Título a "Explicación del Sistema" --}}
                            <div class="info-panel"> {{-- NUEVO: Contenedor para el info panel --}}
                                <p id="recommendation_explanation" class="text-white-50">Las evaluaciones recomendadas se basan en tu nivel de habilidad actual, rendimiento histórico y probabilidades de transición en cadenas de Markov. El objetivo es maximizar la información obtenida sobre tu habilidad.</p> {{-- Párrafo movido dentro del info-panel --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NUEVO: Recuadro para el Gráfico de Radar de Habilidad por Área --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-area mr-2"></i> Distribución de habilidad en las Áreas de evaluación
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-white-50 text-center mb-4">Visualización de la habilidad del estudiante en las áreas clave.</p>
                            <div class="chart-responsive">
                                <canvas id="habilidadRadarChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Restaurado: Recuadro para el Gráfico de Crecimiento y Decaimiento Exponencial --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i> Crecimiento y Decaimiento de Habilidad en la Área Seleccionada
                            </h3>
                            <div class="card-tools">
                                {{-- Se elimina el selector de área de aquí, usará el principal --}}
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-white-50 text-center mb-4">Muestra cómo la habilidad (Theta) y el rendimiento (EMA) del estudiante evolucionan prueba tras prueba en la área seleccionada.</p>
                            <div class="chart-responsive">
                                <canvas id="growthDecayChart" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4"> {{-- Esta era la fila de los gráficos, se mantiene y se ajusta el margen --}}
                {{-- Gráfico de Distribución de Habilidades (theta global) --}}
                <section class="col-lg-6">
                    <div class="card shadow-lg"> {{-- Eliminado custom-card-dark --}}
                <div class="card-header">
                    <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-2"></i> Distribución de Nivel de Habilidad (Global)
                    </h3>
                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                            <p class="text-white-50 text-center mb-4">Concentración de estudiantes por niveles de habilidad (Bajo, Medio, Alto).</p> {{-- Ajustado margen inferior --}}
                    <div class="chart-responsive">
                        <canvas id="habilidadIrtChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </section>

                {{-- Tabla de Matriz de Transición de Markov --}}
        <section class="col-lg-6">
                    <div class="card shadow-lg"> {{-- Eliminado custom-card-dark --}}
                        <div class="card-header"> {{-- Eliminado d-flex justify-content-between align-items-center --}}
                    <h3 class="card-title">
                                <i class="fas fa-project-diagram mr-2"></i> Matriz de Transición de Markov (Global / por Área)
                    </h3>
                    <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                            <p class="text-white-50 text-center mb-4">Probabilidades de transición entre los niveles de habilidad de los estudiantes.</p> {{-- Ajustado margen inferior --}}
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Desde \ Hacia</th>
                                    <th>Bajo</th>
                                    <th>Medio</th>
                                    <th>Alto</th>
                                </tr>
                            </thead>
                                    <tbody id="markov_matrix_table_body">
                                        <tr><td colspan="4" class="text-center text-white-50">Seleccione una área para ver la matriz.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
         /* Reusing variables or defining local overrides for Report components */
        :root {
            --color-orange-primary: #FF8C00;
            --color-orange-hover: #FFA500;
            --color-white: #F0F6FC;
            --color-light-gray: #C9D1D9;
            --color-medium-gray: #21262D;
            --color-dark-gray: #161B22;
        }

        /* Adjust specific elements for the dashboard theme */
        
        /* Badges */
        .badge-bajo {
            background-color: #EF4444 !important;
            color: white !important;
        }
        .badge-medio {
            background-color: #FACC15 !important;
            color: black !important;
        }
        .badge-alto {
            background-color: #22C55E !important;
            color: white !important;
        }

        /* Custom Inputs to match dark theme */
        .custom-input-dark, .custom-select-dark {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .custom-select-dark option {
            color: black !important;
            background-color: white !important;
        }
        .custom-input-dark:focus, .custom-select-dark:focus {
             background-color: rgba(255, 255, 255, 0.1) !important;
             color: white !important;
             border-color: var(--color-orange-primary) !important;
        }
        
        /* Buttons */
        .custom-btn-teal {
             background: linear-gradient(90deg, var(--color-orange-primary) 0%, #FF6347 100%) !important;
             border: none !important;
             color: white !important;
        }
        .custom-btn-dark-outline {
             background-color: rgba(255, 255, 255, 0.05) !important;
             border-color: rgba(255, 255, 255, 0.1) !important;
             color: white !important;
        }
        .custom-btn-dark-outline:hover {
             background-color: rgba(255, 255, 255, 0.1) !important;
             color: var(--color-orange-primary) !important;
        }

        /* Info Panel */
        .info-panel {
             background-color: rgba(244, 107, 8, 0.2) !important;
             border-left: 4px solid var(--color-orange-primary);
             padding: 10px;
             border-radius: 4px;
        }
        
        /* Text Utils */
        .text-orange-primary { color: var(--color-orange-primary) !important; }
        .text-white-50 { color: rgba(255, 255, 255, 0.5) !important; }

        /* Suggestions Container */
        #student_suggestions_container {
            background-color: #1a1a1a;
            border: 1px solid #333;
        }
        #student_suggestions_container .list-group-item {
             background-color: #1a1a1a;
             color: #ccc;
             border-color: #333;
        }
        #student_suggestions_container .list-group-item:hover {
             background-color: #333;
             color: var(--color-orange-primary);
        }
        
        /* Tables in this view */
        .table-dark th {
             color: var(--color-orange-primary);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const studentSearchInput = $('#student_search_input');
            const studentSearchButton = $('#student_search_button');
            const studentSuggestionsContainer = $('#student_suggestions_container');
            const selectedStudentIdInput = $('#selected_student_id'); // El input oculto para el ID
            const categorySelector = $('#category_selector');
            const loadDataBtn = $('#load_data_btn');
            const demonstrationResults = $('#demonstration_results');

            const studentName = $('#student_name');
            const studentEmail = $('#student_email');
            const studentThetaGlobal = $('#student_theta_global');
            const studentNivelGlobal = $('#student_nivel_global');
            const skillPerformanceTableBody = $('#skill_performance_table_body');

            const recommendedEvaluationsList = $('#recommended_evaluations_list');
            const recommendationExplanation = $('#recommendation_explanation');

            const markovMatrixTableBody = $('#markov_matrix_table_body');
            let habilidadChartInstance = null;
            let habilidadRadarChartInstance = null;
            let growthDecayChartInstance = null; // Restaurado: Instancia para el gráfico de crecimiento/decaimiento

            // Función para actualizar el badge de nivel
            function updateNivelBadge(element, nivel) {
                element.text(nivel);
                element.removeClass('badge-bajo badge-medio badge-alto');
                if (nivel) {
                    element.addClass('badge-' + nivel.toLowerCase());
                }
            }

            // Función para construir la explicación de la recomendación
            function buildRecommendationExplanation(recomendaciones) {

                let explanation = ''; // Inicializar explanation como vacío

                explanation += '<p class="text-white-50 mt-3">Esta selección se basa en un algoritmo adaptativo que considera el nivel de habilidad IRT actual del estudiante, su rendimiento histórico (EMA) y las probabilidades de transición en las cadenas de Markov. El objetivo es proporcionar evaluaciones que maximicen la información obtenida sobre la habilidad del estudiante, buscando un desafío óptimo.</p>';
                
                return explanation;
            }

            // Función para actualizar el gráfico de distribución de habilidad
            function updateHabilidadChart(dataCounts) {
                if (habilidadChartInstance) {
                    habilidadChartInstance.data.datasets[0].data = [
                        dataCounts.bajo || 0,
                        dataCounts.medio || 0,
                        dataCounts.alto || 0
                    ];
                    habilidadChartInstance.update();
                }
            }

            // Función para cargar la matriz de Markov
            function loadMarkovMatrix(categoryId) {
                if (!categoryId) {
                    markovMatrixTableBody.html('<tr><td colspan="4" class="text-center text-white-50">Seleccione una área para ver la matriz.</td></tr>');
                    return;
                }

                $.ajax({
                    url: '{{ route('docente.reportes_irt.getMarkovMatrix') }}',
                    method: 'GET',
                    data: { categoria_id: categoryId },
                    success: function(response) {
                        markovMatrixTableBody.empty();
                        const estados = response.estados;
                        const matriz = response.matriz;

                        if (Object.keys(matriz).length > 0) {
                            estados.forEach(function(origen) {
                                let rowHtml = `<tr><td><strong>${origen.charAt(0).toUpperCase() + origen.slice(1)}</strong></td>`;
                                estados.forEach(function(destino) {
                                    const prob = matriz[origen] && matriz[origen][destino] !== undefined ? matriz[origen][destino].toFixed(2) : '0.00';
                                    rowHtml += `<td>${prob}</td>`;
                                });
                                rowHtml += `</tr>`;
                                markovMatrixTableBody.append(rowHtml);
                            });
                        } else {
                            markovMatrixTableBody.html('<tr><td colspan="4" class="text-center text-white-50">No hay suficientes datos de transiciones para esta área.</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error al cargar la matriz de Markov:', xhr.responseText);
                        markovMatrixTableBody.html('<tr><td colspan="4" class="text-center text-white-50">Error al cargar la matriz.</td></tr>');
                    }
                });
            }

            // Función para cargar y actualizar el gráfico de crecimiento/decaimiento
            function loadGrowthDecayChart(userId, categoryId) {
                if (!userId || !categoryId) {
                    if (growthDecayChartInstance) {
                        growthDecayChartInstance.data.labels = [];
                        growthDecayChartInstance.data.datasets[0].data = [];
                        growthDecayChartInstance.data.datasets[1].data = [];
                        growthDecayChartInstance.update();
                    }
                    return;
                }

                $.ajax({
                    url: '{{ route('docente.reportes_irt.getGrowthDecayHistory') }}',
                    method: 'GET',
                    data: { user_id: userId, categoria_id: categoryId },
                    success: function(response) {
                        console.log('Respuesta de historial de crecimiento/decaimiento:', response); // Depuración frontend
                        if (growthDecayChartInstance) {
                            if (response.history && response.history.length > 0) {
                                const labels = response.history.map(item => item.fecha);
                                const emaData = response.history.map(item => item.ema);
                                const thetaData = response.history.map(item => item.theta);

                                // --- INICIO DE DEPURACIÓN FRONTE-END ---
                                console.log('Labels para gráfico:', labels);
                                console.log('EMA Data para gráfico:', emaData);
                                console.log('Theta Data para gráfico:', thetaData);
                                // --- FIN DE DEPURACIÓN FRONTE-END ---

                                growthDecayChartInstance.data.labels = labels;
                                growthDecayChartInstance.data.datasets[0].data = emaData;
                                growthDecayChartInstance.data.datasets[1].data = thetaData;

                                // --- NUEVO: Ajustar dinámicamente el rango del eje Y ---
                                // Calcular min/max de todos los datos para ajustar la escala Y
                                const allValues = [...emaData, ...thetaData];
                                if (allValues.length > 0) {
                                    const yMin = Math.min(...allValues);
                                    const yMax = Math.max(...allValues);
                                    const yPadding = (yMax - yMin) * 0.1 || 0.1; // 10% de padding o 0.1 si el rango es muy pequeño

                                    growthDecayChartInstance.options.scales.y.min = Math.floor(yMin - yPadding);
                                    growthDecayChartInstance.options.scales.y.max = Math.ceil(yMax + yPadding);
                                } else {
                                    // Valores por defecto si no hay datos
                                    growthDecayChartInstance.options.scales.y.min = -1;
                                    growthDecayChartInstance.options.scales.y.max = 1;
                                }
                                // --- FIN DE AJUSTE DINÁMICO ---

                            } else {
                                growthDecayChartInstance.data.labels = ['Sin datos'];
                                growthDecayChartInstance.data.datasets[0].data = [0];
                                growthDecayChartInstance.data.datasets[1].data = [0];
                                // Restablecer la escala a un valor por defecto si no hay datos
                                growthDecayChartInstance.options.scales.y.min = -1;
                                growthDecayChartInstance.options.scales.y.max = 1;
                            }
                            growthDecayChartInstance.update();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error al cargar el historial de crecimiento/decaimiento:', xhr.responseText);
                        if (growthDecayChartInstance) {
                             growthDecayChartInstance.data.labels = ['Error'];
                             growthDecayChartInstance.data.datasets[0].data = [0];
                             growthDecayChartInstance.data.datasets[1].data = [0];
                             growthDecayChartInstance.options.scales.y.min = -1; // Restablecer escala
                             growthDecayChartInstance.options.scales.y.max = 1;  // Restablecer escala
                             growthDecayChartInstance.update();
                        }
                    }
                });
            }

            function resetDemonstration() {
                demonstrationResults.hide();
                studentName.text('');
                studentEmail.text('');
                studentThetaGlobal.text('');
                studentNivelGlobal.text('');
                studentNivelGlobal.removeClass('badge-bajo badge-medio badge-alto');
                skillPerformanceTableBody.html('<tr><td colspan="5" class="text-center text-white-50">Seleccione un estudiante para ver el detalle.</td></tr>');
                recommendedEvaluationsList.html('<li class="list-group-item bg-dark text-white-50">Seleccione un estudiante para ver las recomendaciones.</li>');
                recommendationExplanation.text('La lógica de la recomendación se mostrará aquí.');
                markovMatrixTableBody.html('<tr><td colspan="4" class="text-center text-white-50">Seleccione una área para ver la matriz.</td></tr>');

                if (habilidadChartInstance) {
                    habilidadChartInstance.destroy();
                    habilidadChartInstance = null;
                }
                if (habilidadRadarChartInstance) {
                    habilidadRadarChartInstance.destroy();
                    habilidadRadarChartInstance = null;
                }
                if (growthDecayChartInstance) { // Restaurado: Destruir instancia del gráfico de crecimiento/decaimiento
                    growthDecayChartInstance.destroy();
                    growthDecayChartInstance = null;
                }

                loadGlobalChartsAndMatrices();
            }

            function loadGlobalChartsAndMatrices() {
                // Cargar la distribución global de habilidad
                $.ajax({
                    url: '{{ route('docente.reportes_irt.getGlobalHabilidadDistribution') }}',
                    method: 'GET',
                    success: function(response) {
                        updateHabilidadChart(response.dataCounts);
                    },
                    error: function(xhr) {
                        console.error('Error al cargar la distribución global de habilidad:', xhr.responseText);
                    }
                });

                // Cargar la matriz de Markov para la primera área al cargar la página
                const firstCategoryId = categorySelector.find('option:eq(1)').val();
                if (firstCategoryId) {
                    categorySelector.val(firstCategoryId); // Selecciona la primera área en el dropdown
                    loadMarkovMatrix(firstCategoryId);
                } else {
                    markovMatrixTableBody.html('<tr><td colspan="4" class="text-center text-white-50">No hay áreas disponibles para mostrar la matriz.</td></tr>');
                }

                // Inicializar Chart.js para el gráfico de radar con datos vacíos
                const radarCtx = document.getElementById('habilidadRadarChart').getContext('2d');
                const initialRadarData = {
                    labels: ['WEB', 'CRYPTO', 'FORENSE', 'STENOGRAFIA', 'DEMO'], // Etiquetas para las áreas
                    datasets: [{
                        label: 'Habilidad (Theta)',
                        backgroundColor: 'rgba(255, 140, 0, 0.2)', // Fondo naranja transparente
                        borderColor: '#FF8C00', // Borde naranja sólido
                        pointBackgroundColor: '#FF8C00', // Puntos naranjas
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#FF8C00',
                        data: [0, 0, 0, 0, 0] // Datos iniciales vacíos
                    }]
                };
                const radarOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            },
                            pointLabels: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                color: '#FFFFFF'
                            },
                            ticks: {
                                beginAtZero: false, // CAMBIADO: Establecer a false para permitir que la escala empiece en el mínimo real (-3)
                                min: -3,            // Mantener el rango completo de theta
                                max: 3,             // Mantener el rango completo de theta
                                stepSize: 1,
                                color: '#FFFFFF',
                                backdropColor: 'rgba(0,0,0,0)'
                            },
                            // NUEVO: Añadir `suggestedMin` y `suggestedMax` para guiar la escala si `beginAtZero` causa problemas
                            suggestedMin: -3,
                            suggestedMax: 3
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                };
                habilidadRadarChartInstance = new Chart(radarCtx, {
                    type: 'radar',
                    data: initialRadarData,
                    options: radarOptions
                });

                // Restaurado: Inicializar Chart.js para el gráfico de crecimiento y decaimiento
                const growthDecayCtx = document.getElementById('growthDecayChart').getContext('2d');
                const initialGrowthDecayData = {
                    labels: [], // Fechas/Nro. Intentos
                    datasets: [
                        {
                            label: 'EMA (Rendimiento)',
                            borderColor: '#FF8C00', // Naranja
                            backgroundColor: 'rgba(255, 140, 0, 0.2)',
                            fill: true,
                            tension: 0.4, // Suavizar la línea
                            data: []
                        },
                        {
                            label: 'Theta (Habilidad)',
                            borderColor: '#22C55E', // Verde
                            backgroundColor: 'rgba(34, 197, 94, 0.2)',
                            fill: true,
                            tension: 0.4, // Suavizar la línea
                            data: []
                        }
                    ]
                };
                const growthDecayOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: '#FFFFFF' }
                        },
                        y: {
                            beginAtZero: false,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: '#FFFFFF' }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#FFFFFF' }
                        }
                    }
                };
                growthDecayChartInstance = new Chart(growthDecayCtx, {
                    type: 'line',
                    data: initialGrowthDecayData,
                    options: growthDecayOptions
                });
            }

            // --- NUEVA LÓGICA DE BUSCADOR DE ESTUDIANTES ---
            let searchTimeout;
            const searchDelay = 300; // ms de delay para la búsqueda

            function performStudentSearch() {
                const searchTerm = studentSearchInput.val().trim();
                if (searchTerm.length < 3) {
                    studentSuggestionsContainer.hide().empty();
                    selectedStudentIdInput.val(''); // Limpiar el ID seleccionado si la búsqueda es muy corta
                    return;
                }

                $.ajax({
                    url: '{{ route('docente.reportes_irt.searchStudents') }}',
                    method: 'GET',
                    data: { search: searchTerm },
                    success: function(response) {
                        studentSuggestionsContainer.empty();
                        if (response.length > 0) {
                            $.each(response, function(index, student) {
                                const studentText = `${student.name} ${student.app_usu} ${student.apm_usu} (${student.email})`;
                                const suggestionItem = $(`<a href="#" class="list-group-item list-group-item-action bg-dark text-white-50">${studentText}</a>`);
                                
                                suggestionItem.on('click', function(e) {
                                    e.preventDefault();
                                    studentSearchInput.val(studentText); // Rellenar el input con el texto del estudiante
                                    selectedStudentIdInput.val(student.id); // Guardar el ID
                                    studentSuggestionsContainer.hide().empty(); // Ocultar sugerencias
                                    // No se hace clic en loadDataBtn automáticamente. El usuario debe hacerlo.
                                });
                                studentSuggestionsContainer.append(suggestionItem);
                            });
                            studentSuggestionsContainer.show();
                        } else {
                            studentSuggestionsContainer.html('<a href="#" class="list-group-item bg-dark text-white-50">No se encontraron estudiantes.</a>').show();
                            selectedStudentIdInput.val('');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error al buscar estudiantes:', xhr.responseText);
                        studentSuggestionsContainer.html('<a href="#" class="list-group-item bg-dark text-white-50">Error al buscar.</a>').show();
                        selectedStudentIdInput.val('');
                    }
                });
            }

            // Evento de escritura en el input de búsqueda
            studentSearchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performStudentSearch, searchDelay);
            });

            // Evento de clic en el botón de búsqueda
            studentSearchButton.on('click', function() {
                performStudentSearch();
            });

            // Ocultar sugerencias al hacer clic fuera del input y las sugerencias
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#student_search_input, #student_suggestions_container').length) {
                    studentSuggestionsContainer.hide().empty();
                }
            });

            // Cuando se deselecciona o borra el input, resetea la demostración
            studentSearchInput.on('change', function() {
                if (!$(this).val()) { // Si el input está vacío
                    selectedStudentIdInput.val('');
                    resetDemonstration();
                }
            });
            // --- FIN DE NUEVA LÓGICA DE BUSCADOR DE ESTUDIANTES ---

            // Inicializar la demostración vacía al cargar la página (después de Select2)
            resetDemonstration();

            loadDataBtn.on('click', function() {
                const selectedStudentId = selectedStudentIdInput.val(); // Usar el ID del input oculto
                const selectedCategoryId = categorySelector.val(); // OBTENER LA CATEGORÍA PRINCIPAL SELECCIONADA

                if (!selectedStudentId) {
                    alert('Por favor, seleccione un estudiante.');
                    return;
                }
                if (!selectedCategoryId) { // NUEVO: Asegurarse de que se seleccione una área también
                    alert('Por favor, seleccione una área.');
                    return;
                }
                
                // No llamamos a resetDemonstration aquí, porque queremos mantener los gráficos globales.
                // Solo reseteamos la sección específica del estudiante.
                studentName.text('');
                studentEmail.text('');
                studentThetaGlobal.text('');
                studentNivelGlobal.text('');
                studentNivelGlobal.removeClass('badge-bajo badge-medio badge-alto');
                skillPerformanceTableBody.html('<tr><td colspan="5" class="text-center text-white-50">Cargando datos del estudiante...</td></tr>');
                recommendedEvaluationsList.html('<li class="list-group-item bg-dark text-white-50">Cargando recomendaciones...</li>');
                recommendationExplanation.text('Cargando explicación de la recomendación...');

                $(this).attr('disabled', true).text('Cargando...');

                // Cargar datos del estudiante
                $.ajax({
                    url: '{{ route('docente.reportes_irt.getStudentData') }}',
                    method: 'GET',
                    data: { user_id: selectedStudentId },
                    success: function(response) {
                        studentName.text(response.student.name);
                        studentEmail.text(response.student.email);
                        studentThetaGlobal.text(response.habilidad.theta_global.toFixed(4));
                        updateNivelBadge(studentNivelGlobal, response.habilidad.nivel_global);

                        skillPerformanceTableBody.empty();
                        if (Object.keys(response.habilidad.theta_por_categoria).length > 0) {
                            $.each(response.habilidad.theta_por_categoria, function(catId, data) {
                                const emaData = response.habilidad.ema_por_categoria[catId] || { ema: 0, muestras: 0 };
                                skillPerformanceTableBody.append(`
                                    <tr>
                                        <td>${data.nombre}</td>
                                        <td>${data.theta.toFixed(4)}</td>
                                        <td><span class="badge badge-${data.nivel}">${data.nivel}</span></td>
                                        <td>${emaData.ema.toFixed(2)}</td>
                                        <td>${emaData.muestras}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            skillPerformanceTableBody.html('<tr><td colspan="5" class="text-center text-white-50">No hay datos de habilidad por área para este estudiante.</td></tr>');
                        }

                        recommendedEvaluationsList.empty();
                        if (response.recomendaciones.length > 0) {
                            $.each(response.recomendaciones, function(index, rec) {
                                recommendedEvaluationsList.append(`
                                    <li class="list-group-item bg-dark text-white">
                                        <strong>${rec.titulo}</strong> (Área: ${rec.categoria}, Nivel de dificultad: ${rec.dificultad})<br>
                                        <small class="text-white-50">Razón: ${rec.razon}</small>
                                    </li>
                                `);
                            });
                            recommendationExplanation.html(buildRecommendationExplanation(response.recomendaciones));
                        } else {
                            recommendedEvaluationsList.html('<li class="list-group-item bg-dark text-white-50">No hay recomendaciones disponibles para este estudiante.</li>');
                            recommendationExplanation.text('No se pudieron generar recomendaciones para este estudiante en este momento.');
                        }

                        // Actualizar gráfico de radar con datos de habilidad por área
                        const radarLabels = ['WEB', 'CRIPTOGRAFIA', 'FORENSE', 'ESTENOGRAFIA', 'DEMO'];
                        const radarData = [];
                        
                        // Recopilar todos los valores de theta para determinar el rango dinámico
                        const allThetas = [];

                        // Convertir theta_por_categoria a un mapa para acceso más fácil por nombre normalizado
                        const thetaByCategoryName = {};
                        $.each(response.habilidad.theta_por_categoria, function(catId, data) {
                            if (data.nombre) { // Asegurarse de que el nombre de la área existe
                                thetaByCategoryName[data.nombre.toUpperCase()] = data.theta;
                            }
                        });

                        radarLabels.forEach(label => {
                            const thetaValue = thetaByCategoryName[label] !== undefined ? parseFloat(thetaByCategoryName[label].toFixed(4)) : 0;
                            radarData.push(thetaValue);
                            allThetas.push(thetaValue);
                        });

                        // Calcular el min y max dinámico para la escala del radar
                        // Añadir un pequeño padding para que los puntos no estén exactamente en el borde
                        const dynamicMin = allThetas.length > 0 ? Math.min(...allThetas) : -3;
                        const dynamicMax = allThetas.length > 0 ? Math.max(...allThetas) : 3;

                        // Ajustar el rango con un poco de margen para mejor visualización
                        const padding = (dynamicMax - dynamicMin) * 0.1 || 1; // 10% de margen o 1 si el rango es 0
                        const finalMin = Math.floor(dynamicMin - padding);
                        const finalMax = Math.ceil(dynamicMax + padding);

                        // Asegurarse de que el rango mínimo no sea mayor que el máximo, y que no sean iguales si los thetas son 0
                        const adjustedMin = Math.min(finalMin, dynamicMin === 0 && dynamicMax === 0 ? -1 : finalMin);
                        const adjustedMax = Math.max(finalMax, dynamicMin === 0 && dynamicMax === 0 ? 1 : finalMax);
                        
                        // Asegurarse que min y max no sean iguales si los thetas son 0
                        const effectiveMin = adjustedMin === adjustedMax ? adjustedMin -1 : adjustedMin;
                        const effectiveMax = adjustedMin === adjustedMax ? adjustedMax + 1 : adjustedMax;


                        if (habilidadRadarChartInstance) {
                            habilidadRadarChartInstance.data.labels = radarLabels;
                            habilidadRadarChartInstance.data.datasets[0].data = radarData;

                            // Actualizar dinámicamente las opciones de la escala radial
                            habilidadRadarChartInstance.options.scales.r.ticks.min = effectiveMin;
                            habilidadRadarChartInstance.options.scales.r.ticks.max = effectiveMax;
                            habilidadRadarChartInstance.options.scales.r.suggestedMin = effectiveMin;
                            habilidadRadarChartInstance.options.scales.r.suggestedMax = effectiveMax;
                            
                            // Ajustar stepSize dinámicamente si el rango es grande
                            const range = effectiveMax - effectiveMin;
                            habilidadRadarChartInstance.options.scales.r.ticks.stepSize = range > 6 ? Math.ceil(range / 5) : 1; // Un paso de 1 o más grande si el rango es muy amplio

                            habilidadRadarChartInstance.update();
                        }

                        demonstrationResults.show();

                        // NUEVO: Cargar el gráfico de crecimiento/decaimiento para la área principal seleccionada
                        loadGrowthDecayChart(selectedStudentId, selectedCategoryId);
                    },
                    error: function(xhr) {
                        alert('Error al cargar datos del estudiante: ' + (xhr.responseJSON.error || 'Error desconocido'));
                        resetDemonstration(); // Resetea toda la UI en caso de error
                    },
                    complete: function() {
                        loadDataBtn.attr('disabled', false).text('Cargar Datos del Estudiante');
                    }
                });
            });

            // Evento para actualizar la matriz de Markov y el gráfico de crecimiento/decaimiento
            categorySelector.on('change', function() {
                const selectedStudentId = selectedStudentIdInput.val();
                const selectedCategoryId = $(this).val();

                loadMarkovMatrix(selectedCategoryId); // Siempre actualizar la matriz de Markov

                // Si hay un estudiante seleccionado, actualizar el gráfico de crecimiento/decaimiento también
                if (selectedStudentId) {
                    loadGrowthDecayChart(selectedStudentId, selectedCategoryId);
                } else {
                    // Si no hay estudiante seleccionado, limpiar el gráfico de crecimiento/decaimiento
                    loadGrowthDecayChart(null, null);
                }
            });


            // Inicializar Chart.js para la distribución global de habilidad (esto debe ocurrir una sola vez)
            const habilidadCtx = document.getElementById('habilidadIrtChart').getContext('2d');
            const initialHabilidadData = {
                labels: ['Bajo', 'Medio', 'Alto'],
                datasets: [{
                    label: 'Número de Estudiantes',
                    backgroundColor: ['#EF4444', '#FACC15', '#22C55E'],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1,
                    data: [0, 0, 0]
                }]
            };
            const habilidadOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#FFFFFF' } // CAMBIADO: Usar color hexadecimal directo para asegurar blanco
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: '#FFFFFF' } // CAMBIADO: Usar color hexadecimal directo para asegurar blanco
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#FFFFFF' } // CAMBIADO: Usar color hexadecimal directo para asegurar blanco
                    }
                }
            };
            habilidadChartInstance = new Chart(habilidadCtx, {
                type: 'bar',
                data: initialHabilidadData,
                options: habilidadOptions
            });

            // La carga inicial de los gráficos globales ya se maneja en resetDemonstration() -> loadGlobalChartsAndMatrices()
            // Y loadGlobalChartsAndMatrices() se llama al final de resetDemonstration() que a su vez se llama en document.ready.
            // Esto asegura que se intenta cargar al inicio.
        });
    </script>
@stop
