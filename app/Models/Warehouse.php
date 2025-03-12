<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'headquarter_id',
        'warehouse_id',
        'name',
        'description',
        'mode',
        'status'
    ];

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
