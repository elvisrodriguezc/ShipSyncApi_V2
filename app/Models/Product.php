<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'barcode',
        'name',
        'detail',
        'category_id',
        'unity_id',
        'brand_id',
        'model',
        'url',
        'image',
        'set_mode',
        'currency_id',
        'price',
        'minimal',
        'unspsc_id',
        'content',
        'weight',
        'height',
        'length',
        'width',
        'condition_id',
        'warrantytype_id',
        'warrantymonths',
        'depreciationmonths',
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
    public function condition()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function warrantytype()
    {
        return $this->belongsTo(Typevalue::class);
    }
    public function warehousestocks()
    {
        return $this->hasMany(Warehousestock::class);
    }
    public function variants()
    {
        return $this->hasMany(Productvariant::class);
    }
    public function accesories()
    {
        return $this->hasMany(Productaccesory::class);
    }
    public function producttaxes()
    {
        return $this->hasMany(Producttax::class);
    }
}
