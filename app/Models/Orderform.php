<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderform extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'headquarter_id',
        'warehouse_id',
        'user_id',
        'entity_id',
        'typevalue_id',
        'observation',
        'finished_at',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }

    public function orderformitems()
    {
        return $this->hasMany(Orderformitem::class);
    }
}
