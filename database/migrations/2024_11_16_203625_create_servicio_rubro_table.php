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
        Schema::create('servicio_rubro', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            //Relacion con servicios
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');

            //Relacion con rubros
            $table->foreignId('rubro_id')->constrained('rubros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_rubro');
    }
};
