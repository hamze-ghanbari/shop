<?php

namespace Modules\User\Repository;

interface UserRepositoryInterface
{
    public function getUserByField(string $field, string $value);
}
