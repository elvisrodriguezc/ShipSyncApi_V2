<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guidecarrieritem extends Model
{
    use HasFactory;
    protected $fillable = [
        "guidecarrier_id",
        "product_id",
        "quantity",
        "unity_id",
        "unitvalue",
        "duscount",
        "mto_baseigv",
        "porcentaje_igv",
        "total_impuestos",
        "monto_preciounitario",
        "status",
    ];

    public function guidecarrier(): BelongsTo
    {
        return $this->belongsTo(Guidecarrier::class, 'guidecarrier_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function unity(): BelongsTo
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
