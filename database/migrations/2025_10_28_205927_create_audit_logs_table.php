<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->bigIncrements('id_audit');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('accion_audit', 80);
            $table->string('entidad_audit', 80)->nullable();
            $table->unsignedBigInteger('entidad_id_audit')->nullable();
            $table->json('payload_audit')->nullable();
            $table->timestamps();

            $table->index(['entidad_audit','entidad_id_audit']);
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('audit_logs'); }
};
