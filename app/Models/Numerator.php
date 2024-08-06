<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numerator extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'documenttype_id',
        'serie',
        'number',
        'description',
        'status'
    ];
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function documenttype()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
