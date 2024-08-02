<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedettip extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicedetail_id',
        'typevalue_id',
        'note',
        'status'
    ];
    public function servicedetail()
    {
        return $this->belongsTo(Servicedetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function servicedettipdet()
    {
        return $this->hasMany(Servicedettipdet::class);
    }
}
