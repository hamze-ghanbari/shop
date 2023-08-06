<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Product\Entities\ProductCategory;
use Modules\Product\Http\Requests\CategoryRequest;
use Modules\Product\Http\Services\CategoryService;

class CategoryController extends Controller
{

    public function __construct(
        public CategoryService $categoryService
    )
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getSearchCategories($request);
        return view('product::categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $categories = $this->categoryService->getSearchCategories($request);
        return view('product::categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request, ImageService $imageService)
    {

//        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'category_product');
//        $img = $imageService->createIndexAndSave($request->input('image'));
//        if ($img == false) {
//            $message = 'خطا در آپلود تصویر';
//            return result(
//                Response::postError(route('categories.create'), $message),
//                redirect()->route('categories.create')->withErrors([
//                    'image' => $message,
//                ])->onlyInput('image')
//            );
//        }
        $imageUrl = $this->categoryService->uploadImage($request->input('image'));

        $this->categoryService->createCategory($request,  $imageUrl);

        $message = 'ثبت دسته بندی با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('categories.create'), $message),
            redirect()->route('categories.create')->with('success', $message)
        );
    }

    public function edit(Request $request, $category)
    {
        $categories = $this->categoryService->getSearchCategories($request);
        $categories = $categories->filter(function($item) use($category){
            return $item->id !== $category->id;
        });
        return view('product::categories.create', compact('category', 'categories'));
    }


    public function update(CategoryRequest $request, $category)
    {
        $imageUrl = $this->categoryService->uploadImage($request->input('image'));

        $category = $this->categoryService->updateCategory($request, $category->id, $imageUrl);

        if ($category) {
            return result(
                Response::postSuccess(route('categories.index'), 'ویرایش دسته بندی با موفقیت انجام شد', ['updated' => true]),
                redirect()->route('categories.index')
            );
        } else {
            return result(
                Response::postError(route('categories.create'), 'خطا در ویرایش دسته بندی'),
                redirect()->route('categories.create')
            );
        }
    }

    public function changeStatus(ProductCategory $category, $status){
        $statusNum = isset($status) && $status == 1 ? 0 : 1;
        $updated = $this->categoryService->updateCategoryStatus($category, $status);

        if ($updated) {
            return result(
                Response::postSuccess(route('categories.status', ['category' => $category->id, 'status' => $statusNum]), 'ویرایش وضعیت دسته بندی با موفقیت انجام شد', ['changed' => $status]),
                redirect()->route('categories.index')
            );
        } else {
            return result(
                Response::postError(route('categories.index'), 'خطا در ویرایش وضعیت دسته بندی'),
                redirect()->route('categories.index')
            );
        }
    }

    public function destroy($category)
    {
        $categoryDelete = $this->categoryService->deleteCategory($category->id);

        if ($categoryDelete) {
            return result(
                Response::postSuccess(route('categories.index'), 'حذف دسته بندی با موفقیت انجام شد'),
                redirect()->route('categories.index')
            );
        } else {
            return result(
                Response::postError(route('categories.index'), 'خطا در حذف دسته بندی'),
                redirect()->route('categories.index')
            );
        }
    }
}