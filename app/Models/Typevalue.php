<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typevalue extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'name',
        'description',
        'abbreviation',
        'value',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
