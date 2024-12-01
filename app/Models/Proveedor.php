<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $primaryKey = 'ruc';
    

    use HasFactory;
    protected $fillable = ['ruc', 'nombre', 'correo','telefono','direccion','activo'];

}
