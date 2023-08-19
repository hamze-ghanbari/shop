<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Closure;
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
        if ($this->categoryService->categoryExists($request->input('name'))) {
            return result(
                Response::postError(route('categories.create'), 'این دسته بندی قبلا ثبت شده است'),
                redirect()->route('categories.create')->with('add-error', 'این دسته بندی قبلا ثبت شده است')->withInput($request->fields())
            );
        }

        if($request->ajax()){
            $type = 'base64';
            $image = $request->input('image');
        }else{
            $type = 'file';
            $image = $request->file('image');
        }

        $imageAddress = $this->categoryService->uploadImage($image, $type);

        if (!$imageAddress) {
            $message = 'خطا در آپلود تصویر';
            return result(
                Response::postError(route('categories.create'), $message),
                redirect()->back()->with('add-error', $message)->withInput($request->fields())
            );
        }

        $this->categoryService->createCategory($request, $imageAddress);

        $message = 'ثبت دسته بندی با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('categories.create'), $message),
            redirect()->route('categories.create')->with('add-success', $message)
        );
    }

    public function edit(Request $request, $category)
    {
        $categories = $this->categoryService->getSearchCategories($request);
        $categories = $categories->filter(function ($item) use ($category) {
            return $item->id !== $category->id;
        });
        return view('product::categories.create', compact('category', 'categories'));
    }


    public function update(CategoryRequest $request, ImageService $imageService, $category)
    {
//        if ($this->categoryService->categoryExists($request->input('name'))) {
//            return result(
//                Response::postError(route('categories.create'), 'این دسته بندی قبلا ثبت شده است'),
//                redirect()->route('categories.create')->with('error', 'این دسته بندی قبلا ثبت شده است')
//            );
//        }

        if($request->ajax()){
            $type = 'base64';
            $image = $request->input('image');
        }else{
            $type = 'file';
            $image = $request->file('image');
        }

        $imageAddress = $this->categoryService->uploadImage($image, $type);

        if (!$imageAddress) {
            $message = 'خطا در آپلود تصویر';
            return result(
                Response::postError(route('categories.create'), $message),
                redirect()->back()->with('add-error', $message)->withInput($request->fields())
            );
        }

        $category = $this->categoryService->updateCategory($request, $category->id, $imageAddress);

        if ($category) {
            $message = 'ویرایش دسته بندی با موفقیت انجام شد';
            return result(
                Response::postSuccess(route('categories.index'), $message, ['updated' => true]),
                redirect()->route('categories.index')->with('add-success', $message)
            );
        } else {
            $message = 'خطا در ویرایش دسته بندی';
            return result(
                Response::postError(route('categories.create'), $message),
                redirect()->route('categories.create')->with('add-error', $message)->withInput($request->fields())
            );
        }
    }

    public function changeStatus(ProductCategory $category, $status)
    {
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

    public function destroy(ImageService $imageService, ProductCategory $category)
    {
        $categoryDelete = $this->categoryService->deleteCategory($category->id);

        if ($categoryDelete) {
            $imageService->deleteImage($category->image);

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
