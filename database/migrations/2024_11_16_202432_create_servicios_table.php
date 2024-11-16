<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_base', 8, 2);
            $table->time('duracion_estimada'); // En minutos u horas
            $table->enum('estado', ['activo', 'inactivo', 'en_revision'])->default('activo');
            $table->decimal('calificacion', 3, 2)->default(0);
            $table->integer('cantidad_reservas')->default(0);
            $table->json('tags')->nullable();
            $table->timestamps();

            //Relacion con datos_profesion
            $table->foreignId('datos_profesion_id')->constrained('datos_profesion')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('servicios');
    }

};
