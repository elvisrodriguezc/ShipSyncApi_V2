<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Advancement extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'typevalue_id',
        'servicedetail_id',
        'detail',
        'document',
        'amount',
        'installments',
        'manager_id',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class, 'typevalue_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function advancementdet()
    {
        return $this->hasMany(Advancementdet::class);
    }

    // Triggers
    public static function boot()
    {
        parent::boot();

        self::created(function ($advancement) {
            for ($i = 0; $i < $advancement->installments; $i++) {
                $item = new Advancementdet();
                $item->advancement_id = $advancement->id;
                $item->amount = $advancement->amount / $advancement->installments;
                $item->date = Carbon::create(now())->addMonths($i)->endOfMonth();
                $item->save();
            }
        });
    }
}
