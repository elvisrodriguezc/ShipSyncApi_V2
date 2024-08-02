<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedetdoc extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicedetail_id',
        'typevalue_id',
        'serie',
        'number',
        'ubigeodistrito_id',
        'note',
    ];
    public function servicedetail()
    {
        return $this->belongsTo(Servicedetail::class);
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function ubigeodistrito()
    {
        return $this->belongsTo(Ubigeodistrito::class);
    }
}
