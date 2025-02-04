<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id('id_lote'); // Clave primaria autoincremental
            $table->string('codigo_pro', 15); // Clave foránea a productos
            $table->string('id_compra_lote', 15)->nullable(); // ID de la compra asociada
            $table->date('fecha_compra')->notNullable();
            $table->integer('cantidad_lote')->notNullable()->check('cantidad_lote > 0');
            $table->integer('cantidad_disponible')->notNullable()->check('cantidad_disponible >= 0');
            $table->decimal('peso_disponible_libras', 10, 2)->nullable();
            $table->timestamps(); // created_at y updated_at

            // Definir la clave foránea
            $table->foreign('codigo_pro')->references('codigo_pro')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down()
    {
        Schema::dropIfExists('lotes');
    }
};
