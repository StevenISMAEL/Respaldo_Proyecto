<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';
    protected $primaryKey = 'id_detven';
    public $timestamps = true;

    protected $fillable = [
        'id_ven',
        'codigo_pro',
        'cantidad_pro_detven',
        'iva_detven',
        'descuento_detven',
        'subtotal_detven',
        'tipo_venta'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_ven', 'id_ven');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
