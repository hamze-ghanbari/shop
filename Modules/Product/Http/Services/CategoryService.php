<?php

namespace Modules\Product\Http\Services;

use App\Http\Services\Image\ImageService;
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
        public CategoryRepositoryInterface $categoryRepository
    )
    {
    }

    public function getSearchCategories(Request $request)
    {
        return $this->categoryRepository->with('parent')->search($request->query('search'))->paginate(15);
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

    public function deleteCategoryImage($image)
    {
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        if (Storage::disk('public')->allFiles('uploads/category_product') === []) {
            Storage::disk('public')->deleteDirectory('uploads/category_product');
        }

    }

    public function uploadImage(ImageService $imageService, $image)
    {
        $imageService->setExclusiveDirectory('uploads' . DIRECTORY_SEPARATOR . 'category_product');
        $imageAddress = $imageService->base64Save($image);

//        $directory = 'uploads' . DIRECTORY_SEPARATOR . 'category_product' . DIRECTORY_SEPARATOR;
//
//        if (!Storage::disk('public')->put($directory.$imageName, base64_decode($image))) {
//            return Response::postError(route('categories.index'), 'خطا در آپلود تصویر');
//        }

        return $imageAddress ?? false;
    }

}
