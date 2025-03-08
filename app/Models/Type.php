<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function typevalues()
    {
        return $this->hasMany(Typevalue::class);
    }
}
