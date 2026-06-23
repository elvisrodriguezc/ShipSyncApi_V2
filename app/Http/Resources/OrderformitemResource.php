<?php

namespace App\Http\Resources;

use App\Services\BatchStockService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderformitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'orderform_id' => $this->orderform_id,
            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),
            'unit_id' => $this->unit_id,
            'unit' => UnitResource::make($this->unit),
            'quantity' => $this->quantity,
            'weight' => (float) $this->weight,
            'unit_price' => $this->unit_price,
            'status' => $this->status,
            'note' => OrderformitemcommentResource::collection($this->orderformitemcomments),
            'requiere_lote' => (bool) $this->product->requiere_lote,
        ];

        if ($this->product->requiere_lote) {
            $companyId = auth()->user()->company_id;
            $service = new BatchStockService();
            $data['batches'] = $service->getBatchesForProduct($companyId, $this->product_id);
            $data['oldest_batch'] = collect($data['batches'])->firstWhere('es_mas_antiguo', true);
        }

        return $data;
    }
}
