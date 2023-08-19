<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\Enums\TypeEnum;
use App\Http\Middleware\FormLimiter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Modules\Auth\Entities\Otp;
use Modules\Auth\Events\UserRegistered;
use Modules\Auth\Http\Middleware\AuthCheck;
use Modules\Auth\Http\Requests\OtpRequest;
use Modules\Auth\Http\Services\AuthService;
use Modules\User\Entities\User;

class AuthController extends Controller
{
    public function __construct(public AuthService $authService)
    {
        $this->middleware(AuthCheck::class)->except('logout');
        $this->middleware(FormLimiter::class)->only(['otp', 'confirm']);
        $this->middleware('throttle:resend-otp-limiter')->only('resendOtpCode');
    }

    public function showOtpForm()
    {
        return view('auth_module::otp');
    }

    public function otp(OtpRequest $request)
    {
        $userName = $request->input(config('auth_module.inputs.user_name'));
        $data = $this->authService->checkUserName($userName);

        DB::beginTransaction();
        try {
            $user = null;
            if (empty($data['user'])) {
                $user = $this->authService->createUser($data['newUser']);
            } else {
                $user = $data['user'];
                if (isset($user->deleted_at)) {
                    $errorMessage = config('auth_module.messages.block_account');
                    return result(
                        Response::postError(route('auth.show-otp-form'), $errorMessage),
                        back()->withErrors([config('auth_module.inputs.user_name') => $errorMessage])->withInput(['user_name'])
                    );
                }
            };
            $otp = $this->authService->createOtp($user->id, $userName, $data['type']);
            DB::commit();
        } catch (\Exception) {
            DB::rollback();
            $this->authService->errorRecord(route('auth.show-otp-form'), config('auth_module.inputs.user_name'));
        }

        if ($data['type'] === TypeEnum::Email) {
            UserRegistered::dispatch($otp->otp_code, $userName);
        } elseif ($data['type'] === TypeEnum::Mobile) {
            // send sms
        }

        return result(
            Response::postSuccess(route('auth.show-confirm-form', ['token' => $otp->token, 'code' => $otp->otp_code])),
            redirect()->route('auth.show-confirm-form', ['token' => $otp->token, 'code' => $otp->otp_code])
        );
    }

    public function showConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('auth.show-otp-form');
        } else {
            $timer = ((new Carbon($otp->created_at))->addMinutes(config('auth_module.time'))->timestamp - Carbon::now()->timestamp) * 1000;
            return view('auth_module::confirm', compact('token', 'otp', 'timer'));

        }
    }

    public function confirm($token, OtpRequest $request)
    {
        $otp = $this->authService->getOtp($token);

        $errorMessage = config('auth_module.messages.invalid_code');
        $redirect = redirect()->route('auth.show-confirm-form', $token)->withErrors([config('auth_module.inputs.confirm_code') => $errorMessage]);
        $ajaxResponse = Response::postError(route('auth.show-confirm-form', $token), $errorMessage);

        if (empty($otp)) {
            return result($ajaxResponse, $redirect);
        }

        if ($otp->otp_code !== $request->input(config('auth_module.inputs.confirm_code'))) {
            return result($ajaxResponse, $redirect);
        }

        DB::beginTransaction();
        try {

            $this->authService->updateOtpCode($otp);

            $user = $this->authService->getUserById($otp->user_id);

            if ($otp->type == TypeEnum::Email->value && empty($user->email_verified_at)) {
                $this->authService->userVerify($user->id, 'email_verified_at');
            } elseif ($otp->type == TypeEnum::Mobile->value && empty($user->mobile_verified_at)) {
                $this->authService->userVerify($user->id, 'mobile_verified_at');
            }

            $this->authService->userLogin($user, $request);
            $redirectUrl = session()->get('url.intended') ?? route('users.profile', ['user' => $user->id]);
            DB::commit();
            return result(
                Response::postSuccess($redirectUrl),
                redirect()->route('users.profile', ['user' => $user->id])
            );
        } catch (\Exception) {
            DB::rollBack();
            $this->authService->errorRecord(route('auth.show-confirm-form', $token), config('auth_module.inputs.confirm_code'));
        }


    }

    public function resendOtpCode($token)
    {

        $otp = $this->authService->getOtpWithUser($token);

        if (!isset($otp) || Carbon::now()->toDateTimeString() < (new Carbon($otp->created_at))->addMinutes(config('auth_module.time'))->toDateTimeString()) {
            return redirect()->back();
        }

        $otpData = $this->authService->createOtp($otp->user_id, $otp->login_id, $otp->type);

        if ($otp->type === TypeEnum::Email->value) {
            UserRegistered::dispatch($otpData->otp_code, $otp->login_id);
        } elseif ($otp->type === TypeEnum::Mobile->value) {
            // send sms
        }

        return redirect()->route('auth.show-confirm-form', ['token' => $otpData->token, 'code' => $otpData->otp_code]);

    }

    public function logout(Request $request)
    {
        $this->authService->logOut($request);
        return redirect()->route('auth.show-otp-form');
    }

}
