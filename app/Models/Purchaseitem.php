<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchaseitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'product_id',
        'unity_id',
        'price',
        'quantity',
        'discount',
        'discount_percent',
        'status'
    ];
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function unities(): BelongsTo
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
