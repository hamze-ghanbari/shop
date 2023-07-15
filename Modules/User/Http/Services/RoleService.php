<?php

namespace Modules\User\Http\Services;

use Illuminate\Http\Request;
use Modules\User\Entities\Permission;
use Modules\User\Entities\Role;
use Modules\User\Repository\RoleRepositoryInterface;

class RoleService
{

    public function __construct(
        public RoleRepositoryInterface $roleRepository
    ){}

    public function getSearchRoles(Request $request)
    {
        return $this->roleRepository->with('permissions')->search($request->query('search'))->paginate(15);
    }

    public function createRole(Request $request)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        $this->roleRepository->create($request->fields(attributes: ['status' => $status]));
    }

    public function updateRole(Request $request, Role $role)
    {
        $status = $request->has('status') ? $request->input('status') : 0;
        return $this->roleRepository->update($request->fields(attributes: ['status' => $status]), $role->id);
    }

    public function updateRoleStatus(Role $role, $status){
        return $this->roleRepository->update([
            'status' => $status
        ], $role->id);
    }

    public function deleteRole($id){
       return $this->roleRepository->delete($id);
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
