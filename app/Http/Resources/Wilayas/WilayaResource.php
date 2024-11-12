<?php

namespace App\Http\Resources\Wilayas;

use App\Models\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WilayaResource extends JsonResource
{
    /** @var Wilaya */
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
