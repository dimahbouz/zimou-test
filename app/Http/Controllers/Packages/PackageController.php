<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packages\IndexRequest;
use App\Http\Requests\Packages\storePackageRequest;
use App\Http\Resources\Packages\IndexPackageResource;
use App\Models\PackageStatus;
use App\Repositories\PackageRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(IndexRequest $request): \Illuminate\Http\JsonResponse
    {
        return IndexPackageResource::collection((new PackageRepository())->index($request))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function store(storePackageRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->merge([
            'uuid' => Str::uuid(),
            'tracking_code' => Str::random(14),
            'status_id' => PackageStatus::where('name', 'created')->first()->id,
        ]);
        abort_if(!($package = (new PackageRepository())->store($request)), Response::HTTP_INTERNAL_SERVER_ERROR);
        return IndexPackageResource::make($package)->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
