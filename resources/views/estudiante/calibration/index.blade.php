<x-app-layout>
    <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-4">
        <div class="max-w-2xl w-full bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
                <h1 class="text-3xl font-bold text-white mb-2">Fase de Calibración</h1>
                <p class="text-blue-100">Configurando tu perfil de seguridad inicial</p>
            </div>

            <!-- Body -->
            <div class="p-8">
                <div class="mb-8 text-center">
                    <div class="inline-block p-4 rounded-full bg-gray-700 mb-4">
                        <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl text-gray-300 mb-2">
                        Has completado <span class="text-white font-bold text-2xl">{{ $totalIntentos }}</span> de 5 pruebas
                    </h2>
                    <p class="text-gray-400 text-sm">
                        Necesitamos analizar tu rendimiento en 5 retos iniciales para que el motor de inteligencia artificial (IRT) pueda asignarte un nivel adecuado.
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                        <span>Progreso</span>
                        <span>{{ number_format($progreso, 0) }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-4 rounded-full transition-all duration-1000 ease-out"
                             style="width: {{ $progreso }}%"></div>
                    </div>
                </div>

                <!-- Action -->
                <div class="text-center">
                    <form action="{{ route('estudiante.calibracion.start') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                            <span>Continuar Calibración</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </form>
                    <p class="mt-4 text-xs text-gray-500">
                        Te quedan {{ $restantes }} prueba(s) para desbloquear el dashboard completo.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
