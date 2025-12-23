<?php

namespace App\Roles;

use App\Models\Role;
use App\Roles\Requests\StoreRoleRequest;
use App\Roles\Requests\UpdateRoleRequest;

class RoleService
{
    /** 
     * 
     * Returns a list of roles.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    /** 
     * 
     * Creates a new role.
     * 
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);

        return new RoleResource($role);
    }

    /** 
     * 
     * Returns a specific role.
     * 
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /** 
     * 
     * Updates an existing role.
     * 
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
        ]);

        return new RoleResource($role);
    }

    /** 
     * 
     * Deletes an existing role.
     * 
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->noContent();
    }
}
