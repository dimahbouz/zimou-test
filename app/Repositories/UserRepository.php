<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
    public function create(Request $request): \Illuminate\Database\Eloquent\Model|User
    {
        return User::create($request->only(['name', 'email', 'password']));
    }
}
