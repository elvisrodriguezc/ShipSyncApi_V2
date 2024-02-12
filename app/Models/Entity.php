<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entity extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'company_name',
        'idform_id',
        'idform_number',
        'phone',
        'email',
        'ubigeodistrito_id',
        'address',
        'remark',
    ];
    public function idform(): BelongsTo
    {
        return $this->belongsTo(Idform::class, 'idform_id');
    }
    public function ubigeodistrito(): BelongsTo
    {
        return $this->belongsTo(Ubigeodistrito::class, 'ubigeodistrito_id');
    }
}
