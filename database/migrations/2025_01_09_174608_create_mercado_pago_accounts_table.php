<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercadoPagoAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('mercado_pago_accounts', function (Blueprint $table) {
            // Relación con la tabla users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->primary();

            // Campos para los tokens
            $table->string('access_token'); // Token de acceso único

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mercado_pago_accounts');
    }
}
