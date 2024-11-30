<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // La tabla 'clientes' tiene una clave primaria que no es un incremento automático, por lo que lo especificamos
    protected $primaryKey = 'id_cliente';
    public $incrementing = false;

    

    // Desactivamos el uso de los campos 'created_at' y 'updated_at' solo si no los necesitas
    public $timestamps = true; // Laravel maneja esto automáticamente
    protected $keyType = 'string';

    // Los campos que se pueden asignar masivamente
    protected $fillable = ['id_cliente', 'nombre', 'direccion', 'telefono', 'email', 'fecha_registro'];

    // Si necesitas que 'fecha_registro' se maneje como una fecha de Carbon
    protected $dates = ['fecha_registro'];

    // Si deseas que 'id_cliente' se trate como un string, aseguramos que no se trate como un número autoincremental

    // Si no quieres que Eloquent intente convertir 'id_cliente' a tipo entero
}
