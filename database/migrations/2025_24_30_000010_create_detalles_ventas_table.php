<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id('id_detven'); // Clave primaria autoincremental
            $table->string('id_ven', 15); // Relación con ventas
            $table->string('codigo_pro', 15); // Relación con productos
            $table->integer('cantidad_pro_detven')->default(0)->check('cantidad_pro_detven >= 0'); // Cantidad vendida
            $table->decimal('iva_detven', 10, 2)->default(0)->check('iva_detven >= 0'); // IVA del producto
            $table->decimal('descuento_detven', 10, 2)->default(0)->check('descuento_detven >= 0'); // Descuento
            $table->decimal('subtotal_detven', 10, 2)->default(0)->check('subtotal_detven >= 0'); // Subtotal
            $table->string('tipo_venta', 10)->check("tipo_venta IN ('UNIDAD', 'LIBRAS')"); // Tipo de venta
            $table->timestamps(); // created_at y updated_at

            // Relaciones
            $table->foreign('id_ven')
                ->references('id_ven')
                ->on('ventas')
                ->onDelete('cascade');

            $table->foreign('codigo_pro')
                ->references('codigo_pro')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_ventas');
    }
};
