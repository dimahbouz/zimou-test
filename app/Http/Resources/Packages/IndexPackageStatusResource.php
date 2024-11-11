<?php

namespace App\Http\Resources\Packages;

use App\Models\PackageStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexPackageStatusResource extends JsonResource
{
    /** @var PackageStatus */
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
