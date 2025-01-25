<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'companybtype_id',
        'name',
        'ruc',
        'address',
        'phone',
        'email',
        'logo',
        'web',
        'description',
    ];

    public function Companybtype()
    {
        return $this->belongsTo(Companybtype::class);
    }
    public function office()
    {
        return $this->hasMany(Office::class);
    }
}
