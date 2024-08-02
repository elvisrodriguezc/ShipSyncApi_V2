<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'user_id',
        'numerator_id',
        'number',
        'tariff_id',
        'currency_id',
        'table_id',
        'entity_id',
        'pax',
        'discount',
        'total',
        'cashier_id',
        'status',
    ];
    protected $cast = [];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
    public function receipt()
    {
        // return $this->hasMany(Receipt::class);
    }
    public function orderitem()
    {
        return $this->hasMany(Orderitem::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
