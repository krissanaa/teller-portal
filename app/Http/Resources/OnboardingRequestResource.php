<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OnboardingRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $attachments = collect($this->attachments ?? [])
            ->map(function ($path) {
                $disk = Storage::disk('public');

                return [
                    'path' => $path,
                    'url' => $disk->exists($path) ? $disk->url($path) : null,
                ];
            })
            ->values()
            ->all();

        return [
            'id' => $this->id,
            'refer_code' => $this->refer_code,
            'teller_id' => $this->teller_id,
            'store_name' => $this->store_name,
            'store_address' => $this->store_address,
            'business_type' => $this->business_type,
            'pos_serial' => $this->pos_serial,
            'bank_account' => $this->bank_account,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'unit' => new BranchUnitResource($this->whenLoaded('unit')),
            'approval_status' => $this->approval_status,
            'admin_remark' => $this->admin_remark,
            'installation_date' => $this->installation_date,
            'attachments' => $attachments,
            'teller' => new UserResource($this->whenLoaded('teller')),
            'created_at' => optional($this->created_at)?->toDateTimeString(),
            'updated_at' => optional($this->updated_at)?->toDateTimeString(),
        ];
    }
}
