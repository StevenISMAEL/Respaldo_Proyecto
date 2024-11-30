<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('codigo', 20)->primary();       // Código manual
            $table->string('nombre', 100);                  // Nombre del producto
            $table->text('descripcion')->nullable();        // Descripción del producto
            $table->string('tipo_producto', 50);            // Tipo de producto
            $table->decimal('precio_unitario', 10, 2);      // Precio unitario
            $table->string('estado', 20)->default('Activo'); // Estado (Activo/Descontinuado)
            $table->boolean('alimenticio');                  // Producto alimenticio (true/false)
            $table->timestamp('fecha_creacion')->useCurrent(); // Fecha de creación
            $table->timestamps();                           // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
