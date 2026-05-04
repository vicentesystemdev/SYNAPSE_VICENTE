<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CatalogoBasicoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // =======================
        //  CATEGORÍAS (robusto)
        // =======================
        $catCols = collect(Schema::getColumnListing('categorias'));

        // Detecta posibles nombres de columnas
        $colIdCat     = $catCols->first(fn($c) => in_array($c, ['id_cat','id']));
        $colCodigoCat = $catCols->first(fn($c) => in_array($c, ['codigo_cat','codigo','code']));
        $colNombreCat = $catCols->first(fn($c) => in_array($c, ['nombre_cat','nombre','name','titulo','title']));
        $colCreated   = $catCols->first(fn($c) => in_array($c, ['created_at','creado_en','creado']));
        $colUpdated   = $catCols->first(fn($c) => in_array($c, ['updated_at','actualizado_en','actualizado']));

        $categorias = [
            ['code'=>'ALGEBRA',    'name'=>'Álgebra'],
            ['code'=>'CALCULO', 'name'=>'Cálculo básico'],
            ['code'=>'LOGICA', 'name'=>'Lógica matemática'],
            ['code'=>'RAZON',  'name'=>'Razonamiento numérico'],
        ];

        foreach ($categorias as $c) {
            // Clave de búsqueda priorizando codigo, luego nombre, finalmente id fijo 1..n
            $where = [];
            if ($colCodigoCat) {
                $where[$colCodigoCat] = $c['code'];
            } elseif ($colNombreCat) {
                $where[$colNombreCat] = $c['name'];
            } elseif ($colIdCat) {
                static $seq = 0; $seq++;
                $where[$colIdCat] = $seq;
            }

            // Datos a guardar según columnas existentes
            $data = [];
            if ($colCodigoCat) $data[$colCodigoCat] = $c['code'];
            if ($colNombreCat) $data[$colNombreCat] = $c['name'];
            if ($colCreated)   $data[$colCreated]   = $now;
            if ($colUpdated)   $data[$colUpdated]   = $now;

            if (!empty($where)) {
                DB::table('categorias')->updateOrInsert($where, $data);
            } else {
                DB::table('categorias')->insert($data);
            }
        }

        // =========================
        //  DIFICULTADES (robusto)
        // =========================
        $difCols     = collect(Schema::getColumnListing('dificultades'));
        $colIdDif    = $difCols->first(fn($c) => in_array($c, ['id_dif','id']));
        $colNombreDif= $difCols->first(fn($c) => in_array($c, ['nombre_dif','nombre','name']));
        $colOrdenDif = $difCols->first(fn($c) => in_array($c, ['orden_dif','orden','order']));
        $colCreatedD = $difCols->first(fn($c) => in_array($c, ['created_at','creado_en','creado']));
        $colUpdatedD = $difCols->first(fn($c) => in_array($c, ['updated_at','actualizado_en','actualizado']));

        $dificultades = [
            ['name'=>'1_facil',   'order'=>1],
            ['name'=>'2_baja',    'order'=>2],
            ['name'=>'3_media',   'order'=>3],
            ['name'=>'4_alta',    'order'=>4],
            ['name'=>'5_dificil', 'order'=>5],
        ];

        foreach ($dificultades as $d) {
            $where = [];
            if ($colNombreDif) {
                $where[$colNombreDif] = $d['name'];
            } elseif ($colIdDif) {
                static $seq2 = 0; $seq2++;
                $where[$colIdDif] = $seq2;
            }

            $data = [];
            if ($colNombreDif) $data[$colNombreDif] = $d['name'];
            if ($colOrdenDif)  $data[$colOrdenDif]  = $d['order'];
            if ($colCreatedD)  $data[$colCreatedD]  = $now;
            if ($colUpdatedD)  $data[$colUpdatedD]  = $now;

            if (!empty($where)) {
                DB::table('dificultades')->updateOrInsert($where, $data);
            } else {
                DB::table('dificultades')->insert($data);
            }
        }

        // ======================
        //  PERIODOS (robusto)
        // ======================
        $perCols       = collect(Schema::getColumnListing('periodos'));
        $colIdPer      = $perCols->first(fn($c) => in_array($c, ['id_per','id']));
        $colNombrePer  = $perCols->first(fn($c) => in_array($c, ['nombre_per','nombre','name','periodo']));
        $colGestionPer = $perCols->first(fn($c) => in_array($c, ['gestion_per','gestion','gestion_anual','year']));
        $colActivoPer  = $perCols->first(fn($c) => in_array($c, ['activo_per','activo','is_active','estado']));
        $colCreatedP   = $perCols->first(fn($c) => in_array($c, ['created_at','creado_en','creado']));
        $colUpdatedP   = $perCols->first(fn($c) => in_array($c, ['updated_at','actualizado_en','actualizado']));

        $periodoValor  = '2025-1'; // Cambiado de '2025-2' a '2025-1'
        $gestionValor  = '2025';

        $where = [];
        if ($colNombrePer) {
            $where[$colNombrePer] = $periodoValor;
        } elseif ($colIdPer) {
            $where[$colIdPer] = 1;
        }

        $data = [];
        if ($colNombrePer)  $data[$colNombrePer]  = $periodoValor;
        if ($colGestionPer) $data[$colGestionPer] = $gestionValor;
        if ($colActivoPer)  $data[$colActivoPer]  = 1;
        if ($colCreatedP)   $data[$colCreatedP]   = $now;
        if ($colUpdatedP)   $data[$colUpdatedP]   = $now;

        if (!empty($where)) {
            DB::table('periodos')->updateOrInsert($where, $data);
        } else {
            DB::table('periodos')->insert($data);
        }
    }
}
