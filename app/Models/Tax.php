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
        'sunat_operationcode',
        'name',
        'rate',
        'value',
        'description',
        'start_date',
        'end_date',
        'status',
    ];
}
