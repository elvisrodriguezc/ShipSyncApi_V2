<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedetast extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicedetail_id',
        'user_id',
        'status',
    ];
    protected $cast = [];

    public function servicedetail()
    {
        return $this->belongsTo(Servicedetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
