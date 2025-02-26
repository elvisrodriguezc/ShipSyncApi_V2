<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productbom extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bom_id',
        'unity_id',
        'quantity',
        'price',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function bom()
    {
        return $this->belongsTo(Product::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
}
