<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariffitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'tariff_id',
        'warehouse_id',
        'product_id',
        'currency_id',
        'price',
        'status',
    ];
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
