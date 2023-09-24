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
        'text',
        'icon',
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

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('creator', function (Builder $builder) {
    //         $builder->where('creator_id', Auth::id());
    //     });
    // }
}
