<?php

namespace App\Users;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Users\UserResource;
use App\Users\Requests\StoreUserRequest;
use App\Users\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /** 
     * 
     * Returns a list of users.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($this->userService->index())
        ]);
    }

    /** 
     * 
     * Creates a new user.
     * 
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->userService->store($request)
        ]);
    }

    /** 
     * 
     * Updates an existing user.
     * 
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->userService->update($request, $user)
        ]);
    }

    /** 
     * 
     * Deletes an existing user.
     * 
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->userService->destroy($user)
        ]);
    }
}
