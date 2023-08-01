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
use Modules\Auth\Repository\OtpRepositoryInterface;
use Modules\User\Entities\User;
use Modules\User\Repository\UserRepositoryInterface;

class AuthService
{
    private TypeEnum $type;
    private $newUser = null;
    private User|null $user;

    public function __construct(
        public OtpRepositoryInterface  $otpRepository,
        public UserRepositoryInterface $userRepository
    )
    {
    }


    private function getUserByEmail($email)
    {
        $this->type = TypeEnum::Email;
        $this->user = $this->userRepository->getUserByField('email', $email);
        if (empty($this->user)) {
            $this->newUser['email'] = $email;
        }
    }

    private function getUserByMobile($mobile)
    {
        $this->type = TypeEnum::Mobile;
        $this->user = $this->userRepository->getUserByField('mobile', $mobile);
        if (empty($this->user)) {
            $this->newUser['mobile'] = $mobile;
        }
    }

    public function checkUserName($userName)
    {
        if (preg_match('/^' . config('constants.email_regex') . '$/', $userName)) {

            $this->getUserByEmail($userName);

        } elseif (preg_match('/^' . config('constants.mobile_regex') . '$/', $userName)) {

            $this->getUserByMobile($userName);

        } else {
            $errorMessage = config('auth_module.messages.format_error');
            return result(
                Response::postError(route('auth.show-otp-form'), $errorMessage),
                redirect()->route('auth.show-otp-form')->withErrors([config('auth_module.inputs.user_name') => $errorMessage])
            );
        }

        return [
            'type' => $this->type,
            'user' => $this->user,
            'newUser' => $this->newUser
        ];
    }

    public function createUser($newUser): User
    {
        $newUser['activation'] = ActivationEnum::UserActive->value;
        return $this->userRepository->create($newUser);
    }

    public function createOtp($userId, $userName, $type): Otp
    {
        $otpCode = randomNumber();
        $token = Str::random(60);
        return $this->otpRepository->create([
            'token' => $token,
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'login_id' => $userName,
            'type' => $type
        ]);
    }

    public function getOtp($token): mixed
    {
        return $this->otpRepository->findWhere([
            'token' => $token,
            'used' => UsedEnum::NotUsed->value,
            'status' => StatusEnum::Active->value,
            ['created_at', '>=', Carbon::now()->subMinutes(config('auth_module.time'))->toDateTimeString()]
        ])->first();

    }

    public function getOtpWithUser($token)
    {
        return $this->otpRepository->with('user')->where('token', $token)->first();
    }

    public function updateOtpCode($otp)
    {
        // update current otp code
        $this->otpRepository->update([
            'used' => UsedEnum::Used->value,
            'status' => StatusEnum::InActive->value
        ], $otp->id);

        // update other otp code
        $this->otpRepository
            ->findWhere(['user_id' => $otp->user_id, 'status' => StatusEnum::Active->value])
            ->update(['status' => StatusEnum::InActive->value]);
    }

    public function userVerify($userId, $verifyField)
    {
        $this->userRepository->update([
            $verifyField => Carbon::now()
        ], $userId);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->find($userId);
    }

    public function userLogin($user, $request)
    {
        Auth::login($user);
        $request->session()->regenerate();
    }

    public function logOut($request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function errorRecord($url, $input)
    {
        $errorMessage = config('auth_module.messages.error_record');
        return result(
            Response::postError($url, $errorMessage),
            redirect()->back()->withErrors([$input => $errorMessage])
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
