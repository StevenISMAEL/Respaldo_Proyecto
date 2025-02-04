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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->string('ruc_pro', 13)->primary(); 
            $table->string('nombre_pro', 50)->notNullable();
            $table->string('correo_pro', 100)->nullable();
            $table->string('telefono_pro', 10)->nullable();
            $table->string('direccion_pro', 150)->nullable();
            $table->boolean('activo_pro')->default(true); 
            $table->timestamp('fecha_registro_pro')->default(now());
            $table->string('notas_pro', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
