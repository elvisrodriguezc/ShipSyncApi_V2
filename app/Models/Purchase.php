<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'warehouse_id',
        'entity_id',
        'receipttype_id',
        'document_serial',
        'document_number',
        'guide_number',
        'date',
        'credit',
        'duedate'
    ];

    protected $cast = [
        'status',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
    public function receipttype(): BelongsTo
    {
        return $this->belongsTo(Receipttype::class, 'receipttype_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
