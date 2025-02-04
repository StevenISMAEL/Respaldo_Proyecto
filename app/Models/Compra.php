<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

