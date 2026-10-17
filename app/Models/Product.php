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
        'name',
        'codigo',
        'description',
        'peso',
        'vida_util',
        'requiere_lote',
        'image',
        'unit_id',
        'price',
        'status',
        'stockdependency_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stockDependency()
    {
        return $this->belongsTo(Product::class, 'stockdependency_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'id_producto');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function reservations()
    {
        return $this->hasMany(StockReservation::class);
    }

    public function movements()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_producto');
    }

    public function getStockActual(?int $warehouseId = null): float
    {
        if ($this->requiere_lote) {
            $query = $this->batches()->where('estado', 1);
            if ($warehouseId) {
                $query->where(function ($q) use ($warehouseId) {
                    $q->where('warehouse_id', $warehouseId)
                      ->orWhereNull('warehouse_id');
                });
            }
            return (float) $query->sum('stock_actual');
        }

        $query = $this->stocks();
        if ($warehouseId) {
            $query->where('warehouse_id', $warehouseId);
        }
        return (float) $query->sum('stock_actual');
    }

    public function getStockReservado(?int $warehouseId = null): float
    {
        $query = $this->reservations()->where('status', 1); // 1: Active
        if ($warehouseId) {
            $query->where(function ($q) use ($warehouseId) {
                $q->where('warehouse_id', $warehouseId)
                  ->orWhereNull('warehouse_id');
            });
        }
        return (float) $query->sum('quantity');
    }

    public function getStockDisponible(?int $warehouseId = null): float
    {
        return max(0, $this->getStockActual($warehouseId) - $this->getStockReservado($warehouseId));
    }
}
