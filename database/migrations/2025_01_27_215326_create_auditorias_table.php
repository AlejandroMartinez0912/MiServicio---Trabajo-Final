<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Usuario que realizó la acción
            $table->string('accion'); // Ejemplo: 'Creación', 'Actualización', 'Eliminación'
            $table->string('modulo'); // Módulo afectado: 'Servicios', 'Usuarios', etc.
            $table->text('detalles')->nullable(); // Detalles adicionales sobre la acción
            $table->ipAddress('ip')->nullable(); // IP del usuario
            $table->timestamp('created_at'); // Fecha y hora de la acción
            $table->timestamp('updated_at')->nullable();

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
