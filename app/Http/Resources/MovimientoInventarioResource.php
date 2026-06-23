<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientoInventarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tipoLabels = ['', 'Ingreso_Compra', 'Egreso_Venta', 'Merma', 'Ajuste_Inventario', 'Vencimiento'];

        $lote = null;
        if ($this->relationLoaded('batch') && $this->batch) {
            $lote = [
                'id_lote' => $this->id_lote,
                'fecha_vencimiento' => $this->batch->fecha_vencimiento,
            ];
        }

        return [
            'id_movimiento' => $this->id_movimiento,
            'company_id' => $this->company_id,
            'id_lote' => $this->id_lote,
            'id_producto' => $this->id_producto,
            'warehouse_id' => $this->warehouse_id,
            'lote' => $lote,
            'producto' => $this->producto ? [
                'id' => $this->producto->id,
                'name' => $this->producto->name,
            ] : null,
            'tipo_movimiento' => $this->tipo_movimiento,
            'tipo_label' => $tipoLabels[$this->tipo_movimiento] ?? 'Desconocido',
            'cantidad' => (float) $this->cantidad,
            'saldo' => (float) $this->saldo,
            'fecha_movimiento' => $this->fecha_movimiento ? $this->fecha_movimiento->format('Y-m-d H:i:s') : null,
            'documento_referencia' => $this->documento_referencia,
            'usuario_id' => $this->usuario_id,
            'usuario' => $this->usuario ? [
                'id' => $this->usuario->id,
                'name' => $this->usuario->name,
            ] : null,
            'warehouse' => $this->relationLoaded('warehouse') && $this->warehouse ? [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
            ] : null,
            'created_at' => $this->created_at,
        ];
    }
}
