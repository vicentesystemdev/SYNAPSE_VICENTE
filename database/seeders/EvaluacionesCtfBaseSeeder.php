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
            'CRYPTO' => Categoria::where('codigo_cat', 'CRYPTO')->first(),
            'STEGO' => Categoria::where('codigo_cat', 'STEGO')->first(),
            'FORENS' => Categoria::where('codigo_cat', 'FORENS')->first(),
            'WEB' => Categoria::where('codigo_cat', 'WEB')->first(),
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

        // Array de evaluaciones: [título, dificultad_orden, fuente, url, descripción]
        $items = [
            // --- CRIPTO ---
            ['Cripto: Bases', 1, 'Parte 3 (DOCX)', null, 'Reto de bases de cifrado.'],
            ['Cripto: Emperator Romano', 2, 'Parte 3 (DOCX)', null, 'Cifrado César: fhvdu_uxohc'],
            ['Cripto: Rotamos si rotamos no', 3, 'Parte 3 (DOCX)', null, 'Patrón de rotaciones.'],
            ['Cripto: Castillo Perdido (.NET)', 4, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1e_yHPwpKuT1BhGmIe8drs2xIxfxqopsO/view', '.NET reversing ligero.'],
            ['Cripto: Cazafantasmas (audio)', 4, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1DgJJsXC7CDmdZFs8ysaXzrt1L3EYpeQN/view', 'Audio con voces invertidas.'],

            // --- STEGO ---
            ['Stego: Latin', 1, 'Parte 3 (DOCX)', null, 'Texto con pista latín.'],
            ['Stego: Paisaje (EXIF)', 2, 'Parte 3 (DOCX)', null, 'Marca de cámara por metadatos.'],
            ['Stego: Explotación de stenografía', 2, 'Parte 3 (DOCX)', null, 'Flag escondida en "la bomba".'],
            ['Stego: Iconografía galletaria', 4, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1HjPX7olD4PMkJLnsbCNHAdk3Ga7zhv4y/view', 'Sprites/íconos sin fondo.'],
            ['Stego: Ricardo en apuros (recovery)', 3, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1SRETFrXChYwGgAHTKp8Gc-gjgNSRft8L/view', 'Recuperar imagen perdida.'],

            // --- FORENSE ---
            ['Forense: Captura de tráfico', 1, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1tyBFiO6QLmU25nCMz7KvQO6dGjG1xM6e/view', 'PCAP inicial.'],
            ['Forense: Pasajes a Qatar', 2, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1rGUl6zkXCphcceLrg2Sg2830_MNNnQxN/view', 'Contar transacciones/tipos cripto.'],
            ['Forense: Decapitado', 4, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1o1KKnuRCV-UHSsYaMzakPZ_GEMh2Y3nt/view', 'Cabeceras/firmas corruptas.'],
            ['Forense: Ping me.', 3, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1EgcYLaJCo-iWQbfJsYAPgALdsQI2FQDy/view', 'Tráfico saliente sospechoso.'],
            ['Forense: Discos-Horrocruxes', 4, 'Parte 3 (DOCX)', 'https://drive.google.com/file/d/1jwWL0Nf2GLoYGhoChA3laVcd2x9F5-hh/view', '2 discos Linux (filesystem).'],

            // --- WEB ---
            ['Web: Debes oír todo lo que te dicen', 1, 'Preguntas CRIPTO y WEB (DOCX)', 'http://200.9.165.32:8091/', 'Reglas y detalles básicos.'],
            ['Web: Robot', 1, 'Preguntas CRIPTO y WEB (DOCX)', 'http://200.9.165.32:8817/', 'Descubrimiento robots.txt.'],
            ['Web: Jason necesita un Web Token', 4, 'Preguntas CRIPTO y WEB (DOCX)', 'http://200.9.165.32:3000/', 'JWT /login y /administracion.'],
            ['Web: Galletitas', 2, 'Preguntas CRIPTO y WEB (DOCX)', 'http://200.9.165.32:8655/', 'Manejo de cookies.'],
            ['Web: Descuido desafortunado', 3, 'Preguntas CRIPTO y WEB (DOCX)', 'http://200.9.165.32:8202', 'Exposición de información.'],
        ];

        // Mapeo de prefijo a categoría
        $catMap = [
            'Cripto' => 'CRYPTO',
            'Stego' => 'STEGO',
            'Forense' => 'FORENS',
            'Web' => 'WEB',
        ];

        foreach ($items as $index => [$title, $difOrder, $src, $url, $desc]) {
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
                'estado_eval' => 1, // 1 = Borrador
                'flag_hash_eval' => null, // Se completará después
                'solution_md5' => null, // El docente lo completa
                'metadata_eval' => json_encode([
                    'nivel_label' => $levelLabel[$difOrder] ?? 'N/A',
                    'external_url' => $url,
                    'flag_format' => 'synapse{md5}',
                    'fuente' => $src,
                ]),
                'fecha_inicio_eval' => null, // Se configurará cuando se publique
                'fecha_fin_eval' => null,
            ]);
        }

        $this->command->info('✅ Se crearon ' . count($items) . ' evaluaciones CTF en estado Borrador.');
        $this->command->info('📝 Recuerda completar solution_md5 y cambiar estado_eval a 2 (Publicada) cuando estén listas.');
    }
}

