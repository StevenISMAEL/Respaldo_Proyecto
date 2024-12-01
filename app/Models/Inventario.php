<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    protected $fillable = ['codigo', 'nombre_producto', 'cantidad_disponible'];

    protected $dates = ['fecha_registro', 'created_at', 'updated_at'];
}
