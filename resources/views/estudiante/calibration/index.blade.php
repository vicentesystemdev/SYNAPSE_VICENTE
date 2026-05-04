<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center p-4"
         style="background: linear-gradient(135deg, #eef2ff 0%, #f0f4ff 50%, #e8f4fd 100%);">

        <div class="max-w-2xl w-full rounded-2xl shadow-2xl overflow-hidden"
             style="border: 1px solid #c5d0fc; background: #fff;">

            {{-- Header académico --}}
            <div class="p-8 text-center"
                 style="background: linear-gradient(135deg, #3b5bdb 0%, #4dabf7 100%);">
                {{-- Ícono académico --}}
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4"
                     style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px);">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Evaluación Diagnóstica</h1>
                <p class="text-blue-100 text-sm">
                    Configurando tu perfil académico inicial en INTELECTA
                </p>
            </div>

            {{-- Body --}}
            <div class="p-8">

                {{-- Contador de progreso --}}
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4"
                         style="background: #eef2ff; border: 3px solid #748ffc;">
                        <span class="text-2xl font-bold" style="color: #3b5bdb;">{{ $totalIntentos }}/5</span>
                    </div>

                    <h2 class="text-xl font-semibold mb-2" style="color: #1e2a45;">
                        Has completado
                        <span class="font-bold text-2xl" style="color: #3b5bdb;">{{ $totalIntentos }}</span>
                        de 5 evaluaciones iniciales
                    </h2>
                    <p class="text-sm" style="color: #6b7280; max-width: 480px; margin: 0 auto;">
                        Necesitamos analizar tu rendimiento en 5 ejercicios iniciales para que el motor
                        adaptativo (<strong>IRT</strong>) pueda asignarte un nivel de desempeño adecuado
                        en álgebra, cálculo y lógica matemática.
                    </p>
                </div>

                {{-- Áreas evaluadas --}}
                <div class="flex justify-center gap-3 mb-8 flex-wrap">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                          style="background:#eef2ff; color:#3b5bdb; border:1px solid #c5d0fc;">
                        📐 Álgebra
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                          style="background:#e8f4fd; color:#1971c2; border:1px solid #a5d8ff;">
                        📊 Cálculo Básico
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                          style="background:#f3f0ff; color:#6741d9; border:1px solid #d0bfff;">
                        🔢 Lógica Matemática
                    </span>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                          style="background:#ebfbee; color:#2f9e44; border:1px solid #b2f2bb;">
                        🧮 Razonamiento Numérico
                    </span>
                </div>

                {{-- Barra de progreso --}}
                <div class="mb-8">
                    <div class="flex justify-between text-xs mb-1" style="color:#6b7280;">
                        <span>Progreso de diagnóstico</span>
                        <span style="color:#3b5bdb; font-weight:700;">{{ number_format($progreso, 0) }}%</span>
                    </div>
                    <div class="w-full rounded-full h-4 overflow-hidden" style="background:#e9ecef;">
                        <div class="h-4 rounded-full transition-all duration-1000 ease-out"
                             style="width: {{ $progreso }}%;
                                    background: linear-gradient(90deg, #3b5bdb 0%, #4dabf7 100%);
                                    box-shadow: 0 0 8px rgba(59,91,219,0.4);">
                        </div>
                    </div>
                    {{-- Pasos visuales --}}
                    <div class="flex justify-between mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                                     style="{{ $i <= $totalIntentos
                                        ? 'background:#3b5bdb; color:#fff;'
                                        : 'background:#e9ecef; color:#adb5bd; border:1px solid #dee2e6;' }}">
                                    @if($i <= $totalIntentos)
                                        ✓
                                    @else
                                        {{ $i }}
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Acción --}}
                <div class="text-center">
                    <form action="{{ route('estudiante.calibracion.start') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full py-4 px-6 text-white font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg"
                                style="background: linear-gradient(90deg, #3b5bdb, #4dabf7);
                                       font-size: 1.05rem;
                                       letter-spacing: 0.3px;"
                                onmouseover="this.style.opacity='0.92'; this.style.transform='translateY(-1px)'"
                                onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                            </svg>
                            <span>Continuar Evaluación Diagnóstica</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </form>

                    <p class="mt-4 text-xs" style="color:#9ca3af;">
                        Te {{ $restantes === 1 ? 'queda' : 'quedan' }}
                        <strong style="color:#3b5bdb;">{{ $restantes }}</strong>
                        ejercicio{{ $restantes !== 1 ? 's' : '' }} para desbloquear tu panel académico completo.
                    </p>

                    {{-- Nota informativa --}}
                    <div class="mt-6 p-4 rounded-xl text-left" style="background:#f8f9fa; border:1px solid #e9ecef;">
                        <p class="text-xs" style="color:#6b7280; line-height:1.6;">
                            <span style="color:#3b5bdb; font-weight:700;">ℹ️ ¿Por qué 5 evaluaciones?</span><br>
                            El motor adaptativo IRT necesita una muestra mínima de respuestas para estimar
                            con precisión tu nivel de habilidad lógico-matemática. Completar esta fase desbloquea
                            tu ranking académico, progreso personalizado y recomendaciones de estudio.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Marca INTELECTA debajo --}}
        <p class="mt-6 text-xs" style="color:#9ca3af;">
            INTELECTA — Plataforma de Evaluación Lógico-Matemática
        </p>
    </div>
</x-app-layout>
