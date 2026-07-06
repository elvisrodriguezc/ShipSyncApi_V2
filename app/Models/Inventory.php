<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'headquarter_id',
        'warehouse_id',
        'user_id',
        'numerator_id',
        'number',
        'date',
        'notes',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }

    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id');
    }
}
