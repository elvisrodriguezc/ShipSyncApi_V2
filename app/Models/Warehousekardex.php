<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehousekardex extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'warehouse_id',
        'user_id',
        'product_id',
        'unity_id',
        'in',
        'out',
        'price',
        'prevstock',
        'stock',
        'purchaseitem_id',
        'orderitem_id',
        'transfer_id',
        'inventory_id',
        'detail',
        'status',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
}
