<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracion_datos', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_emisor', 13)->unique();
            $table->string('nombre_negocio', 100);
            $table->string('direccion_negocio', 200)->nullable();
            $table->string('telefono_negocio', 15)->nullable();
            $table->string('correo_negocio', 100)->nullable();
            $table->string('codigo_establecimiento', 3)->notNullable(); // Nuevo campo
            $table->string('codigo_emision', 3)->notNullable(); // Nuevo campo
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_datos');
    }
};
