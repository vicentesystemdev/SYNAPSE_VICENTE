<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dificultades', function (Blueprint $table) {
            $table->bigIncrements('id_dif');
            $table->string('nombre_dif', 40);     // 1_facil, 2_baja, ...
            $table->unsignedSmallInteger('orden_dif'); // 1..5
            $table->timestamps();
            $table->unique('nombre_dif');
            $table->unique('orden_dif');
        });
    }
    public function down(): void { Schema::dropIfExists('dificultades'); }
};
