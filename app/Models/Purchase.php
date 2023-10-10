<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'duedate',
        'status'
    ];

    protected $cast = [
        'status',
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function receipttype()
    {
        return $this->belongsTo(Receipttype::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function purchaseitems()
    {
        return $this->hasMany(Purchaseitem::class);
    }
}
