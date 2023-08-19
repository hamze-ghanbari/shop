<?php

namespace Modules\Product\Http\Services;

use App\Http\Services\Image\ImageService;
use App\Http\Services\Upload\Algoritms\Base64FIle;
use App\Http\Services\Upload\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Http\Requests\CategoryRequest;
use Modules\Product\Repository\CategoryRepositoryInterface;

class CategoryService
{

    public function __construct(
        public CategoryRepositoryInterface $categoryRepository,
        public ImageService $imageService
    )
    {
    }

    public function getSearchCategories(Request $request)
    {
        return $this->categoryRepository->with('parent')->search($request->query('search'))->paginate(15);
    }

    public function categoryExists(string $name){
        return $this->categoryRepository->getCategoryWithTrashed($name);
    }

    public function createCategory(CategoryRequest $request, $image)
    {
        $this->categoryRepository->create($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $image
        ]));
    }

    public function updateCategory(CategoryRequest $request, $categoryId, $imageUrl)
    {
        return $this->categoryRepository->update($request->fields(attributes: [
            'slug' => $request->fields()['name'],
            'image' => $imageUrl
        ]), $categoryId);
    }

    public function updateCategoryStatus(ProductCategory $category, $status)
    {
        return $this->categoryRepository->update([
            'show_in_menu' => $status
        ], $category->id);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }

//    public function deleteCategoryImage($image)
//    {
//        if (Storage::disk('public')->exists($image)) {
//            Storage::disk('public')->delete($image);
//        }
//
//        if (Storage::disk('public')->allFiles('uploads/category_product') === []) {
//            Storage::disk('public')->deleteDirectory('uploads/category_product');
//        }
//
//    }

    public function uploadImage($image, $type = 'file')
    {
        $this->imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'category_product');

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
