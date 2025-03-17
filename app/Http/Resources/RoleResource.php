<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->id,
            'label' => $this->name,
            'company_id' => $this->company_id,
            'name' => $this->name,
<<<<<<< HEAD
            'slug' => $this->slug,
=======
>>>>>>> ed277305982a8e60c320f498a83adc2529a8873d
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
