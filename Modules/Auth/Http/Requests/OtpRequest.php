<?php

namespace Modules\Auth\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\EmailPhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class OtpRequest extends FormRequest
{

    public function rules()
    {
        $route = Route::current();
        if($route->getName() == 'auth.otp'){
            return [
                'user_name' => ['bail', 'required', new EmailPhoneRule(), new BlackListRule()]
            ];
        }elseif($route->getName() == 'auth.confirm'){
            return [
                'confirm_code' => ['bail', 'required', 'min:5', 'max:5', 'regex:/^[0-9]+$/', new BlackListRule()]
            ];
        }
    }


    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'user_name' => 'ایمیل یا شماره موبایل',
            'confirm_code' => 'کد تایید'
        ];
    }

    public function messages(){
        return [
            'user_name.required' => 'وارد کردن ایمیل یا شماره موبایل الزامی است',
            'confirm_code.required' => 'وارد کردن کد تایید الزامی است',
            'confirm_code.regex' => 'کد وارد شده باید عدد باشد',
            'confirm_code.min' => 'کد تایید نباید کمتر از 5 رقم باشد',
            'confirm_code.max' => 'کد تایید نباید بیشتر از 5 رقم باشد'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'confirm_code' => convertNumbersToEnglish($this->confirm_code),
            'user_name' => convertNumbersToEnglish($this->user_name)
        ]);
    }
}
