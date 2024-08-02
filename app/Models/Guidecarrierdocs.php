<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guidecarrierdocs extends Model
{
    use HasFactory;
    protected $fillable = [
        "guidecarrier_id",
        "ruc",
        "serie",
        "number",
        "tipocpe_id",
        "status",
    ];
    public function tipocpe(): BelongsTo
    {
        return $this->belongsTo(Typevalue::class, 'tipocpe_id');
    }
}
