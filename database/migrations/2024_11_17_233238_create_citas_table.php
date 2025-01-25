<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            //Atributos
            $table->id('idCita'); // Llave primaria
            // Relacion con persona
            $table->unsignedBigInteger('idPersona'); // Llave foránea hacia 'personas'
            //Relacion con servicios
            $table->unsignedBigInteger('idServicio'); // Llave foránea hacia 'servicios'
            //Relacion con profesion
            $table->unsignedBigInteger('idProfesion'); // Llave foránea hacia 'profesiones'

            
            $table->enum('estado_cliente', ['pendiente', 'confirmada', 'completada', 'cancelada']);
            $table->integer('estado');
            $table->date('fechaCita');
            $table->time('horaInicio');
            $table->time('horaFin');
            $table->boolean('calificacion_profesion')->default(0);
            $table->boolean('calificacion_cliente')->default(0);
            
            $table->timestamps(); // Campos created_at y updated_at

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}