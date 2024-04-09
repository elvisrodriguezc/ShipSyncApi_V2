<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'numerator_id',
        'number',
        'date',
        'user_id',
        'entity_id',
        'note',
        'status',
    ];

    protected $cast = [];

    public static function boot()
    {
        $user = Auth::user();
        parent::boot();

        self::creating(function ($service) {
            $user = Auth::user();
            $service->date = now()->toDateString();
            $service->company_id = $user->company_id;
            $service->user_id = $user->id;
            $service->numerator_id = 1;

            $numerator = Numerator::find(1);
            if ($numerator) {
                $service->number = $numerator->number;
            } else {
                // Manejar el caso en el que no se encuentre el numerador con ID 1
            }
        });

        self::created(function ($service) {
            $numerator = Numerator::find(1);
            if ($numerator) {
                $numerator->number++; // Incrementar el número en 1
                $numerator->save();
            } else {
                // Manejar el caso en el que no se encuentre el numerador con ID 1
            }
        });

        self::updating(function ($order) {
            // ... code here
        });

        self::updated(function ($order) {
        });

        self::deleting(function ($order) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }

    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function servicedetail()
    {
        return $this->hasMany(Servicedetail::class);
    }
}
