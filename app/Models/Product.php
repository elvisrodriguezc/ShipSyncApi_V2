<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'name',
        'codigo',
        'description',
        'peso',
        'vida_util',
        'requiere_lote',
        'stockdependency_id',
        'image',
        'unit_id',
        'price',
        'stock',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stockdependency()
    {
        return $this->belongsTo(Product::class, 'stockdependency_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_producto');
    }

    public function movements()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_producto');
    }
}
