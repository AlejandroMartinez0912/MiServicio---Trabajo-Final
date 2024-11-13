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
        Schema::create('datos_profesion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre_fantasia')->nullable();
            $table->string('slogan')->nullable();
            $table->string('ubicacion');
            $table->string('telefono',15)->nullable();
            $table->integer('experiencia');
            $table->decimal('calificacion', 2,1)->default(0);
            $table->boolean('estado')->default(0);
            
            // Definir la columna 'user_id'
            $table->unsignedBigInteger('user_id');
            
            // Llave foránea que referencia a 'id' en 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_profesionales');
    }
};
