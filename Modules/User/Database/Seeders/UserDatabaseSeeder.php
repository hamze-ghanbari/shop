<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Permission;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $permissions = [
            'read-banner' => 'دیدن بنر',
            'create-banner' => 'ایجاد بنر',
            'edit-banner' => 'ویرایش بنر',
            'delete-banner' => 'حذف بنر',
            'read-discount' => 'دیدن کد تخفیف',
            'create-discount' => 'ایجاد کد تخفیف',
            'edit-discount' => 'ویرایش کد تخفیف',
            'delete-discount' => 'حذف کد تخفیف',
            'read-post' => 'دیدن پست',
            'create-post' => 'ایجاد پست',
            'edit-post' => 'ویرایش پست',
            'delete-post' => 'حذف پست',
            'read-product' => 'دیدن محصول',
            'create-product' => 'ایجاد محصول',
            'edit-product' => 'ویرایش محصول',
            'delete-product' => 'حذف محصول',
            'read-ticket' => 'دیدن تیکت',
            'create-ticket' => 'ایجاد تیکت',
            'edit-ticket' => 'ویرایش تیکت',
            'delete-ticket' => 'حذف تیکت',
            'read-user' => 'دیدن کاربر',
            'create-user' => 'ایجاد کاربر',
            'edit-user' => 'ویرایش کاربر',
            'delete-user' => 'حذف کاربر'
        ];

        foreach ($permissions as $key => $value) {
            Permission::updateOrCreate(
                ['name' => $key],
                ['persian_name' => $value]
            );
        }

        // $this->call("OthersTableSeeder");
    }
}
