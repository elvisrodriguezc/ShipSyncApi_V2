<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'ubigeodistrito_id',
        'address',
        'phone',
        'email',
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
    public function warehouse()
    {
        return $this->hasMany(Warehouse::class);
    }
}
