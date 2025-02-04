<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'total_ven'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cedula_cli', 'cedula_cli');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_ven', 'id_ven');
    }
}
