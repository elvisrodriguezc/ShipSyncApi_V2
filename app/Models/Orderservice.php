<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderservice extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'warehouse_id',
        'updateby_id',
        'starting',
        'finishing',
        'note',
        'status',
    ];
    protected $cast = [];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function updateby()
    {
        return $this->belongsTo(User::class);
    }
    public function orderserviceitem()
    {
        return $this->hasMany(Orderserviceitem::class);
    }
}
