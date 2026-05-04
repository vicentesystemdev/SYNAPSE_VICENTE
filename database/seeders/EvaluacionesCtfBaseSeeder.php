<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Evaluacion;
use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Periodo;
use App\Models\User;

class EvaluacionesCtfBaseSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener categorías por código
        $categorias = [
            'ALGEBRA' => Categoria::where('codigo_cat', 'ALGEBRA')->first(),
            'CALCULO' => Categoria::where('codigo_cat', 'CALCULO')->first(),
            'LOGICA' => Categoria::where('codigo_cat', 'LOGICA')->first(),
            'RAZON' => Categoria::where('codigo_cat', 'RAZON')->first(),
        ];

        // Obtener dificultades por orden
        $dificultades = Dificultad::orderBy('orden_dif')->get()->keyBy('orden_dif');

        // Obtener período actual o crear uno por defecto
        $periodo = Periodo::orderByDesc('id_per')->first();

        // Obtener primer admin/docente como docente por defecto
        $docente = User::role(['admin', 'docente'])->first();

        // Mapeo de niveles de dificultad (1-5) a labels
        $levelLabel = [
            1 => 'Fácil',
            2 => 'Básico',
            3 => 'Intermedio',
            4 => 'Avanzado',
            5 => 'Experto'
        ];

        // Array de evaluaciones: [título, dificultad_orden, fuente, url, descripción, respuesta_correcta]
        $items = [
            // --- ALGEBRA ---
            ['Álgebra: Ecuación lineal básica', 1, 'Banco de ejercicios', null, 'Resolver: 2x + 5 = 15', '5'],
            ['Álgebra: Factorización', 2, 'Banco de ejercicios', null, 'Factorizar: x^2 - 9', '(x-3)(x+3)'],
            ['Álgebra: Sistema de ecuaciones', 3, 'Banco de ejercicios', null, 'Si x + y = 10 y x - y = 2, ¿cuál es el valor de x?', '6'],

            // --- CALCULO ---
            ['Cálculo: Derivada simple', 1, 'Banco de ejercicios', null, 'Calcular la derivada de x^2', '2x'],
            ['Cálculo: Límite básico', 2, 'Banco de ejercicios', null, 'Calcular el límite de (x^2-1)/(x-1) cuando x tiende a 1', '2'],
            ['Cálculo: Integral indefinida', 3, 'Banco de ejercicios', null, '¿Cuál es la integral de 2x?', 'x^2+c'],

            // --- LOGICA ---
            ['Lógica: Conjunción', 1, 'Banco de ejercicios', null, 'Si p es verdadero y q es falso, calcular p ∧ q (escribe verdadero o falso)', 'falso'],
            ['Lógica: Implicación', 2, 'Banco de ejercicios', null, '¿Cuál es el valor de verdad de "Si 2+2=5, entonces el cielo es verde"?', 'verdadero'],

            // --- RAZONAMIENTO ---
            ['Razonamiento: Serie numérica', 1, 'Banco de ejercicios', null, 'Completar la serie: 2, 4, 8, 16, __', '32'],
            ['Razonamiento: Edades', 2, 'Banco de ejercicios', null, 'Si hace 5 años tenía 15 años, ¿cuántos años tendré en 5 años?', '25'],
        ];

        // Mapeo de prefijo a categoría
        $catMap = [
            'Álgebra' => 'ALGEBRA',
            'Cálculo' => 'CALCULO',
            'Lógica' => 'LOGICA',
            'Razonamiento' => 'RAZON',
        ];

        foreach ($items as $index => [$title, $difOrder, $src, $url, $desc, $respuesta]) {
            // Identificar categoría por prefijo del título
            $catKey = null;
            foreach ($catMap as $prefix => $catCode) {
                if (str_starts_with($title, $prefix)) {
                    $catKey = $catCode;
                    break;
                }
            }

            if (!$catKey || !isset($categorias[$catKey])) {
                $this->command->warn("Categoría no encontrada para: {$title}");
                continue;
            }

            $categoria = $categorias[$catKey];
            $dificultad = $dificultades->get($difOrder);

            if (!$dificultad) {
                $this->command->warn("Dificultad no encontrada para orden: {$difOrder} en: {$title}");
                continue;
            }

            // Crear evaluación
            Evaluacion::create([
                'titulo_eval' => $title,
                'descripcion_eval' => $desc . ($src ? ' (Fuente: ' . $src . ')' : ''),
                'categoria_id' => $categoria->id_cat,
                'dificultad_id' => $dificultad->id_dif,
                'periodo_id' => $periodo?->id_per,
                'docente_user_id' => $docente?->id,
                'puntaje_base_eval' => 100.00,
                'estado_eval' => 2, // 2 = Publicada (para probar rápido)
                'flag_hash_eval' => md5($respuesta), // Guardamos el hash de la respuesta
                'solution_md5' => null, 
                'metadata_eval' => json_encode([
                    'nivel_label' => $levelLabel[$difOrder] ?? 'N/A',
                    'external_url' => $url,
                    'flag_format' => 'exact_match',
                    'fuente' => $src,
                    'respuesta_plana' => $respuesta // solo para debug del admin/docente en seeder
                ]),
                'fecha_inicio_eval' => now(), 
                'fecha_fin_eval' => now()->addMonths(6),
            ]);
        }

        $this->command->info('✅ Se crearon ' . count($items) . ' evaluaciones CTF en estado Borrador.');
        $this->command->info('📝 Recuerda completar solution_md5 y cambiar estado_eval a 2 (Publicada) cuando estén listas.');
    }
}

