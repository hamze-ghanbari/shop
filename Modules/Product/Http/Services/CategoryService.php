<?php

namespace Modules\Product\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        return  $this->categoryRepository->update($request->fields(attributes: [
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

    public function uploadImage($imageName)
    {
        $image = $imageName;  // your base64 encoded
        $extension = explode(';', explode('/', ($image))[1])[0];
        $search = "data:image/$extension;base64,";
        $image = str_replace($search, '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(20) . '.' . $extension;
        $directory = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'category_product' . DIRECTORY_SEPARATOR;
        $path = public_path($directory);
        File::makeDirectory($path, 0777, true, true);
        File::put($path . $imageName, base64_decode($image));

        return $directory.$imageName;
    }

}
