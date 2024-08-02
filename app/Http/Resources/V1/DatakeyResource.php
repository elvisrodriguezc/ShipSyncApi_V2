<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DatakeyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $key = "*******";
        if ($user->role === 'admin' || $user->role === "sadmin") {
            $key = Crypt::decryptString($this->content);
        }
        return [
            "id" => $this->id,
            "label" => $this->label,
            "content" => $key,
            "status" => $this->status,
        ];
    }
}
