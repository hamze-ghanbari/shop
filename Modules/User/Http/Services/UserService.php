<?php

namespace Modules\User\Http\Services;

use Illuminate\Http\Request;
use Modules\User\Entities\Permission;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserRequest;

class UserService
{
    public function getSearchUsers(Request $request){
        return User::with('roles')->search($request->query('search'), $request->query('filter-date'))->paginate(15);
    }

    public function getRoles(User $user){
        $roles = Role::all();
        $userRoleId = $user->roles()->pluck('id')->toArray();
        return [
            'roles' => $roles,
            'ids' => $userRoleId
        ];
    }

    public function addRoleToUser(UserRequest $request, User $user){
        $inputs = $request->all();
        $inputs['roles'] ??= [];
        $user->roles()->sync($inputs['roles']);
    }

    public function getPermissions(User $user){
        $permissions = Permission::all();
        $rolePermissionsId = $user->permissions()->pluck('id')->toArray();
        return [
            'permissions' => $permissions,
            'ids' => $rolePermissionsId
        ];
    }

    public function addPermissionToUser(UserRequest $request, User $user){
        $inputs = $request->all();
        $inputs['permissions'] ??= [];
        $user->permissions()->sync($inputs['permissions']);
    }

    public function deleteUser(User $user){
        return $user->delete();
    }

}
