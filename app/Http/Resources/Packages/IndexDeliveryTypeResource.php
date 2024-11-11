<?php

namespace App\Http\Resources\Packages;

use App\Models\DeliveryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexDeliveryTypeResource extends JsonResource
{
    /** @var DeliveryType */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
