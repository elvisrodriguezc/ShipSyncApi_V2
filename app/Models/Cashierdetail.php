<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cashierdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'cashier_id',
        'paymethod_id',
        'amount',
        'op_number',
        'date_time',
        'description',
        'status',
    ];
    public function cashiers(): BelongsTo
    {
        return $this->belongsTo(Cashier::class, 'cashier_id');
    }
}
