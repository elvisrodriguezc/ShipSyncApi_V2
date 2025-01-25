<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'percentage-based',
        'sunat_code',
        'sunat_namecode',
        'name',
        'rate',
        'value',
        'description',
        'operationtype_id',
        'start_date',
        'end_date',
        'status',
    ];
    public function operationtype()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
