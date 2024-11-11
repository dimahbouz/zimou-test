<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packages\IndexPackageStatusRequest;
use App\Http\Resources\Packages\IndexPackageStatusResource;
use App\Repositories\PackageRepository;
use Illuminate\Http\Response;

class PackageStatusController extends Controller
{
    public function index(IndexPackageStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        return IndexPackageStatusResource::collection((new PackageRepository())->indexPackageStatuses($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
