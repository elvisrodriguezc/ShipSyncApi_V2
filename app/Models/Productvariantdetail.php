<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productvariantdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'productvariant_id',
        'typevalue_id',
    ];

    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
