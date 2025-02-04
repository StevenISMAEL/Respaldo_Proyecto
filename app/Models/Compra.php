<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $primaryKey = 'id_com';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_com',
        'ruc_pro',
        'fecha_emision_com',
        'total_com'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ruc_pro', 'ruc_pro');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_com', 'id_com');
    }
    public static function comprasPorMes()
    {
        return DB::table('compras')
            ->selectRaw('EXTRACT(MONTH FROM fecha_emision_com) as mes, 
                        SUM(productos.precio_unitario_pro * detalles_compras.cantidad_pro_detcom) as total_compra')
            ->join('detalles_compras', 'compras.id_com', '=', 'detalles_compras.id_com')
            ->join('productos', 'detalles_compras.codigo_pro', '=', 'productos.codigo_pro')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();
    }



}

