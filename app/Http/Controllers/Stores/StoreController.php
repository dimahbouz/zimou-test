<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stores\IndexRequest;
use App\Http\Resources\Stores\IndexStoreResource;
use App\Repositories\StoreRepository;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function index(IndexRequest $request): \Illuminate\Http\JsonResponse
    {
        return IndexStoreResource::collection((new StoreRepository())->index($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
