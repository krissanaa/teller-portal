<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'description' => $this->description,
            'details' => $this->details,
            'actor' => new UserResource($this->whenLoaded('admin')),
            'target' => new UserResource($this->whenLoaded('targetUser')),
            'created_at' => optional($this->created_at)?->toDateTimeString(),
        ];
    }
}
