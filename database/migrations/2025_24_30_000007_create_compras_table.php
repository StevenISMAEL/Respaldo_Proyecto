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
        Schema::create('compras', function (Blueprint $table) {
            $table->string('id_com', 15)->primary(); // ID único de la compra
            $table->string('ruc_pro', 13); // RUC del proveedor (relación)
            $table->date('fecha_emision_com')->default(now()); // Fecha de emisión de la compra
            $table->decimal('total_com', 10, 2)->default(0)->check('total_com >= 0'); // Total de la compra
            $table->timestamps(); // created_at y updated_at

            // Relación con la tabla proveedores
            $table->foreign('ruc_pro')->references('ruc_pro')->on('proveedores')->onDelete('cascade');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
