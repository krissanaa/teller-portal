<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'code' => $this->BRANCH_CODE ?? $this->code ?? null,
            'name' => $this->BRANCH_NAME ?? $this->name ?? null,
            'units' => BranchUnitResource::collection($this->whenLoaded('units')),
        ];
    }
}
