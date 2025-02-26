<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vcandidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'user_id',
        'dni',
        'name',
        'detail',
        'image',
        'position',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
