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
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->id('id_detcom'); // Clave primaria autoincremental
            $table->string('id_com', 15); // Relación con la tabla compras
            $table->string('codigo_pro', 15); // Relación con la tabla productos
            $table->integer('cantidad_pro_detcom')->check('cantidad_pro_detcom > 0'); // Cantidad comprada
            $table->decimal('precio_unitario_com', 10, 2)->check('precio_unitario_com > 0'); // Precio de compra manual
            $table->decimal('iva_detcom', 10, 2)->default(0)->check('iva_detcom >= 0'); // IVA del producto
            $table->decimal('subtotal_detcom', 10, 2)->default(0)->check('subtotal_detcom >= 0'); // Subtotal de la compra
            $table->timestamps(); // created_at y updated_at

            // Relación con compras
            $table->foreign('id_com')->references('id_com')->on('compras')->onDelete('cascade');

            // Relación con productos
            $table->foreign('codigo_pro')->references('codigo_pro')->on('productos')->onDelete('cascade');
        });
    }


    /**
     * Revertir la migración.
     */
    public function down()
    {
        Schema::dropIfExists('detalles_compras');
    }
};
