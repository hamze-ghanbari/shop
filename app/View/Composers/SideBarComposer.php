<?php

namespace App\View\Composers;


use Illuminate\View\View;

class SideBarComposer
{
    public function compose(View $view): void
    {
        $view->with('items', $this->items());
    }

    private function items()
    {
        return [
            [
                'name' => 'داشبورد',
                'icon' => 'fa-tachometer-alt',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت کاربران',
                'icon' => 'fa-users',
                'childs' => [
                    [
                        'name' => 'نمایش کاربران',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'کاربران حذف شده',
                        'route' => 'users.index'
                    ]
                ],
            ],
            [
                'name' => 'مدیریت محصولات',
                'icon' => 'fa-shopping-bag',
                'childs' => [
                    [
                        'name' => 'نمایش محصولات',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'دسته بندی ها',
                        'route' => 'categories.index'
                    ],
                    [
                        'name' => ' پرسش کاربران',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'نظرات کاربران',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'محصولات حذف شده',
                        'route' => 'users.index'
                    ]
                ],
            ],
            [
                'name' => 'مدیریت کدهای تخفیف',
                'icon' => 'fa-barcode',
                'childs' => [
                    [
                        'name' => 'کدهای تخفیف عمومی',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'کدهای تخفیف زمان دار',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'کدهای تخفیف اختصاصی',
                        'route' => 'users.index'
                    ],
                ],
            ],
            [
                'name' => 'مدیریت نقش ها',
                'icon' => 'fa-user-cog',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت پیامک ها',
                'icon' => 'fa-sms',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت ایمیل ها',
                'icon' => 'fa-mail-bulk',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت نوتیفیکیشن ها',
                'icon' => 'fa-bell',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت فایل ها',
                'icon' => 'fa-file',
                'childs' => [
                    [
                        'name' => 'نمایش تصاویر',
                        'route' => 'users.index'
                    ],
                    [
                        'name' => 'نمایش ویدیو ها',
                        'route' => 'users.index'
                    ],
                ],
            ],
            [
                'name' => 'مدیریت سفارشات',
                'icon' => 'fa-chart-area',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت تیکت ها',
                'icon' => 'fa-ticket-alt',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت پیام ها',
                'icon' => 'fa-envelope',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت دسته بندی ها',
                'icon' => 'fa-bars',
                'route' => 'roles.index',
            ],
            [
                'name' => 'مدیریت بنرها',
                'icon' => 'fa-image',
                'route' => 'roles.index',
            ],
            [
                'name' => 'آمار بازدیدکنندگان',
                'icon' => 'fa-eye',
                'route' => 'roles.index',
            ],
        ];
    }
}
