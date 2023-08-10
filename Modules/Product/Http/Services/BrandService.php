<?php

namespace Modules\Product\Http\Services;

use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
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
        return $this->brandRepository->update($request->fields(attributes: [
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

//    public function deleteBrandImage($image)
//    {
//        if (Storage::disk('public')->exists($image)) {
//            Storage::disk('public')->delete($image);
//        }
//
//        if (Storage::disk('public')->allFiles('uploads/brands') === []) {
//            Storage::disk('public')->deleteDirectory('uploads/brands');
//        }
//
//    }

    public function uploadImage(ImageService $imageService, $image)
    {
        $imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'brands');
        $imageAddress = $imageService->base64Save($image);

        return $imageAddress ?? false;
    }

}
