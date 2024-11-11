<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packages\IndexRequest;
use App\Http\Resources\Packages\IndexPackageResource;
use App\Repositories\PackageRepository;
use Illuminate\Http\Response;

class PackageController extends Controller
{
    public function index(IndexRequest $request): \Illuminate\Http\JsonResponse
    {
        return IndexPackageResource::collection((new PackageRepository())->index($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
