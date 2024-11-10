<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->merge(['password' => bcrypt($request->password)]);
        abort_if(is_null($user = (new UserRepository())->create($request)), Response::HTTP_INTERNAL_SERVER_ERROR);
        return UserResource::make($user)->additional([
            'accessToken' => $user->createToken('register')->plainTextToken,
        ])->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
