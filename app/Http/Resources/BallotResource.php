<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BallotResource extends JsonResource
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
            'company_id' => $this->company_id,
            'user' => new UserResource($this->user),
            'candidate' => new CandidateResource($this->candidate),
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'hash' =>  bcrypt($this->id . '-' . $this->company_id . '-' . $this->user_id . '-' . $this->candidate_id),
            'error' => $this->error,
        ];
    }
}
