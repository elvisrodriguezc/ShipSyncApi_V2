<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeodistrito extends Model
{
    use HasFactory;
    protected $fillable = [
        'ubigeoprovincia_id',
        'name',
        'code',
    ];
    public function ubigeoprovincia()
    {
        return $this->belongsTo(Ubigeoprovincia::class);
    }
}
