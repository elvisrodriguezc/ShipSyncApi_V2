<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'comment',
    ];
    protected $cast = [];

    public function typevalue()
    {
        return $this->hasMany(Typevalue::class);
    }
}
