<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('scores')) {
            return;
        }

        if (Schema::hasColumn('scores', 'id_score')) {
            DB::statement('ALTER TABLE `scores` CHANGE `id_score` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
        if (Schema::hasColumn('scores', 'puntaje_obtenido_score')) {
            DB::statement('ALTER TABLE `scores` CHANGE `puntaje_obtenido_score` `puntaje` DECIMAL(10,2) NOT NULL DEFAULT 0.00');
        }

        Schema::table('scores', function (Blueprint $table) {
            if (!Schema::hasColumn('scores', 'porcentaje')) {
                $table->decimal('porcentaje', 5, 2)->default(0)->after('puntaje');
            }
            if (!Schema::hasColumn('scores', 'calculo_meta')) {
                $table->json('calculo_meta')->nullable()->after('porcentaje');
            }
        });

        foreach (['ema_cat_score', 'ema_global_score', 'ultimo_correcto_score'] as $legacy) {
            if (Schema::hasColumn('scores', $legacy)) {
                DB::statement(sprintf('ALTER TABLE `scores` DROP COLUMN `%s`', $legacy));
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('scores')) {
            return;
        }

        foreach (['calculo_meta', 'porcentaje'] as $column) {
            if (Schema::hasColumn('scores', $column)) {
                DB::statement(sprintf('ALTER TABLE `scores` DROP COLUMN `%s`', $column));
            }
        }

        Schema::table('scores', function (Blueprint $table) {
            if (!Schema::hasColumn('scores', 'ema_cat_score')) {
                $table->decimal('ema_cat_score', 6, 4)->nullable();
            }
            if (!Schema::hasColumn('scores', 'ema_global_score')) {
                $table->decimal('ema_global_score', 6, 4)->nullable();
            }
            if (!Schema::hasColumn('scores', 'ultimo_correcto_score')) {
                $table->boolean('ultimo_correcto_score')->default(false);
            }
        });

        if (Schema::hasColumn('scores', 'puntaje')) {
            DB::statement('ALTER TABLE `scores` CHANGE `puntaje` `puntaje_obtenido_score` DECIMAL(10,2) NOT NULL DEFAULT 0.00');
        }
        if (Schema::hasColumn('scores', 'id')) {
            DB::statement('ALTER TABLE `scores` CHANGE `id` `id_score` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }
};
