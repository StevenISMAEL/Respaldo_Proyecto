<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_venta')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('total', 10, 2);
            $table->enum('estado_venta', ['Pendiente', 'Pagado', 'Cancelado'])->default('Pendiente');
            $table->string('metodo_pago', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
