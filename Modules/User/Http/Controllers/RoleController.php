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
        if($this->roleService->roleExists($request->input('name'), $request->input('persian_name'))){
            $message = 'این نقش قبلا ثبت شده است';
            return result(
                Response::postError(route('roles.create'), $message),
                redirect()->route('roles.create')->with('add-error', $message)->withInput($request->except('status'))
            );
        }

        $this->roleService->createRole($request);
        $message = 'ثبت نقش با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('roles.create'), $message),
            redirect()->route('roles.create')->with('add-success', $message)
        );
    }

    public function edit(Role $role)
    {
        return view('user_module::roles.create', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        // req
        // role
//        if($this->roleService->roleExists($request->input('name'), $request->input('persian_name'))
//            && ($role->name !== $request->input('name') || $role->persian_name !== $request->input('persian_name'))){
//            $message = 'این نقش قبلا ثبت شده است';
//            return result(
//                Response::postError(route('roles.edit', $role), $message),
//                redirect()->route('roles.edit', $role)->with('add-error', $message)->withInput($request->except('status'))
//            );
//        }

        $role = $this->roleService->updateRole($request, $role);
        if ($role) {
            return result(
                Response::postSuccess(route('roles.index'), 'ویرایش نقش با موفقیت انجام شد', ['updated' => true]),
                redirect()->route('roles.index')
            );
        } else {
            $message = 'خطا در ویرایش نقش';
            return result(
                Response::postError(route('roles.edit', $role), $message),
                redirect()->route('roles.edit', $role)->with('add-error', $message)->withInput($request->except('status'))
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
        $roleDelete = $this->roleService->deleteRole($role->id);
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
       $message = 'ثبت سطوح دسترسی با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('roles.index'), $message),
            redirect()->route('roles.index')
        );
    }

}
