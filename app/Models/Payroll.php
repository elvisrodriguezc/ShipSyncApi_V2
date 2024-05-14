<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'user_id',
        'numerator_id',
        'number',
        'startdate',
        'finishdate',
        'payrolltype',
        'status',
    ];
    public static function boot()
    {
        parent::boot();

        self::creating(function ($payroll) {
            $user = Auth::user();
            $payroll->company_id = $user->company_id;
            $payroll->user_id = $user->id;
            $payroll->numerator_id = 6;

            $numerator = Numerator::find(6);
            if ($numerator) {
                $payroll->number = $numerator->number;
            } else {
                // Manejar el caso en el que no se encuentre el numerador con ID 1
            }
        });

        self::created(function ($payroll) {
            $numerator = Numerator::find(6);
            if ($numerator) {
                $numerator->number++; // Incrementar el número en 1
                $numerator->save();
            } else {
                // Manejar el caso en el que no se encuentre el numerador con ID 1
            }
        });

        self::updating(function ($payroll) {
            // ... code here
        });

        self::updated(function ($payroll) {
        });

        self::deleting(function ($payroll) {
            // ... code here
        });

        self::deleted(function ($payroll) {
            // ... code here
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }
}
