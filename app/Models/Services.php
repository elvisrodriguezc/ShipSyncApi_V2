<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'numerator_id',
        'number',
        'date',
        'user_id',
        'entity_id',
        'note',
        'status',
    ];

    protected $cast = [];

    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function servicedetail()
    {
        return $this->hasMany(Servicedetail::class);
    }
}
