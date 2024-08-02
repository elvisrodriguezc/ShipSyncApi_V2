<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedettipdet extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicedettip_id',
        'user_id',
        'amount',
        'status'
    ];
    public function servicedettip()
    {
        return $this->belongsTo(Servicedettip::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
