<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'warehouse_id',
        'name',
        'isproduction',
        'status',
    ];
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
