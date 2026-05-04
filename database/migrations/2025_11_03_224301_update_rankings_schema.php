<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function indexExists(string $table, string $index): bool
    {
        return DB::table('INFORMATION_SCHEMA.STATISTICS')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', $table)
            ->where('INDEX_NAME', $index)
            ->exists();
    }

    public function up(): void
    {
        if (!Schema::hasTable('rankings') || !Schema::hasColumn('rankings', 'id_rank')) {
            return;
        }

        // nombres de índices que manejamos
        $uniqueUserPeriodo = 'rankings_user_id_periodo_id_unique';
        $idxPeriodoPosicionRank = 'rankings_periodo_id_posicion_rank_index';

        Schema::disableForeignKeyConstraints();

        // Eliminar índices antiguos si existen
        if ($this->indexExists('rankings', $uniqueUserPeriodo)) {
            Schema::table('rankings', function (Blueprint $table) use ($uniqueUserPeriodo) {
                $table->dropUnique($uniqueUserPeriodo);
            });
        }

        if ($this->indexExists('rankings', $idxPeriodoPosicionRank)) {
            Schema::table('rankings', function (Blueprint $table) use ($idxPeriodoPosicionRank) {
                $table->dropIndex($idxPeriodoPosicionRank);
            });
        }

        // Renombrar/alterar columnas
        DB::statement('ALTER TABLE `rankings` CHANGE `id_rank` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE `rankings` CHANGE `posicion_rank` `posicion` INT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `rankings` CHANGE `puntaje_total_rank` `puntaje_total` DECIMAL(12,2) NOT NULL DEFAULT 0.00');

        // Quitar r_global_rank si existe
        if (Schema::hasColumn('rankings', 'r_global_rank')) {
            DB::statement('ALTER TABLE `rankings` DROP COLUMN `r_global_rank`');
        }

        // Nuevos campos/índices
        Schema::table('rankings', function (Blueprint $table) {
            if (!Schema::hasColumn('rankings', 'skill_id')) {
                $table->unsignedBigInteger('skill_id')->nullable()->after('periodo_id');
            }
        });

        // crear índices nuevos con nombres explícitos
        if (!$this->indexExists('rankings', 'rankings_periodo_id_posicion_index')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->index(['periodo_id', 'posicion'], 'rankings_periodo_id_posicion_index');
            });
        }

        if (!$this->indexExists('rankings', 'rankings_user_id_periodo_id_skill_id_unique')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->unique(['user_id', 'periodo_id', 'skill_id'], 'rankings_user_id_periodo_id_skill_id_unique');
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        if (!Schema::hasTable('rankings')) {
            return;
        }

        Schema::disableForeignKeyConstraints();

        // Quitar índices nuevos si existen
        if ($this->indexExists('rankings', 'rankings_periodo_id_posicion_index')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->dropIndex('rankings_periodo_id_posicion_index');
            });
        }

        if ($this->indexExists('rankings', 'rankings_user_id_periodo_id_skill_id_unique')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->dropUnique('rankings_user_id_periodo_id_skill_id_unique');
            });
        }

        // Quitar skill_id si existe
        if (Schema::hasColumn('rankings', 'skill_id')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->dropColumn('skill_id');
            });
        }

        // Revertir cambios de columnas si existen
        if (Schema::hasColumn('rankings', 'id')) {
            DB::statement('ALTER TABLE `rankings` CHANGE `id` `id_rank` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
        if (Schema::hasColumn('rankings', 'posicion')) {
            DB::statement('ALTER TABLE `rankings` CHANGE `posicion` `posicion_rank` INT NOT NULL DEFAULT 0');
        }
        if (Schema::hasColumn('rankings', 'puntaje_total')) {
            DB::statement('ALTER TABLE `rankings` CHANGE `puntaje_total` `puntaje_total_rank` DECIMAL(12,2) NOT NULL DEFAULT 0.00');
        }

        // Restaurar r_global_rank si no existe
        if (!Schema::hasColumn('rankings', 'r_global_rank')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->decimal('r_global_rank', 6, 4)->default(0.0);
            });
        }

        // Restaurar índices antiguos si no existen
        if (!$this->indexExists('rankings', 'rankings_periodo_id_posicion_rank_index')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->index(['periodo_id', 'posicion_rank'], 'rankings_periodo_id_posicion_rank_index');
            });
        }
        if (!$this->indexExists('rankings', 'rankings_user_id_periodo_id_unique')) {
            Schema::table('rankings', function (Blueprint $table) {
                $table->unique(['user_id', 'periodo_id'], 'rankings_user_id_periodo_id_unique');
            });
        }

        Schema::enableForeignKeyConstraints();
    }
};
