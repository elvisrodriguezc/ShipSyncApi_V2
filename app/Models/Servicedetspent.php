<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedetspent extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicedetail_id',
        'ruc',
        'serie',
        'number',
        'amount',
        'detail',
        'typecpe_id',
        'status',
    ];

    public function servicedetail()
    {
        return $this->belongsTo(Servicedetail::class);
    }
    public function typecpe()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
