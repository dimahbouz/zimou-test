<?php

namespace App\Http\Controllers\Wilayas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wilayas\IndexWilayaRequest;
use App\Http\Resources\Wilayas\WilayaResource;
use App\Repositories\WilayaRepository;
use Illuminate\Http\Response;

class WilayaController extends Controller
{
    public function index(IndexWilayaRequest $request): \Illuminate\Http\JsonResponse
    {
        return WilayaResource::collection((new WilayaRepository())->index($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
