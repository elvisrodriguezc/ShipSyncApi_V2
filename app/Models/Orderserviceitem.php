<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderserviceitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'orderservice_id',
        'orderitem_id',
        'updateby_id',
        'note',
        'status',
    ];
    protected $cast = [];
    public function orderservice()
    {
        return $this->belongsTo(Orderservice::class);
    }
    public function orderitem()
    {
        return $this->belongsTo(Orderitem::class);
    }
    public function updateby()
    {
        return $this->belongsTo(User::class);
    }
}
