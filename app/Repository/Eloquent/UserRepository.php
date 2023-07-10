<?php

namespace App\Repository\Eloquent;

use App\Repository\Contracts\UserRepositoryInterface;
use Modules\User\Entities\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function model()
    {
        return User::class;
    }
}
