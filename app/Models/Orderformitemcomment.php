<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderformitemcomment extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderformitem_id',
        'user_id',
        'comment',
        'status'
    ];

    public function orderformitem()
    {
        return $this->belongsTo(Orderformitem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
