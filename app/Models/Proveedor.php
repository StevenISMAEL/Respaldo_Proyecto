<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'ruc_pro';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'ruc_pro',
        'nombre_pro',
        'correo_pro',
        'telefono_pro',
        'direccion_pro',
        'activo_pro',
        'notas_pro',
        'fecha_registro_pro'
    ];
}
