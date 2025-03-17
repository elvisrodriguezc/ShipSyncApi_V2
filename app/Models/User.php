<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'headquarter_id',
        'warehouse_id',
        'first_name',
        'last_name',
        'username',
        'role_id',
        'document_id',
        'document_number',
        'phone',
        'address',
        'email',
        'email_verified_at',
        'password',
        'license',
        'licencecategory',
        'isAF',
        'isAFP',
        'payrollafp_id',
        'salary',
        'additionalpay',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the company that owns the user.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the headquarter that owns the user.
     */
    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    /**
     * Get the warehouse that owns the user.
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    /**
     * Get the document that owns the user.
     */
    public function document()
    {
        return $this->belongsTo(TypeValue::class);
    }

    /**
     * Get the payrollafp that owns the user.
     */
    public function payrollafp()
    {
        return $this->belongsTo(TypeValue::class);
    }
}
