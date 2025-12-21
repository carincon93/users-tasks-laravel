<?php

namespace App\Users;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Users\UserResource;
use App\Users\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }


    public function store(UserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => $request->password_hash,
        ]);

        return new UserResource($user);
    }


    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => $request->password_hash,
        ]);

        return new UserResource($user);
    }
    

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}