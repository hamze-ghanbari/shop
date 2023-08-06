<?php

namespace Modules\Product\Repository;

use App\Repository\Eloquent\BaseRepository;
use Modules\Product\Entities\Brand;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{

    public function model()
    {
        return Brand::class;
    }

    public function search($search){
      return $this->getModel()->search($search);
    }

}
