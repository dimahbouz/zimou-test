<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Packages\IndexDeliveryTypeRequest;
use App\Http\Resources\Packages\IndexDeliveryTypeResource;
use App\Repositories\PackageRepository;
use Illuminate\Http\Response;

class DeliveryTypeController extends Controller
{
    public function index(IndexDeliveryTypeRequest $request): \Illuminate\Http\JsonResponse
    {
        return IndexDeliveryTypeResource::collection((new PackageRepository())->indexDeliveryTypes($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
