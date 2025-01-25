<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producttax extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'tax_id',
        'rate',
        'value',
        'status',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
