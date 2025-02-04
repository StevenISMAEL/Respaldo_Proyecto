<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id('id_kar'); // Clave primaria autoincremental
            $table->string('codigo_pro', 15); // Relación con productos
            $table->date('fecha_registro_kar')->default(now()); // Fecha de registro
            $table->string('tipo_movimiento', 10)->check("tipo_movimiento IN ('ENTRADA', 'SALIDA', 'AJUSTE')"); // Tipo de movimiento
            $table->integer('cantidad_movimiento')->check('cantidad_movimiento > 0'); // Cantidad movida
            $table->string('descripcion_movimiento', 100)->nullable(); // Descripción
            $table->timestamps(); // created_at y updated_at

            // Relación con productos
            $table->foreign('codigo_pro')
                ->references('codigo_pro')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kardex');
    }
};
