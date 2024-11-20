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
            $table->enum('estadoCita', ['pendiente', 'confirmada', 'completada', 'cancelada']);
            $table->date('fechaCita');
            $table->time('horaCita');
            $table->text('comentariosCliente')->nullable();
            $table->tinyInteger('calificacion')->nullable()->checkBetween(1, 5);

            
            $table->timestamps(); // Campos created_at y updated_at

            // Relacion con persona
            $table->unsignedBigInteger('idPersona'); // Llave foránea hacia 'personas'
            //Relacion con servicios
            $table->unsignedBigInteger('idServicio'); // Llave foránea hacia 'servicios'
            //Relacion con profesion
            $table->unsignedBigInteger('idProfesion'); // Llave foránea hacia 'profesiones'

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