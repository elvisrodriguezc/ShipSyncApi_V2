<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_lote';

    protected $fillable = [
        'company_id',
        'id_producto',
        'in_date',
        'fecha_vencimiento',
        'stock_actual',
        'estado',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    public function movements()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_lote', 'id_lote');
    }
}
