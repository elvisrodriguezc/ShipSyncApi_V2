<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paymethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'shortn',
        'profit',
        'status',
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
