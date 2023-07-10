<?php

return [
    'name' => 'Auth',
    'time' => 2,
    'cache_time' => 2 * 60,
    'rate_limit' => 10,
    'inputs' => [
        'user_name' => 'user_name',
        'confirm_code' => 'confirm_code'
    ],
    'messages' => [
        'format_error' => 'فرمت وارد شده معتبر نمی باشد',
        'block_account' => 'حساب کاربری مسدود شده است',
        'error_record' => 'خطا در ثبت اطلاعات',
        'invalid_code' => 'کد وارد شده معتبر نمی باشد',
    ]
];
