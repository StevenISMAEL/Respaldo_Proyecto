<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';
    protected $primaryKey = 'id_lote';
    public $timestamps = true;

    protected $fillable = [
        'codigo_pro',
        'id_compra_lote', // 🔹 Agregar este campo para que Laravel lo permita
        'fecha_compra',
        'cantidad_lote',
        'cantidad_disponible',
        'peso_disponible_libras'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
