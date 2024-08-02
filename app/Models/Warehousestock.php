<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehousestock extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'office_id',
        'warehouse_id',
        'product_id',
        'stock',
        'price',
        'reserved',
        'infinity'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
