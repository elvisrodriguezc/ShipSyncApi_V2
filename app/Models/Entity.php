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
        'razon_social',
        'ubigeo',
        'address',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
