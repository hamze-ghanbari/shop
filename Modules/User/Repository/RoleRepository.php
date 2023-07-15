<?php

namespace Modules\User\Repository;

use App\Repository\Eloquent\BaseRepository;
use Modules\User\Entities\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function model()
    {
        return User::class;
    }

    public function getUserByField($field, $value){
        return $this->findWhere([$field => $value])->withTrashed()->first();
    }

}
