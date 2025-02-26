<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productaddon extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'addon_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function addon()
    {
        return $this->belongsTo(Product::class);
    }
}
