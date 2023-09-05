<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutlayResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'outlay_date' => $this->outlay_date,
            'amount' => $this->amount,
            'user' => new UserResource($this->user),
        ];
    }
}
