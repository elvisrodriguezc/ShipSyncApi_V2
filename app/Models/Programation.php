<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'numerator_id',
        'user_id',
        'customer_id',
        'number',
        'date',
        'note',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Entity::class);
    }
}
