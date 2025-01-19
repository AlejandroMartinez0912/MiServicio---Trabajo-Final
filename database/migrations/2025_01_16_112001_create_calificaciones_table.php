<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            // Llave foránea hacia 'citas'
            $table->unsignedBigInteger('idCita');

            $table->enum('tipo', ['cliente_a_especialista', 'especialista_a_cliente'])
                  ->comment('Indica si es la calificación del cliente al especialista o viceversa');
            $table->tinyInteger('calificacion')->unsigned()->comment('Puntuación entre 1 y 5');
            $table->string('comentarios', 255)->nullable()->comment('Comentarios adicionales sobre la calificación');
            $table->timestamps();

            // Relaciones
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
        Schema::dropIfExists('calificaciones');
    }

};
