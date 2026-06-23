<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    protected $primaryKey = 'id_movimiento';

    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'id_lote',
        'id_producto',
        'warehouse_id',
        'tipo_movimiento',
        'cantidad',
        'saldo',
        'fecha_movimiento',
        'documento_referencia',
        'usuario_id',
    ];

    protected $casts = [
        'cantidad' => 'decimal:4',
        'saldo' => 'decimal:4',
        'fecha_movimiento' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_lote');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
