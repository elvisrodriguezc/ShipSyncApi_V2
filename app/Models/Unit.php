<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'symbol',
        'value',
        'status',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
