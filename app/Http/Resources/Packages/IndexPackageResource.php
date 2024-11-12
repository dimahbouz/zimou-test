<?php

namespace App\Http\Resources\Packages;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexPackageResource extends JsonResource
{
    /** @var Package */
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
            'tracking_code' => $this->resource->tracking_code,
            'store_id' => $this->resource->store_id,
            'store_name' => $this->resource->store->name,
            'name' => $this->resource->name,
            'client_full_name' => $this->resource->client_full_name,
            'client_phone' => $this->resource->client_phone,
            'wilaya' => $this->resource->commune->wilaya->name,
            'commune' => $this->resource->commune->name,
            'delivery_type' => $this->resource->delivery_type->name,
            'status_name' => $this->resource->package_status->name,
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
