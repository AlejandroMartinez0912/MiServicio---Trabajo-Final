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
        Schema::create('calificacion_profesion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idCita');

            $table->unsignedBigInteger('idProfesion');
            $table->foreignId('idServicio')->constrained('servicios')->onDelete('cascade');


            $table->tinyInteger('calificacion')->unsigned()->comment('Puntuación entre 1 y 5');
            $table->string('comentarios', 255)->nullable();
            $table->timestamps();

            $table->foreign('idCita')->references('idCita')->on('citas')->onDelete('cascade');
            $table->foreign('idProfesion')->references('id')->on('datos_profesion')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion_profesion');
    }
};
