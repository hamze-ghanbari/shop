<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\User\Entities\Role;
use Modules\User\Http\Requests\RoleRequest;
use Modules\User\Http\Services\RoleService;

class RoleController extends Controller
{

    public function __construct(public RoleService $roleService)
    {
        $this->middleware('auth');
//        $this->middleware('can:create-post');
//        $this->middleware('role:admin');

    }

    public function index(Request $request)
    {

//        if ($request->query('search')) {
        $roles = $this->roleService->getSearchRoles($request);
//        } else {
//            $roles = Role::with('permissions')->paginate(15);
//        }

//        $roles->appends(['search' => $request->query('search'), 'page' => 1]);
        return view('user_module::roles.index', compact('roles'));
    }

    public function create()
    {
        return view('user_module::roles.create');
    }


    public function store(RoleRequest $request)
    {
        $this->roleService->createRole($request);

        return result(
            Response::postSuccess(route('roles.create'), 'ثبت نقش با موفقیت انجام شد'),
            redirect()->route('roles.index')
        );
    }

    public function edit(Role $role)
    {
        return view('user_module::roles.create', compact('role'));
    }


    public function update(RoleRequest $request, Role $role)
    {
        $role = $this->roleService->updateRole($request, $role);
        if ($role) {
            return result(
                Response::postSuccess(route('roles.index'), 'ویرایش نقش با موفقیت انجام شد', ['updated' => true]),
                redirect()->route('roles.index')
            );
        } else {
            return result(
                Response::postError(route('roles.create'), 'خطا در ویرایش نقش'),
                redirect()->route('roles.create')
            );
        }
    }

    public function changeStatus(Role $role, $status)
    {
        $statusNum = isset($status) && $status == 1 ? 0 : 1;
        $updated = $this->roleService->updateRoleStatus($role, $status);
        if ($updated) {
            return result(
                Response::postSuccess(route('roles.status', ['role' => $role->id, 'status' => $statusNum]), 'ویرایش وضعیت نقش با موفقیت انجام شد', ['changed' => $status]),
                redirect()->route('roles.index')
            );
        } else {
            return result(
                Response::postError(route('roles.index'), 'خطا در ویرایش وضعیت نقش'),
                redirect()->route('roles.index')
            );
        }
    }

    public function destroy(Role $role)
    {
        $roleDelete = $this->roleService->deleteRole($role);
        if ($roleDelete) {
            return result(
                Response::postSuccess(route('roles.index'), 'حذف نقش با موفقیت انجام شد'),
                redirect()->route('roles.index')
            );
        } else {
            return result(
                Response::postError(route('roles.index'), 'خطا در حذف نقش'),
                redirect()->route('roles.index')
            );
        }
    }

    public function showPermissions(Role $role)
    {

        $getPermission = $this->roleService->getPermissions($role);

        $permissions = $getPermission['permissions'];
        $rolePermissionsId = $getPermission['ids'];
        return view('user_module::roles.add-permissions', compact('role', 'permissions', 'rolePermissionsId'));
    }

    public function addPermissionToRole(Request $request, Role $role)
    {
       $this->roleService->addPermissionToRole($request, $role);
        return result(
            Response::postSuccess(route('roles.index'), 'ثبت سطوح دسترسی با موفقیت انجام شد'),
            redirect()->route('roles.index')
        );
    }
}
