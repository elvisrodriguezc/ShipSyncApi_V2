<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productvariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'variant',
        'sku',
        'price',
        'image',
        'status',
    ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    // public function variants()
    // {
    //     return $this->hasMany(Productvariantdetail::class);
    // }
}
