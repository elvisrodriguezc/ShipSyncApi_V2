<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'typevalues_id',
        'name',
        'abbreviation',
        'value',
        'status'
    ];
    public function typevalues()
    {
        return $this->belongsTo(Typevalue::class);
    }
}
