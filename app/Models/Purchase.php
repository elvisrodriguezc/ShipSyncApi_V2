<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'warehouse_id',
        'entity_id',
        'tipo_comprobante',
        'numero_comprobante',
        'fecha_emision',
        'fecha_ingreso',
        'peso_bruto',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
