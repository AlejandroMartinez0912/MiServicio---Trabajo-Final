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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->float('precio_fijo')->nullable();
            $table->float('precio_hora')->nullable();
            $table->time('duracion');
            $table->string('modalidad');
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(1);

            // Relación con la tabla 'empresa'
            $table->foreignId('empresa_id')
                  ->constrained('empresa')
                  ->onDelete('cascade');  // Borra los horarios si la empresa es eliminada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
