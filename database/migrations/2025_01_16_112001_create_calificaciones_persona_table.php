<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calificacion_persona', function (Blueprint $table) {
            $table->id();
            // Llave foránea hacia 'citas'
            $table->unsignedBigInteger('idCita');

            $table->unsignedBigInteger('idPersona'); // Llave foránea hacia 'personas'

            $table->tinyInteger('calificacion')->unsigned()->comment('Puntuación entre 1 y 5');
            $table->string('comentarios', 255)->nullable();
            $table->timestamps();

            $table->foreign('idCita')->references('idCita')->on('citas')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificacion_persona');
    }

};
