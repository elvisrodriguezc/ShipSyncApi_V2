<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'entity_id',
        'name',
        'description',
        'plate',
        'color',
        'model',
        'year',
        'chassis',
        'tuc',
        'image',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}
