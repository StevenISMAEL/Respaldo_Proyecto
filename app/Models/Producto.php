<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo
    protected $table = 'productos';

    // Especifica la clave primaria (si no es 'id', en este caso 'codigo')
    protected $primaryKey = 'codigo';

    // Especifica si la clave primaria es un valor autoincrementable
    public $incrementing = false;

    // Especifica los atributos que pueden ser asignados masivamente
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'tipo_producto',
        'precio_unitario',
        'estado',
        'alimenticio',
        'fecha_creacion',
    ];

    // Especifica los tipos de datos de los atributos
    protected $casts = [
        'alimenticio' => 'boolean',
        'precio_unitario' => 'decimal:2',
        'fecha_creacion' => 'datetime',
    ];

    // Si necesitas hacer algo al crear o actualizar, puedes agregar los siguientes métodos:
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($producto) {
    //         // Hacer algo antes de que se cree el producto
    //     });
    // }
}
