<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Response;

class StatisticsController extends Controller
{
    public function dashboard(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'usersCount' => User::count(),
            'storesCount' => Store::count(),
            'packagesCount' => Package::count(),
        ])->setStatusCode(Response::HTTP_OK);
    }
}
