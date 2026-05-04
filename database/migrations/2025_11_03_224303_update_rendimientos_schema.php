<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('rendimientos')) {
            if (Schema::hasColumn('rendimientos', 'id_rend')) {
                DB::statement('ALTER TABLE `rendimientos` CHANGE `id_rend` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
            }
            if (Schema::hasColumn('rendimientos', 'n_intentos')) {
                DB::statement('ALTER TABLE `rendimientos` CHANGE `n_intentos` `muestras` INT UNSIGNED NOT NULL DEFAULT 0');
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rendimientos')) {
            if (Schema::hasColumn('rendimientos', 'id')) {
                DB::statement('ALTER TABLE `rendimientos` CHANGE `id` `id_rend` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
            }
            if (Schema::hasColumn('rendimientos', 'muestras')) {
                DB::statement('ALTER TABLE `rendimientos` CHANGE `muestras` `n_intentos` INT UNSIGNED NOT NULL DEFAULT 0');
            }
        }
    }
};
