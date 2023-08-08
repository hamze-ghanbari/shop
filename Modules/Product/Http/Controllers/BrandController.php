<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Product\Entities\Brand;
use Modules\Product\Http\Requests\BrandRequest;
use Modules\Product\Http\Services\BrandService;

class BrandController extends Controller
{

    public function __construct(
        public BrandService $brandService
    )
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->getSearchBrands($request);
        return view('product::brands.index', compact('brands'));
    }

    public function create(Request $request)
    {
        $brands = $this->brandService->getSearchBrands($request);
        return view('product::brands.create', compact('brands'));
    }

    public function store(BrandRequest $request, ImageService $imageService)
    {
        $imageAddress = $this->brandService->uploadImage($imageService, $request->input('image'));

        if(!$imageAddress){
            return Response::postSuccess(route('brands.create'), 'خطا در آپلود تصویر');
        }

        $this->brandService->createBrand($request, $imageAddress);

        $message = 'ثبت برند با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('brands.create'), $message),
            redirect()->route('brands.create')->with('success', $message)
        );
    }

    public function edit(Request $request, Brand $brand)
    {
        $brands = $this->brandService->getSearchBrands($request);
        return view('product::brands.create', compact('brand', 'brands'));
    }


    public function update(BrandRequest $request, ImageService $imageService, Brand $brand)
    {
        $imageAddress = $this->brandService->uploadImage($imageService, $request->input('image'));

        if(!$imageAddress){
            return Response::postSuccess(route('brands.index'), 'خطا در آپلود تصویر');
        }

        $brand = $this->brandService->updateBrand($request, $brand->id, $imageAddress);

        if ($brand) {
            return result(
                Response::postSuccess(route('brands.index'), 'ویرایش برند با موفقیت انجام شد', ['updated' => true]),
                redirect()->route('brands.index')
            );
        } else {
            return result(
                Response::postError(route('brands.create'), 'خطا در ویرایش برند'),
                redirect()->route('brands.create')
            );
        }
    }

    public function changeStatus(Brand $brand, $status)
    {
        $statusNum = isset($status) && $status == 1 ? 0 : 1;
        $updated = $this->brandService->updateBrandStatus($brand, $status);

        if ($updated) {
            return result(
                Response::postSuccess(route('brands.status', ['brand' => $brand->id, 'status' => $statusNum]), 'ویرایش وضعیت برند با موفقیت انجام شد', ['changed' => $status]),
                redirect()->route('brands.index')
            );
        } else {
            return result(
                Response::postError(route('brands.index'), 'خطا در ویرایش وضعیت برند'),
                redirect()->route('brands.index')
            );
        }
    }

    public function destroy(Brand $brand)
    {
        $brandDelete = $this->brandService->deleteBrand($brand->id);

        if ($brandDelete) {
            $this->brandService->deleteBrandImage($brand->image);

            return result(
                Response::postSuccess(route('brands.index'), 'حذف برند با موفقیت انجام شد'),
                redirect()->route('brands.index')
            );
        } else {
            return result(
                Response::postError(route('brands.index'), 'خطا در حذف برند'),
                redirect()->route('brands.index')
            );
        }
    }
}
