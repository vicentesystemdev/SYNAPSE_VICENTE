<?php echo csrf_field(); ?>

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
                    value="<?php echo e(old('titulo_eval', $evaluacion->titulo_eval ?? '')); ?>"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                    placeholder="Ej. Inyecciónd SQL Básica"
                    required>
                <?php $__errorArgs = ['titulo_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="descripcion_eval" class="block text-xs font-medium text-gray-400 mb-1">Descripción / Enunciado</label>
                <textarea name="descripcion_eval" id="descripcion_eval" rows="5"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                    required><?php echo e(old('descripcion_eval', $evaluacion->descripcion_eval ?? '')); ?></textarea>
                <p class="mt-1 text-[11px] text-gray-500">Soporta Markdown básico.</p>
                <?php $__errorArgs = ['descripcion_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- Tarjeta: Configuración del Reto -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md p-6 space-y-4 shadow-xl">
            <h3 class="text-sm font-semibold text-gray-200 border-b border-white/10 pb-2 mb-4">
                Configuración del Reto (Evaluación lógico-matemática)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="flag_hash_eval" class="block text-xs font-medium text-gray-400 mb-1">Respuesta (Respuesta)</label>
                    <input type="text" name="flag_hash_eval" id="flag_hash_eval"
                        value="<?php echo e(old('flag_hash_eval', $evaluacion->flag_hash_eval ?? '')); ?>"
                        placeholder="synapse{...}"
                        class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                        required>
                    <p class="mt-1 text-[11px] text-gray-500">La respuesta exacta que debe ingresar el estudiante.</p>
                    <?php $__errorArgs = ['flag_hash_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="puntaje_base_eval" class="block text-xs font-medium text-gray-400 mb-1">Puntaje Base</label>
                    <input type="number" name="puntaje_base_eval" id="puntaje_base_eval"
                        value="<?php echo e(old('puntaje_base_eval', $evaluacion->puntaje_base_eval ?? 100)); ?>"
                        class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm placeholder-gray-400"
                        required min="0">
                    <?php $__errorArgs = ['puntaje_base_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mt-4 border-t border-white/10 pt-4">
                <label for="archivo_adjunto" class="block text-xs font-medium text-gray-400 mb-1">Archivo Adjunto (Opcional)</label>
                <div class="flex items-center gap-4">
                    <input type="file" name="archivo_adjunto" id="archivo_adjunto"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition">
                </div>
                <p class="mt-1 text-[11px] text-gray-500">Sube un archivo ZIP, PDF o imagen para que el estudiante lo descargue (Max 10MB).</p>

                <?php if(isset($evaluacion) && $evaluacion->archivo_adjunto): ?>
                    <div class="mt-2 flex items-center gap-2 text-xs text-emerald-400 bg-emerald-500/10 px-3 py-2 rounded-lg border border-emerald-500/20">
                        <i class="fas fa-check-circle"></i>
                        <span>Archivo actual cargado.</span>
                        <a href="<?php echo e(asset('storage/' . $evaluacion->archivo_adjunto)); ?>" target="_blank" class="font-medium underline hover:text-emerald-300 ml-1">
                            Descargar/Ver
                        </a>
                    </div>
                <?php endif; ?>
                <?php $__errorArgs = ['archivo_adjunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                <label for="categoria_id" class="block text-xs font-medium text-gray-400 mb-1">Área</label>
                <select name="categoria_id" id="categoria_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id_cat); ?>"
                            <?php echo e(old('categoria_id', $evaluacion->categoria_id ?? '') == $cat->id_cat ? 'selected' : ''); ?>>
                            <?php echo e($cat->nombre_cat); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['categoria_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="dificultad_id" class="block text-xs font-medium text-gray-400 mb-1">Nivel de dificultad</label>
                <select name="dificultad_id" id="dificultad_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    <?php $__currentLoopData = $dificultades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dif->id_dif); ?>"
                            <?php echo e(old('dificultad_id', $evaluacion->dificultad_id ?? '') == $dif->id_dif ? 'selected' : ''); ?>>
                            <?php echo e($dif->nombre_dif); ?> (Nivel <?php echo e($dif->nivel); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['dificultad_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="periodo_id" class="block text-xs font-medium text-gray-400 mb-1">Periodo Académico</label>
                <select name="periodo_id" id="periodo_id"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    <?php $__currentLoopData = $periodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $per): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($per->id_per); ?>"
                            <?php echo e(old('periodo_id', $evaluacion->periodo_id ?? '') == $per->id_per ? 'selected' : ''); ?>>
                            <?php echo e($per->nombre_per); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['periodo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <input type="hidden" name="docente_user_id" value="<?php echo e(old('docente_user_id', $evaluacion->docente_user_id ?? auth()->id())); ?>">
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
                    <option value="1" <?php echo e(old('estado_eval', $evaluacion->estado_eval ?? 1) == 1 ? 'selected' : ''); ?>>Borrador</option>
                    <option value="2" <?php echo e(old('estado_eval', $evaluacion->estado_eval ?? 1) == 2 ? 'selected' : ''); ?>>Publicada</option>
                    <option value="0" <?php echo e(old('estado_eval', $evaluacion->estado_eval ?? 1) == 0 ? 'selected' : ''); ?>>Archivada</option>
                </select>
                <?php $__errorArgs = ['estado_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="fecha_inicio_eval" class="block text-xs font-medium text-gray-400 mb-1">Fecha Inicio</label>
                <input type="datetime-local" name="fecha_inicio_eval" id="fecha_inicio_eval"
                    value="<?php echo e(old('fecha_inicio_eval', isset($evaluacion->fecha_inicio_eval) ? $evaluacion->fecha_inicio_eval->format('Y-m-d\TH:i') : '')); ?>"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                <?php $__errorArgs = ['fecha_inicio_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="fecha_fin_eval" class="block text-xs font-medium text-gray-400 mb-1">Fecha Fin</label>
                <input type="datetime-local" name="fecha_fin_eval" id="fecha_fin_eval"
                    value="<?php echo e(old('fecha_fin_eval', isset($evaluacion->fecha_fin_eval) ? $evaluacion->fecha_fin_eval->format('Y-m-d\TH:i') : '')); ?>"
                    class="block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                <?php $__errorArgs = ['fecha_fin_eval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="<?php echo e(route('evaluaciones.index')); ?>"
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
<?php /**PATH C:\laragon\www\synapse\resources\views/admin/evaluaciones/_form.blade.php ENDPATH**/ ?>