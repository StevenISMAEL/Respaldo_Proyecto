<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->string('codigo_pro', 15)->primary();
            $table->string('nombre_pro', 50);
            $table->string('descripcion_pro', 100)->nullable();
            $table->decimal('precio_unitario_pro', 10, 2)->check('precio_unitario_pro > 0');
            $table->decimal('precio_libras_pro', 10, 2)->nullable();
            $table->boolean('alimenticio_pro')->default(false);
            $table->string('tipo_animal_pro', 50);
            $table->string('tamano_raza_pro', 20);
            $table->decimal('peso_libras_pro', 10, 2)->nullable();
            $table->integer('stock_pro')->default(0)->check('stock_pro >= 0');
            $table->integer('minimo_pro')->default(0)->check('minimo_pro >= 0');
            $table->integer('maximo_pro')->default(0)->check('maximo_pro >= 0');
            $table->timestamp('fecha_registro_pro')->default(now());

            // Agregar los campos de timestamps de Laravel (created_at, updated_at)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
