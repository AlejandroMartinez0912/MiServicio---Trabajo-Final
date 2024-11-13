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
        Schema::create('horarios_trabajo', function (Blueprint $table) {
            $table->id();

            // Relación con la tabla 'datos_profesion'
            $table->foreignId('datos_profesion_id')
                  ->constrained('datos_profesion')
                  ->onDelete('cascade');


            // Relación con la tabla 'dias_semana'
            $table->foreignId('dias_id')
                  ->constrained('dias')
                  ->onDelete('cascade');  // Borra los horarios si el día es eliminado

            //Indice para mejorar la busqueda      
            $table->index(['datos_profesion_id', 'dias_id']);
            // Horarios de trabajo (hora de inicio y hora de fin)
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->time ('hora_inicio1')->nullable();
            $table->time ('hora_fin1')->nullable();

            // Opcionalmente, puedes añadir un campo para definir si hay turno (mañana/tarde/full)
            $table->enum('turno1', ['mañana', 'tarde', 'corrido'])->nullable();
            $table->enum('turno2', ['mañana', 'tarde', 'corrido'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_trabajo');
    }
};
