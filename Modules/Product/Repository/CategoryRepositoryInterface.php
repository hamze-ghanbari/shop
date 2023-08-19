<?php

namespace Modules\Product\Repository;

use App\Repository\Contracts\BaseRepositoryInterface;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{

    public function getCategoryWithTrashed($name);
}
