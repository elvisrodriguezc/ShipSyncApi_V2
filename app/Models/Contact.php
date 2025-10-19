<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'bussiness_name',
        'name',
        'email',
        'phone',
        'address',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
