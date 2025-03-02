<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'document',
        'email',
        'img',
        'priority',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
