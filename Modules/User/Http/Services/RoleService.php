<?php

namespace Modules\User\Http\Services;

use Illuminate\Http\Request;
use Modules\User\Entities\Permission;
use Modules\User\Entities\Role;

class RoleService
{
    public function getSearchRoles(Request $request)
    {
        return Role::with('permissions')->search($request->query('search'))->paginate(15);
    }

    public function createRole(Request $request)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        Role::create($request->fields(attributes: ['status' => $status]));
    }

    public function updateRole(Request $request, Role $role)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        return $role->update($request->fields(attributes: ['status' => $status]));
    }

    public function updateRoleStatus(Role $role, $status){
        return $role->update([
            'status' => $status
        ]);
    }

    public function deleteRole(Role $role){
       return $role->delete();
    }

    public function getPermissions(Role $role){
        $permissions = Permission::all();
        $rolePermissionsId = $role->permissions()->pluck('id')->toArray();
        return [
            'permissions' => $permissions,
            'ids' => $rolePermissionsId
        ];
    }

    public function addPermissionToRole(Request $request, Role $role){
        $inputs = $request->all();
        $inputs['permissions'] ??= [];
        $role->permissions()->sync($inputs['permissions']);
    }

}
