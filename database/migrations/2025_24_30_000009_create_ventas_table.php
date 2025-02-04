<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->string('id_ven', 15)->primary(); // ID único de la venta
            $table->string('cedula_cli', 10); // Relación con clientes
            $table->string('nombre_cli_ven', 100); // Nuevo campo para almacenar el nombre del cliente
            $table->date('fecha_emision_ven')->default(now()); // Fecha de emisión
            $table->decimal('total_ven', 10, 2)->default(0)->check('total_ven >= 0'); // Total de la venta
            $table->timestamps(); // created_at y updated_at

            // Relación con clientes
            $table->foreign('cedula_cli')
                ->references('cedula_cli')
                ->on('clientes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
