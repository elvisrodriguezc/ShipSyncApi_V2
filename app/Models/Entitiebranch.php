<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entitiebranch extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "entity_id",
        "ubigeodistrito_id",
        "address",
        "phone",
        "latitud",
        "longitud",
        "created_at",
        "updated_at",
    ];
    public function ubigeodistrito(): BelongsTo
    {
        return $this->belongsTo(Ubigeodistrito::class, 'ubigeodistrito_id');
    }
}
