<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advancementdet extends Model
{
    use HasFactory;
    protected $fillable = [
        'advancement_id',
        'amount',
        'date',
        'payroll_id',
        'user_id',
        'status',
    ];

    public function advancement()
    {
        return $this->belongsTo(Advancement::class, 'advancement');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }
}
