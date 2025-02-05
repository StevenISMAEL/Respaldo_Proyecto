<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';
    protected $primaryKey = 'id_ven';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id_ven',
        'cedula_cli',
        'nombre_cli_ven',
        'fecha_emision_ven',
        'total_ven',
        'numero_factura'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cedula_cli', 'cedula_cli');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_ven', 'id_ven');
    }
    public static function ventasPorMes()
    {
        return DB::table('ventas')
            ->selectRaw('EXTRACT(MONTH FROM fecha_emision_ven) as mes, 
                    SUM(productos.precio_unitario_pro * detalles_ventas.cantidad_pro_detven) as total_venta')
            ->join('detalles_ventas', 'ventas.id_ven', '=', 'detalles_ventas.id_ven')
            ->join('productos', 'detalles_ventas.codigo_pro', '=', 'productos.codigo_pro')
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();
    }
}
