<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulto extends Model
{
    use HasFactory;

    protected $table = 'bultos';

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'tipo_animal',
        'tamano_raza',
        'peso_lb',
        'precio_por_libra',
        'stock_minimo_bultos',
    ];

    
}
