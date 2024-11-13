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
        Schema::create('dias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);  // Nombre del día (Lunes, Martes, etc.)
            $table->string('abreviatura', 3); // Abreviatura del día (Lun, Mar, etc.)
            $table->tinyInteger('orden')->unique(); // Orden del día en la semana (1 para Lunes, 7 para Domingo)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dias');
    }
};
