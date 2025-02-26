<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'icon_id',
        'description',
        'price_rate',
    ];
    protected $cast = [
        'status',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function icons(): BelongsTo
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }
}
