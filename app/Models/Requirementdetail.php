<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirementdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "requirement_id",
        "product_id",
        "productvariant_id",
        "nonexistent",
        "detail",
        "unity_id",
        "quantity",
        "updatedby_id",
        "status",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productvariant()
    {
        return $this->belongsTo(Productvariant::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
    public function updatedby()
    {
        return $this->belongsTo(User::class);
    }
}
