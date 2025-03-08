<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeodistrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'ubigeoprovincia_id',
    ];

    public function ubigeoprovincia()
    {
        return $this->belongsTo(Ubigeoprovincia::class);
    }
}
