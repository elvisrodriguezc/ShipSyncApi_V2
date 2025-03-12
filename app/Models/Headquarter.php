<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'ubigeodistrito_id',
        'name',
        'address',
        'phone',
        'email',
        'latitude',
        'longitude',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function ubigeodistrito()
    {
        return $this->belongsTo(Ubigeodistrito::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
