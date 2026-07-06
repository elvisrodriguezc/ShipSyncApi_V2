<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stock_reservations';

    protected $fillable = [
        'company_id',
        'warehouse_id',
        'product_id',
        'orderform_id',
        'orderformitem_id',
        'quantity',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderform()
    {
        return $this->belongsTo(Orderform::class);
    }

    public function orderformitem()
    {
        return $this->belongsTo(Orderformitem::class);
    }
}
