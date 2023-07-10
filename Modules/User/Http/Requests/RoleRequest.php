<?php

namespace Modules\User\Http\Requests;

use App\Rules\BlackListRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:30', 'regex:/^([a-z A-Z]{1,30})$/', new BlackListRule()],
            'persian_name' => ['required', 'max:30', 'regex:/^([ضصثقفغعهخحجچشسیبلاتنمکگپظطزرذدئو.ءِ]{1,30})$/'],
            'status' => [new BlackListRule()]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام نقش',
            'persian_name' => 'نام نقش',
            'status' => 'وضعیت نقش'
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'نام نقش باید به صورت حروف انگلیسی باشد',
            'persian_name.regex' => 'نام نقش باید به صورت حروف فارسی باشد',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
