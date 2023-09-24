<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sunatruc extends Model
{
    use HasFactory;
    protected $fillable = [
        'ruc',
        'razon_social',
        'estado',
        'ubigeo',
        'tipo_via',
        'nombre_via',
        'codigo_zona',
        'numero',
        'interior',
        'lote',
        'departamento',
        'manzana',
        'kilometro',
    ];
}
