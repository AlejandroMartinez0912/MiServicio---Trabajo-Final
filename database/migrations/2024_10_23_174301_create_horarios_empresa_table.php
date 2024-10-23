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
        Schema::create('horarios_empresa', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla 'empresa'
            $table->foreignId('empresa_id')
                  ->constrained('empresa')
                  ->onDelete('cascade');  // Borra los horarios si la empresa es eliminada

            // Relación con la tabla 'dias_semana'
            $table->foreignId('dia_semana_id')
                  ->constrained('dias_semana')
                  ->onDelete('cascade');  // Borra los horarios si el día es eliminado

            // Horarios de trabajo (hora de inicio y hora de fin)
            $table->time('hora_inicio');
            $table->time('hora_fin');

            // Opcionalmente, puedes añadir un campo para definir si hay turno (mañana/tarde/noche)
            $table->enum('turno', ['mañana', 'tarde', 'noche'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_empresa');
    }
};
