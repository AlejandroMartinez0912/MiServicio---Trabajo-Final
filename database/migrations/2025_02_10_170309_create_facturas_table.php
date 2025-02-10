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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Cliente que paga
            $table->integer('idCita');
            $table->decimal('total', 10, 2); // Monto total
            $table->string('metodo_pago'); // Método de pago (Ej: tarjeta, PayPal)
            $table->timestamp('fecha_pago')->nullable(); // Fecha del pago
            $table->string('estado')->default('pendiente'); // Estado del pago

            $table->timestamps();
            // Llave foranea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
