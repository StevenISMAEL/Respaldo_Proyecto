<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';
    protected $primaryKey = 'id_kar';
    public $timestamps = true;

    protected $fillable = [
        'codigo_pro',
        'fecha_registro_kar',
        'tipo_movimiento',
        'cantidad_movimiento',
        'descripcion_movimiento'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}

