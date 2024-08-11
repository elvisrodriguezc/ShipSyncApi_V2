<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'company_id',
        'warehouse_id',
        'user',
        'email',
        'typevalue_id',
        'documento',
        'password',
        'role',
        'licence',
        'licencecategory',
        'isAF',
        'isAFP',
        'payrollafp_id',
        'salary',
        'additionalpay',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function typevalue()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function payrollafp()
    {
        return $this->belongsTo(Payrollafp::class);
    }
}
