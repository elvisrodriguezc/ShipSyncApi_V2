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
        'tripLength',
        'status',
    ];

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
    public function servicedetspent()
    {
        return $this->hasMany(Servicedetspent::class);
    }
    public function servicedettip()
    {
        return $this->hasMany(Servicedettip::class);
    }
}
