<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBultosTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bultos', function (Blueprint $table) {
            $table->string('codigo', 20)->primary();     
            $table->string('tipo_animal', 50);            
            $table->string('tamano_raza', 50)->nullable(); 
            $table->decimal('peso_lb', 10, 2);            
            $table->decimal('precio_por_libra', 10, 2);   
            $table->integer('stock_minimo_bultos');       
            $table->timestamps(0);                        
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bultos');
    }
}