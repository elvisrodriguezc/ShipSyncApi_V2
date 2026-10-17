<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'persons';

    protected $fillable = [
        'company_id',
        'position_id',
        'id_card_type_id',
        'doc_number',
        'names',
        'last_name',
        'phone',
        'address',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function idCardType()
    {
        return $this->belongsTo(IdCardType::class, 'id_card_type_id');
    }
}
