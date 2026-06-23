<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'bussiness_name',
        'bussiness_tipe_id',
        'name',
        'email',
        'phone',
        'address',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function bussinessTipe()
    {
        return $this->belongsTo(BussinessTipe::class, 'bussiness_tipe_id');
    }
}
