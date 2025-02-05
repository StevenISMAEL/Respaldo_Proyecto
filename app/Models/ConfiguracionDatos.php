<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionDatos extends Model
{
    use HasFactory;

    protected $table = 'configuracion_datos'; // Nombre de la tabla en snake_case

    protected $fillable = [
        'ruc_emisor',
        'nombre_negocio',
        'direccion_negocio',
        'telefono_negocio',
        'correo_negocio',
        'codigo_establecimiento', // Nuevo campo
        'codigo_emision', // Nuevo campo
    ];

    public $timestamps = true; // Habilita created_at y updated_at (por defecto en Laravel)
}

