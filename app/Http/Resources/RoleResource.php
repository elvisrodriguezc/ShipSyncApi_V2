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
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                ]);
            }),
            'menus' => $this->whenLoaded('menus', function () {
                return $this->menus->map(fn($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'slug' => $m->slug,
                    'route' => $m->route,
                    'pivot' => [
                        'order' => $m->pivot->order,
                    ],
                ]);
            }),
        ];
    }
}
