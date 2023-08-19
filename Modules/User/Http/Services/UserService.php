<?php

namespace Modules\User\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\User\Entities\Permission;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repository\RoleRepository;
use Modules\User\Repository\UserRepository;

class UserService
{
    public function __construct(
        public UserRepository $userRepository,
        public RoleRepository $roleRepository
    )
    {
    }

    public function getSearchUsers(Request $request)
    {
        if (config('cache.entities.user')) {
            return Cache::remember('users', config('cache.entities_cache_time'), function () use ($request) {
                return $this->userRepository->with('roles')->search($request->query('search'), $request->query('filter-date'))->paginate(15);
            });
        }
//        return $this->userRepository->with('roles')->search($request->query('search'), $request->query('filter-date'))->paginate(15);
    }

    public function getRoles(User $user)
    {
        $roles = $this->roleRepository->getRoles();
        $userRoleId = $user->roles()->pluck('id')->toArray();
        return [
            'roles' => $roles,
            'ids' => $userRoleId
        ];
    }

    public function addRoleToUser(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['roles'] ??= [];
        $user->roles()->sync($inputs['roles']);
    }

    public function getPermissions(User $user)
    {
        $permissions = Permission::all();
        $rolePermissionsId = $user->permissions()->pluck('id')->toArray();
        return [
            'permissions' => $permissions,
            'ids' => $rolePermissionsId
        ];
    }

    public function addPermissionToUser(UserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs['permissions'] ??= [];
        $user->permissions()->sync($inputs['permissions']);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    public function updateProfile($fields, $id)
    {
        return $this->userRepository->update($fields, $id);
    }

}
