<?php

namespace App\Roles;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Roles\Requests\StoreRoleRequest;
use App\Roles\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Roles\RoleService;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    public $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /** 
     * 
     * Returns a list of roles.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $this->roleService->index()
            ]
        );
    }

    /** 
     * 
     * Creates a new role.
     * 
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $this->roleService->store($request)
            ]
        );
    }

    /** 
     * 
     * Returns a specific role.
     * 
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $this->roleService->show($role)
            ]
        );
    }

    /** 
     * 
     * Updates an existing role.
     * 
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $this->roleService->update($request, $role)
            ]
        );
    }

    /** 
     * 
     * Deletes an existing role.
     * 
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $this->roleService->destroy($role)
            ]
        );
    }
}
