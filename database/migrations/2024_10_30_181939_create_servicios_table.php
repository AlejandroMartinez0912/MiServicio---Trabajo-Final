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
            $table->float('precio');
            $table->time('duracion')->nullable();
            $table->string('modalidad')->nullable();
            $table->string('descripcion')->nullable();

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
