<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'typevalue_id',
        'vehicle',
        'folios',
        'status',
    ];

    protected $cast = [];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
