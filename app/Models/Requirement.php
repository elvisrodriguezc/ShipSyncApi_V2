<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;
    protected $fillable = [
        "company_id",
        "warehouse_id",
        "user_id",
        "numerator_id",
        "number",
        "currency_id",
        "relevance_id",
        "updatedby_id",
        "deadline",
        "status",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function numerator()
    {
        return $this->belongsTo(Numerator::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function updatedby()
    {
        return $this->belongsTo(User::class);
    }
    public function relevance()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function items()
    {
        return $this->hasMany(Requirementdetail::class);
    }
}
