<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'rate',
        'status',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function tariffitem()
    {
        return $this->hasMany(Tariffitem::class);
    }
}
