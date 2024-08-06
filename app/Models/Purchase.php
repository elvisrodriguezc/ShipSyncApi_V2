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
        'user_id',
        'numerator_id',
        'number',
        'entity_id',
        'receipttype_id',
        'document_serial',
        'document_number',
        'guide_number',
        'date',
        'credit',
        'duedate',
        'taxincluded',
        'status'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function receipttype()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }
    public function purchaseitems()
    {
        return $this->hasMany(Purchaseitem::class);
    }
}
