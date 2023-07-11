<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Http\Services\UserService;

class UserController extends Controller
{

    public function __construct(public UserService $userService)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = $this->userService->getSearchUsers($request);
        return view('user_module::users.index', compact('users'));
    }

    public function create()
    {
        return view('user_module::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(User $user)
    {
        $years = [];
        for ($year = jalaliDate(time(), 'Y'); $year > 1320; $year-- ){
            array_push($years, $year);
        }
        $months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];

        $days = [];
        for ($day = 1; $day <= 31; $day++){
            array_push($days, $day);
        }

        list($userYear, $userMonth, $userDay) = isset($user->birth_date)
            ? explode('/', $user->birth_date)
            : [null, null, null];

        return view('user_module::users.detail', compact('user', 'years', 'months', 'days', 'userYear', 'userMonth', 'userDay'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('user_module::users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function showRoles(User $user)
    {
        $getRoles = $this->userService->getRoles($user);
        $roles = $getRoles['roles'];
        $userRoleId = $getRoles['ids'];
        return view('user_module::users.add-role', compact('roles', 'user', 'userRoleId'));
    }

    public function addRoleToUser(UserRequest $request, User $user)
    {
        $this->userService->addRoleToUser($request, $user);
        return result(
            Response::postSuccess(route('users.index'), 'ثبت نقش برای کاربر با موفقیت انجام شد'),
            redirect()->route('users.index')
        );
    }


    public function showPermissions(User $user)
    {
        $getPermissions = $this->userService->getPermissions($user);
        $permissions = $getPermissions['permissions'];
        $rolePermissionsId = $getPermissions['ids'];
        return view('user_module::users.add-permissions', compact('user', 'permissions', 'rolePermissionsId'));
    }

    public function addPermissionToUser(UserRequest $request, User $user)
    {
     $this->userService->addPermissionToUser($request, $user);
        return result(
            Response::postSuccess(route('users.index'), 'ثبت سطوح دسترسی برای کاربر با موفقیت انجام شد'),
            redirect()->route('users.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $userDelete = $this->userService->deleteUser($user);
        if ($userDelete) {
            return result(
                Response::postSuccess(route('users.index'), 'حذف کاربر با موفقیت انجام شد'),
                redirect()->route('users.index')
            );
        } else {
            return result(
                Response::postError(route('users.index'), 'خطا در حذف کاربر'),
                redirect()->route('users.index')
            );
        }
    }

    public function updateName(UserRequest $request, User $user){
        $updated = $user->update($request->fields());
        if ($updated) {
            return result(
                Response::postSuccess(route('users.profile', ['user' => $user->id]), 'ویرایش با موفقیت انجام شد',
                ['fullName' => $user->fullName]),
                redirect()->back()
            );
        } else {
            return result(
                Response::postError(route('users.profile', ['user' => $user->id]), 'خطا در ویرایش'),
                redirect()->back()
            );
        }
    }

    public function updateBirthDate(UserRequest $request, User $user){
//        $time = str_replace('-', '', $request->input('birth_date'));
//        $time = substr($time, 0 , -3);
//        $birthDate = jalaliDate(date('Y/m/d', $time), 'Y/m/d');

        $updated = $user->update($request->fields());
        if ($updated) {
            return result(
                Response::postSuccess(route('users.profile', ['user' => $user->id]), 'ویرایش با موفقیت انجام شد',),
                redirect()->back()
            );
        } else {
            return result(
                Response::postError(route('users.profile', ['user' => $user->id]), 'خطا در ویرایش'),
                redirect()->back()
            );
        }
    }

    public function updatenatioanlCode(UserRequest $request, User $user){
        $updated = $user->update($request->fields());
        if ($updated) {
            return result(
                Response::postSuccess(route('users.profile', ['user' => $user->id]), 'ویرایش با موفقیت انجام شد',
                ['nationalCode' => $request->input('national_code')]),
                redirect()->back()
            );
        } else {
            return result(
                Response::postError(route('users.profile', ['user' => $user->id]), 'خطا در ویرایش'),
                redirect()->back()
            );
        }
    }

    public function download(User $user)
    {
    }
}
