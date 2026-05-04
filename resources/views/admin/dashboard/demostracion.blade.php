<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Demostración: Sistema IRT con Newton-Raphson') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                ← Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Estadísticas del Sistema</h3>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Estudiantes</p>
                        <p class="text-2xl font-semibold text-gray-700">{{ $estadisticas['total_estudiantes'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Con Theta Calculado</p>
                        <p class="text-2xl font-semibold text-indigo-600">{{ $estadisticas['con_theta'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nivel Bajo</p>
                        <p class="text-2xl font-semibold text-red-600">{{ $estadisticas['bajo'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nivel Medio</p>
                        <p class="text-2xl font-semibold text-yellow-600">{{ $estadisticas['medio'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nivel Alto</p>
                        <p class="text-2xl font-semibold text-green-600">{{ $estadisticas['alto'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Ejemplos por Nivel -->
            @foreach(['bajo' => 'Estudiante de Nivel Bajo', 'medio' => 'Estudiante de Nivel Medio', 'alto' => 'Estudiante de Nivel Alto'] as $nivel => $titulo)
                @php($ejemplo = $ejemplos[$nivel] ?? null)
                @if($ejemplo)
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">{{ $titulo }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($nivel === 'bajo') bg-red-100 text-red-800
                                @elseif($nivel === 'medio') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ strtoupper($nivel) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Estudiante</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $ejemplo['user']->name }}</p>
                                <p class="text-xs text-gray-400">{{ $ejemplo['user']->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Theta (Habilidad IRT)</p>
                                <p class="text-2xl font-semibold text-indigo-600">
                                    {{ $ejemplo['theta_global'] !== null ? number_format($ejemplo['theta_global'], 4) : 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    Calculado mediante Newton-Raphson (MLE)
                                </p>
                            </div>
                        </div>

                        <!-- Evaluaciones Recomendadas -->
                        @if(isset($ejemplo['evaluaciones_recomendadas']) && $ejemplo['evaluaciones_recomendadas']->isNotEmpty())
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3">
                                    Evaluaciones Asignadas (Adaptadas a su Nivel)
                                </h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Evaluación</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dificultad</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Theta Cat.</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Razón</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($ejemplo['evaluaciones_recomendadas'] as $recomendacion)
                                                <tr>
                                                    <td class="px-4 py-2">
                                                        <span class="font-medium text-gray-900">
                                                            {{ $recomendacion['categoria']->nombre_cat }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <span class="text-gray-700">
                                                            {{ $recomendacion['evaluacion']->titulo_eval }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <span class="px-2 py-1 text-xs rounded
                                                            @if($recomendacion['evaluacion']->dificultad_id <= 2) bg-green-100 text-green-800
                                                            @elseif($recomendacion['evaluacion']->dificultad_id <= 3) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800
                                                            @endif">
                                                            {{ $recomendacion['evaluacion']->dificultad->nombre_dif ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <span class="text-gray-600">
                                                            {{ $recomendacion['theta'] !== null ? number_format($recomendacion['theta'], 4) : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <span class="text-xs text-gray-500 italic">
                                                            {{ $recomendacion['razon'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    ⚠️ No hay evaluaciones recomendadas disponibles. El estudiante necesita más intentos para calcular theta en las categorías.
                                </p>
                            </div>
                        @endif

                        <!-- Detalle de Theta por Categoría -->
                        @if($ejemplo['habilidad'] && $ejemplo['habilidad']->theta_por_cat)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-700 mb-3">Theta por Categoría</h4>
                                <div class="grid grid-cols-4 gap-3">
                                    @foreach($ejemplo['habilidad']->theta_por_cat as $catId => $theta)
                                        @php($categoria = \App\Models\Categoria::find($catId))
                                        @if($categoria)
                                            <div class="p-3 bg-gray-50 rounded">
                                                <p class="text-xs text-gray-500">{{ $categoria->nombre_cat }}</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($theta, 4) }}</p>
                                                <p class="text-xs text-gray-400">
                                                    {{ $ejemplo['habilidad']->obtenerNivelPorCategoria($catId) }}
                                                </p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">{{ $titulo }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                NO DISPONIBLE
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">
                            No hay estudiantes con nivel <strong>{{ $nivel }}</strong> con theta calculado actualmente.
                            Los estudiantes necesitan realizar al menos algunos intentos para que el sistema calcule su habilidad.
                        </p>
                    </div>
                @endif
            @endforeach

            <!-- Información Técnica -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">📊 Información Técnica del Sistema</h3>
                <div class="space-y-2 text-sm text-blue-800">
                    <p>
                        <strong>Algoritmo:</strong> Newton-Raphson para Maximum Likelihood Estimation (MLE) en modelo IRT-2PL
                    </p>
                    <p>
                        <strong>Modelo IRT:</strong> P(θ) = 1 / (1 + exp(-a * (θ - b)))
                    </p>
                    <p>
                        <strong>Umbrales de Nivel:</strong> Bajo (θ &lt; -0.5), Medio (-0.5 ≤ θ &lt; 0.5), Alto (θ ≥ 0.5)
                    </p>
                    <p>
                        <strong>Asignación Adaptativa:</strong> Las evaluaciones se asignan según el nivel del estudiante:
                        <ul class="list-disc list-inside ml-4 mt-1">
                            <li>Nivel Bajo → Dificultad Fácil/Baja</li>
                            <li>Nivel Medio → Dificultad Media</li>
                            <li>Nivel Alto → Dificultad Alta/Difícil</li>
                        </ul>
                    </p>
                    <p>
                        <strong>Política de Decisión:</strong> Combina rendimiento (EMA), entropía Markov y probabilidad de progresión
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

