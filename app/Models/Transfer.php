<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'user_id',
        'numerator_id',
        'number',
        'originwarehouse_id',
        'destinationwarehouse_id',
        'receivinguser_id',
        'detail',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }
    public function originwarehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function destinationwarehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function receivinguser()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(Transferdetail::class);
    }
}
