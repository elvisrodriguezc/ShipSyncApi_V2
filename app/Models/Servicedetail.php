<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicedetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'services_id',
        'numerator_id',
        'number',
        'typevalue_id',
        'vehicle_id',
        'initkm',
        'finalkm',
        'initkmGPS',
        'finalkmGPS',
        'status',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($servicedetail) {
            $servicedetail->numerator_id = 2;
            $numerator = Numerator::find(2);
            if ($numerator) {
                $servicedetail->number = $numerator->number;
            } else {
                // Manejar el caso en el que no se encuentre el numerador con ID 1
            }
        });

        self::created(function ($servicedetail) {
            $numerator = Numerator::find(2);
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

    public function services()
    {
        return $this->belongsTo(Services::class);
    }
    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function servicedetast()
    {
        return $this->hasMany(Servicedetast::class);
    }
    public function servicedetdoc()
    {
        return $this->hasMany(Servicedetdoc::class);
    }
    public function servicedettip()
    {
        return $this->hasMany(Servicedettip::class);
    }
}
