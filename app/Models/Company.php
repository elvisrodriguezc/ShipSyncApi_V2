<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ruc',
        'address',
        'phone',
        'email',
        'logo',
        'web',
        'description',
        'status',
    ];
}
