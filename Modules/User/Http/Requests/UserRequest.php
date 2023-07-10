<?php

namespace Modules\User\Http\Requests;

use App\Rules\BlackListRule;
use App\Rules\NationalCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'first_name' => ['max:30', new BlackListRule()],
            'last_name' => [ 'max:30', new BlackListRule()],
            'national_code' => [new NationalCodeRule()],
            'mobile' => [config('constants.mobile_regex')],
            'email' => [config('constants.email_regex')],
            'birth_date' => ['regex:/^([1][3|4][0-9]{2}\/[0-9]{2}\/[0-9]{2})$/']
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'national_code' => 'کد ملی',
            'mobile' => 'موبایل',
            'email' => 'ایمیل',
        ];
    }

    public function messages(){
        return [
            'birth_date.regex' => 'فرمت تاریخ معتبر نمی باشد'
        ];
    }



    public function authorize()
    {
        return true;
    }
}
