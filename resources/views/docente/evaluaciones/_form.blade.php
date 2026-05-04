@csrf

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- COLUMNA IZQUIERDA: Datos Principales -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Tarjeta: Información Básica -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md p-6 space-y-4 shadow-xl">
            <h3 class="text-sm font-semibold text-gray-200 border-b border-white/10 pb-2 mb-4">
                Información Básica
            </h3>

            <div>
                <label for="titulo_eval" class="block text-xs font-medium text-gray-400 mb-1">Título del Desafío</label>
                <input type="text" name="titulo_eval" id="titulo_eval"
                    value="{{ old('titulo_eval', $evaluacion->titulo_eval ?? '') }}"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                    placeholder="Ej. Inyecciónd SQL Básica"
                    required>
                @error('titulo_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="descripcion_eval" class="block text-xs font-medium text-gray-400 mb-1">Descripción / Enunciado</label>
                <textarea name="descripcion_eval" id="descripcion_eval" rows="5"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                    required>{{ old('descripcion_eval', $evaluacion->descripcion_eval ?? '') }}</textarea>
                <p class="mt-1 text-[11px] text-gray-500">Soporta Markdown básico.</p>
                @error('descripcion_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Tarjeta: Configuración del Reto -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md p-6 space-y-4 shadow-xl">
            <h3 class="text-sm font-semibold text-gray-200 border-b border-white/10 pb-2 mb-4">
                Configuración del Reto (CTF)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="flag_hash_eval" class="block text-xs font-medium text-gray-400 mb-1">Flag (Respuesta)</label>
                    <input type="text" name="flag_hash_eval" id="flag_hash_eval"
                        value="{{ old('flag_hash_eval', $evaluacion->flag_hash_eval ?? '') }}"
                        placeholder="synapse{...}"
                        class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                        required>
                    <p class="mt-1 text-[11px] text-gray-500">La respuesta exacta que debe ingresar el estudiante.</p>
                    @error('flag_hash_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="puntaje_base_eval" class="block text-xs font-medium text-gray-400 mb-1">Puntaje Base</label>
                    <input type="number" name="puntaje_base_eval" id="puntaje_base_eval"
                        value="{{ old('puntaje_base_eval', $evaluacion->puntaje_base_eval ?? 100) }}"
                        class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                        required min="0">
                    @error('puntaje_base_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4 border-t border-white/10 pt-4">
                <label for="archivo_adjunto" class="block text-xs font-medium text-gray-400 mb-1">Archivo Adjunto (Opcional)</label>
                <div class="flex items-center gap-4">
                    <input type="file" name="archivo_adjunto" id="archivo_adjunto"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition">
                </div>
                <p class="mt-1 text-[11px] text-gray-500">Sube un archivo ZIP, PDF o imagen para que el estudiante lo descargue (Max 10MB).</p>

                @if(isset($evaluacion) && $evaluacion->archivo_adjunto)
                    <div class="mt-2 flex items-center gap-2 text-xs text-emerald-400 bg-emerald-500/10 px-3 py-2 rounded-lg border border-emerald-500/20">
                        <i class="fas fa-check-circle"></i>
                        <span>Archivo actual cargado.</span>
                        <a href="{{ asset('storage/' . $evaluacion->archivo_adjunto) }}" target="_blank" class="font-medium underline hover:text-emerald-300 ml-1">
                            Descargar/Ver
                        </a>
                    </div>
                @endif
                @error('archivo_adjunto') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>
        </div>

    </div>

    <!-- COLUMNA DERECHA: Metadatos y Publicación -->
    <div class="space-y-6">

        <!-- Tarjeta: Clasificación -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md p-6 space-y-4 shadow-xl">
            <h3 class="text-sm font-semibold text-gray-200 border-b border-white/10 pb-2 mb-4">
                Clasificación
            </h3>

            <div>
                <label for="categoria_id" class="block text-xs font-medium text-gray-400 mb-1">Categoría</label>
                <select name="categoria_id" id="categoria_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_cat }}"
                            {{ old('categoria_id', $evaluacion->categoria_id ?? '') == $cat->id_cat ? 'selected' : '' }}>
                            {{ $cat->nombre_cat }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="dificultad_id" class="block text-xs font-medium text-gray-400 mb-1">Dificultad</label>
                <select name="dificultad_id" id="dificultad_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    @foreach($dificultades as $dif)
                        <option value="{{ $dif->id_dif }}"
                            {{ old('dificultad_id', $evaluacion->dificultad_id ?? '') == $dif->id_dif ? 'selected' : '' }}>
                            {{ $dif->nombre_dif }} (Nivel {{ $dif->nivel }})
                        </option>
                    @endforeach
                </select>
                @error('dificultad_id') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="periodo_id" class="block text-xs font-medium text-gray-400 mb-1">Periodo Académico</label>
                <select name="periodo_id" id="periodo_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    @foreach($periodos as $per)
                        <option value="{{ $per->id_per }}"
                            {{ old('periodo_id', $evaluacion->periodo_id ?? '') == $per->id_per ? 'selected' : '' }}>
                            {{ $per->nombre_per }}
                        </option>
                    @endforeach
                </select>
                @error('periodo_id') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <input type="hidden" name="docente_user_id" value="{{ old('docente_user_id', $evaluacion->docente_user_id ?? auth()->id()) }}">
        </div>

        <!-- Tarjeta: Publicación -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md p-6 space-y-4 shadow-xl">
            <h3 class="text-sm font-semibold text-gray-200 border-b border-white/10 pb-2 mb-4">
                Estado y Fechas
            </h3>

            <div>
                <label for="estado_eval" class="block text-xs font-medium text-gray-400 mb-1">Estado</label>
                <select name="estado_eval" id="estado_eval"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    <option value="1" {{ old('estado_eval', $evaluacion->estado_eval ?? 1) == 1 ? 'selected' : '' }}>Borrador</option>
                    <option value="2" {{ old('estado_eval', $evaluacion->estado_eval ?? 1) == 2 ? 'selected' : '' }}>Publicada</option>
                    <option value="0" {{ old('estado_eval', $evaluacion->estado_eval ?? 1) == 0 ? 'selected' : '' }}>Archivada</option>
                </select>
                @error('estado_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="fecha_inicio_eval" class="block text-xs font-medium text-gray-400 mb-1">Fecha Inicio</label>
                <input type="datetime-local" name="fecha_inicio_eval" id="fecha_inicio_eval"
                    value="{{ old('fecha_inicio_eval', isset($evaluacion->fecha_inicio_eval) ? $evaluacion->fecha_inicio_eval->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                @error('fecha_inicio_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="fecha_fin_eval" class="block text-xs font-medium text-gray-400 mb-1">Fecha Fin</label>
                <input type="datetime-local" name="fecha_fin_eval" id="fecha_fin_eval"
                    value="{{ old('fecha_fin_eval', isset($evaluacion->fecha_fin_eval) ? $evaluacion->fecha_fin_eval->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                @error('fecha_fin_eval') <span class="text-xs text-rose-400">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('docente.evaluaciones.index') }}"
                class="rounded-lg border border-white/10 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition">
                Cancelar
            </a>
            <button type="submit"
                class="rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition shadow-lg shadow-orange-600/20">
                Guardar Evaluación
            </button>
        </div>

    </div>
</div>
