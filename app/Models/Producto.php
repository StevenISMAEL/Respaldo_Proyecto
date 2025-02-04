<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'codigo_pro';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'codigo_pro',
        'nombre_pro',
        'descripcion_pro',
        'precio_unitario_pro',
        'precio_libras_pro',
        'alimenticio_pro',
        'tipo_animal_pro',
        'tamano_raza_pro',
        'peso_libras_pro',
        'minimo_pro',
        'maximo_pro',
        'fecha_registro_pro'
    ];
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'codigo_pro', 'codigo_pro');
    }
}
