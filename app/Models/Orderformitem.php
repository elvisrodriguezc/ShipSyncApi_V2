<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderformitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderform_id',
        'orderline',
        'product_id',
        'unit_id',
        'quantity',
        'unit_price',
        'status'
    ];

    public function orderform()
    {
        return $this->belongsTo(Orderform::class);
    }

    public function orderformitemcomments()
    {
        return $this->hasMany(Orderformitemcomment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
