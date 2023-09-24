<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'tariffitem_id',
        'product_serie_id',
        'quantity',
        'price',
        'discount',
        'discount_percent',
        'description',
        'splitfrom',
        'status_comment',
        'status',
    ];
    protected $cast = [];
    public function tariffitem()
    {
        return $this->belongsTo(Tariffitem::class);
    }
}
