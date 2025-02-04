<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('cedula_cli', 10)->primary();
            $table->string('nombre_cli', 100)->notNullable();
            $table->string('direccion_cli', 150)->nullable();
            $table->string('telefono_cli', 10)->nullable();
            $table->string('correo_cli', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
