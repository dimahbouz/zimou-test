<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where([
            'email' => $request->email
        ])->first();
        abort_if((!$user or !Hash::check($request->password, $user->password)), Response::HTTP_UNAUTHORIZED, 'Invalid email or password');
        return UserResource::make($user)->additional([
            'accessToken' => $user->createToken('login')->plainTextToken
        ])->response()->setStatusCode(Response::HTTP_OK);
    }
}
