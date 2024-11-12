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
        Schema::create('datos_rubro', function (Blueprint $table) {
            $table->id();
            
            //Llave datos_profesional_id
            $table->unsignedBigInteger('datos_profesional_id');
            $table->foreign('datos_profesional_id')->references('id')->on('datos_profesionales')->onDelete('cascade');

            //Llave rubro_id
            $table->unsignedBigInteger('rubro_id');
            $table->foreign('rubro_id')->references('id')->on('rubros')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_rubro');
    }
};
