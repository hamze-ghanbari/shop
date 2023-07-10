<?php

namespace Modules\Auth\Http\Services;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Modules\Auth\Emails\OtpMail;
use Modules\Auth\Entities\Otp;
use Modules\Auth\Enums\ActivationEnum;
use Modules\Auth\Enums\StatusEnum;
use Modules\Auth\Enums\TypeEnum;
use Modules\Auth\Enums\UsedEnum;
use Modules\User\Entities\User;

class AuthService
{

    public function checkUserName($userName)
    {
        $newUser = null;
        if (preg_match('/^' . config('constants.email_regex') . '$/', $userName)) {
            $type = TypeEnum::Email;
            $user = User::where('email', $userName)->withTrashed()->first();
            if (empty($user)) {
                $newUser['email'] = $userName;
            }
        } elseif (preg_match('/^' . config('constants.mobile_regex') . '$/', $userName)) {
            $type = TypeEnum::Mobile;
            $user = User::where('mobile', $userName)->withTrashed()->first();
            if (empty($user)) {
                $newUser['mobile'] = $userName;
            }
        } else {
            $errorMessage = config('auth_module.messages.format_error');
            return result(
                Response::postError(route('auth.show-otp-form'), $errorMessage),
                redirect()->route('auth.show-otp-form')->withErrors([config('auth_module.inputs.user_name') => $errorMessage])
            );
        }

        return [
            'type' => $type,
            'user' => $user,
            'newUser' => $newUser
        ];
    }

    public function createUser($newUser): User
    {
        $newUser['activation'] = ActivationEnum::UserActive->value;
        return User::create($newUser);
    }

    public function createOtp($userId, $userName, $type): Otp
    {
        $otpCode = randomNumber();
        $token = Str::random(60);
        return Otp::create([
            'token' => $token,
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'login_id' => $userName,
            'type' => $type
        ]);
    }

    public function getOtp($token): mixed
    {
        return Otp::where([
            'token' => $token,
            'used' => UsedEnum::NotUsed->value,
            'status' => StatusEnum::Active->value,
        ])->where('created_at', '>=', Carbon::now()->subMinutes(config('auth_module.time'))->toDateTimeString())->first();
    }

    public function getOtpWithUser($token){
       $otp = Otp::with('user')->where('token', $token)->first();
        if (empty($otp) || Carbon::now()->toDateTimeString() < (new Carbon($otp->created_at))->addMinutes(config('auth_module.time'))->toDateTimeString()) {
            return redirect()->back();
        }
        return $otp;
    }

    public function updateOtpCode($otp){
        $otp->update(['used' => UsedEnum::Used->value, 'status' => StatusEnum::InActive->value]);
        Otp::where(['user_id' => $otp->user_id, 'status' => StatusEnum::Active->value])->update(['status' => StatusEnum::InActive->value]);
    }

    public function userVerify($user, $verifyField){
        $user->update([$verifyField => Carbon::now()]);
    }

    public function getUserById($userId){
        return User::find($userId);
    }

    public function userLogin($user, $request){
        Auth::login($user);
        $request->session()->regenerate();
    }

    public function logOut($request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function errorRecord($url, $input){
        $errorMessage = config('auth_module.messages.error_record');
        return result(
            Response::postError($url, $errorMessage),
            back()->withErrors([$input => $errorMessage])
        );
    }

    public function sendEmail($otpCode, $userName)
    {
        $emailService = new EmailService();
        $details = [
            'title' => 'کد تایید دیجی کالا',
            'code' => "$otpCode"
        ];
        $emailService
            ->details($details)
            ->mailClass(OtpMail::class)
            ->subject('کد احراز هویت')
            ->to($userName);

        $messagesService = new MessageService($emailService);
        $messagesService->send();
    }

    public function sendSms()
    {

    }

}
