<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderformitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderform_id',
        'orderline',
        'status'
    ];

    public function orderform()
    {
        return $this->belongsTo(Orderform::class);
    }

    public function orderformitemcomments()
    {
        return $this->hasMany(Orderformitemcomment::class);
    }
}
