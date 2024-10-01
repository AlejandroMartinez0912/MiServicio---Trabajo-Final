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
        Schema::create('persona', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('domicilio')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('documento')->unique()->nullable(); // Documento único
            $table->string('telefono')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla users
            $table->timestamps(); // Añade created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
