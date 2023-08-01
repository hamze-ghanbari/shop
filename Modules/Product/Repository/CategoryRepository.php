<?php

namespace Modules\Product\Repository;

use App\Repository\Eloquent\BaseRepository;
use Modules\Product\Entities\ProductCategory;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function model()
    {
        return ProductCategory::class;
    }

}
