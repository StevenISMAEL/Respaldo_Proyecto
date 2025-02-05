<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->string('id_ven', 49)->primary(); // Ahora tiene 49 dígitos
            $table->string('cedula_cli', 10);
            $table->string('nombre_cli_ven', 100);
            $table->date('fecha_emision_ven')->default(now());
            $table->decimal('total_ven', 10, 2)->default(0)->check('total_ven >= 0');

            // 🔹 Nueva columna para almacenar el número de factura sin ceros a la izquierda
            $table->integer('numero_factura')->unique()->notNullable();

            $table->timestamps();

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
