<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productaccesory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'accesory_id',
        'unity_id',
        'quantity',
        'price',
        'status',
    ];

    public function accesory()
    {
        return $this->belongsTo(Product::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
}
