<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'user_id',
        'base',
        'aditional',
        'services',
        'isAF',
        'isAFP',
        'payrollafp_id',
        'totalremuneracion',
        'totalaporteempleador',
        'status',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($payrolluser) {
            $user_selected = User::find($payrolluser->user_id);
            $payrolluser->base = $user_selected->salary;
            $payrolluser->aditional = $user_selected->additionalpay;
            $payrolluser->isAF = $user_selected->isAF;
            $payrolluser->isAFP = $user_selected->isAFP;
            $payrolluser->payrollafp_id = $user_selected->payrollafp_id;
            $payrolluser->services = 0;
            $payrolluser->totalremuneracion = 0;
            $payrolluser->totalaporteempleador = 0;
        });

        self::created(function ($payrolluser) {
            // ... code here
        });

        self::updating(function ($order) {
            // ... code here
        });

        self::updated(function ($order) {
            // ... code here
        });

        self::deleting(function ($order) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payrollafp()
    {
        return $this->belongsTo(Payrollafp::class);
    }
}
