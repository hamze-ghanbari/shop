<?php

namespace Modules\Product\Http\Services;

use App\Http\Services\Image\ImageService;
use App\Http\Services\Upload\Algoritms\Base64FIle;
use App\Http\Services\Upload\Upload;
use Illuminate\Http\Request;
use Modules\Product\Entities\Brand;
use Modules\Product\Http\Requests\BrandRequest;
use Modules\Product\Repository\BrandRepositoryInterface;

class BrandService
{

    public function __construct(
        public BrandRepositoryInterface $brandRepository,
        public ImageService $imageService
    )
    {
    }

    public function getSearchBrands(Request $request)
    {
        return $this->brandRepository->search($request->query('search'))->paginate(15);
    }

    public function brandExists(string $name){
        return $this->brandRepository->getBrandWithTrashed($name);
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

    public function uploadImage($image, $type = 'file')
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'brands');

        if ($type == 'file'){
            $file = new \App\Http\Services\Upload\Algoritms\File($this->imageService, $image);
        }else{
            $file = new Base64FIle($this->imageService, $image);
        }
        $upload = new Upload($file);
        $imageAddress = $upload->upload();

        return $imageAddress ?? false;
    }

}
