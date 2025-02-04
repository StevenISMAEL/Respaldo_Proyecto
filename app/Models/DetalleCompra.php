<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalles_compras';
    protected $primaryKey = 'id_detcom';
    public $timestamps = true;

    protected $fillable = [
        'id_com',
        'codigo_pro',
        'cantidad_pro_detcom',
        'precio_unitario_com',
        'iva_detcom',
        'subtotal_detcom'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_com', 'id_com');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}
