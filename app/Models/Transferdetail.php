<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "transfer_id",
        "product_id",
        "unity_id",
        "quantity",
        "comments",
        "receivinguser_id",
        "status",
        "created_at",
        "updated_at",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
    public function receivinguser()
    {
        return $this->belongsTo(User::class);
    }
}
