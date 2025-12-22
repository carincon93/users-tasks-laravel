<?php

namespace App\Users;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Users\UserResource;
use App\Users\Requests\StoreUserRequest;
use App\Users\Requests\UpdateUserRequest;

class UserService
{
    /**
     * Returns a list of users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Creates a new user.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        return new UserResource($user);
    }

    /**
     * Updates an existing user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        return new UserResource($user);
    }

    /**
     * Deletes an existing user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
