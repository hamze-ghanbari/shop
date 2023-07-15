<?php

namespace Modules\User\Repository;

use App\Repository\Eloquent\BaseRepository;
use Modules\User\Entities\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function model()
    {
        return Role::class;
    }


}
