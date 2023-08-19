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
             'mobile' => config('constants.mobile_regex'),
            'email' => config('constants.email_regex'),
            'birth_date' => 'date_format:Y/m/d'
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
            'birth_date.date_format' => 'فرمت تاریخ معتبر نمی باشد'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'national_code' => convertNumbersToEnglish($this->national_code),
            'mobile' => convertNumbersToEnglish($this->mobile)
        ]);
    }


    public function authorize()
    {
        return true;
    }
}
