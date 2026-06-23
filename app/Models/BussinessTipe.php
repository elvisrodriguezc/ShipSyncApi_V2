<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessTipe extends Model
{
    use HasFactory;

    protected $table = 'bussiness_tipes';

    protected $fillable = [
        'company_id',
        'name',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
