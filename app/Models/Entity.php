<?php

namespace App\Models;

use App\Http\Controllers\Api\EntityController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'mode',
        'ruc',
        'razón_social',
        'estado',
        'condición',
        'ubigeo',
        'tipo_via',
        'nombre_via',
        'codigo_zona',
        'tipo_zona',
        'numero',
        'interior',
        'lote',
        'departamento',
        'manzana',
        'kilometro',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
