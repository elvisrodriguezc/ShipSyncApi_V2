<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderformDelivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orderform_deliveries';

    protected $fillable = [
        'company_id',
        'orderform_id',
        'car_id',
        'person_id',
        'trayquantity',
        'tray_returned_quantity',
        'returned',
        'status',
    ];

    protected $casts = [
        'returned' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orderform()
    {
        return $this->belongsTo(Orderform::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
