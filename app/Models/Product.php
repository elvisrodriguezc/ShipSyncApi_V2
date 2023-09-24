<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'category_id',
        'unity_id',
        'brand_id',
        'clasificacion_sunat_id',
        'currency_id',
        'name',
        'model',
        'url',
        'image',
        'set_mode',
        'minimal',
        'detail',
        'taxmode_id',
        'price',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function taxmode()
    {
        return $this->belongsTo(Taxmode::class);
    }
}
