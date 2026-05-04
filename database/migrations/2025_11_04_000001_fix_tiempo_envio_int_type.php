<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intentos', function (Blueprint $table) {
            // Cambiar de dateTime a integer (timestamp Unix)
            $table->unsignedBigInteger('tiempo_envio_int')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Evitar error de conversión 1292 al hacer rollback: limpiamos la columna o la convertimos explícitamente.
        // Opción segura: Nullificar antes de cambiar tipo.
        \Illuminate\Support\Facades\DB::table('intentos')->update(['tiempo_envio_int' => null]);

        Schema::table('intentos', function (Blueprint $table) {
            $table->dateTime('tiempo_envio_int')->nullable()->change();
        });
    }
};

