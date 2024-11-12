<?php

namespace App\Http\Controllers\Communes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communes\IndexCommuneRequest;
use App\Http\Resources\Communes\CommuneResource;
use App\Repositories\CommuneRepository;
use Illuminate\Http\Response;

class CommuneController extends Controller
{
    public function index(IndexCommuneRequest $request): \Illuminate\Http\JsonResponse
    {
        return CommuneResource::collection((new CommuneRepository())->index($request))->response()->setStatusCode(Response::HTTP_OK);
    }
}
