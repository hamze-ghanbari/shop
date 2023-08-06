<?php

namespace Modules\Product\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Product\Entities\Brand;
use Modules\Product\Http\Requests\BrandRequest;
use Modules\Product\Repository\BrandRepositoryInterface;

class BrandService
{

    public function __construct(
        public BrandRepositoryInterface $brandRepository
    )
    {
    }

    public function getSearchBrands(Request $request)
    {
        return $this->brandRepository->search($request->query('search'))->paginate(15);
    }

    public function createBrand(BrandRequest $request, $image)
    {
        $this->brandRepository->create($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $image
        ]));
    }

    public function updateBrand(BrandRequest $request, $brandId, $imageUrl)
    {
        return  $this->brandRepository->update($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $imageUrl
        ]), $brandId);
    }

    public function updateBrandStatus(Brand $brand, $status)
    {
        return $this->brandRepository->update([
            'status' => $status
        ], $brand->id);
    }

    public function deleteBrand($id)
    {
        return $this->brandRepository->delete($id);
    }

    public function uploadImage($imageName)
    {
        $image = $imageName;  // your base64 encoded
        $extension = explode(';', explode('/', ($image))[1])[0];
        $search = "data:image/$extension;base64,";
        $image = str_replace($search, '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(20) . '.' . $extension;
        $directory = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'brands' . DIRECTORY_SEPARATOR;
        $path = public_path($directory);
        File::makeDirectory($path, 0777, true, true);
        File::put($path . $imageName, base64_decode($image));

        return $directory.$imageName;
    }

}
