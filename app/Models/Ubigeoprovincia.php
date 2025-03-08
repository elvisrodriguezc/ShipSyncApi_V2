<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeoprovincia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'ubigeodepartamento_id',
    ];

    public function ubigeodepartamento()
    {
        return $this->belongsTo(Ubigeodepartamento::class);
    }
}
