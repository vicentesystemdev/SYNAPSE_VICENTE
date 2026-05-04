<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('categoria_id');

            $table->string('estado_origen', 10);  // 'bajo', 'medio', 'alto'
            $table->string('estado_destino', 10);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('categoria_id')->references('id_cat')->on('categorias')->cascadeOnUpdate()->cascadeOnDelete();

            $table->index(['user_id', 'categoria_id']);
            $table->index(['categoria_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transitions');
    }
};

