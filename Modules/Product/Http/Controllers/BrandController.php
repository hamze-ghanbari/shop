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
        public BrandService $brandService,
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

        if($this->brandService->brandExists($request->input('name'))){
            return result(
                Response::postError(route('brands.create'), 'این برند قبلا ثبت شده است'),
                redirect()->route('brands.create')->with('add-error', 'این برند قبلا ثبت شده است')
            );
        }

        if($request->ajax()){
            $type = 'base64';
            $image = $request->input('image');
        }else{
            $type = 'file';
            $image = $request->file('image');
        }

        $imageAddress = $this->brandService->uploadImage($image, $type);

        if(!$imageAddress){
            $message = 'خطا در آپلود تصویر';
            return result(
                Response::postError(route('brands.create'), $message),
                redirect()->back()->with('add-error', $message)->withInput($request->fields())
            );
        }

        $this->brandService->createBrand($request, $imageAddress);

        $message = 'ثبت برند با موفقیت انجام شد';
        return result(
            Response::postSuccess(route('brands.create'), $message),
            redirect()->route('brands.create')->with('add-success', $message)
        );
    }

    public function edit(Request $request, Brand $brand)
    {
        $brands = $this->brandService->getSearchBrands($request);
        return view('product::brands.create', compact('brand', 'brands'));
    }

    public function update(BrandRequest $request, ImageService $imageService, Brand $brand)
    {
//        if($this->brandService->brandExists($request->input('name'))){
//            return result(
//                Response::postError(route('brands.create'), 'این برند قبلا ثبت شده است'),
//                redirect()->route('brands.create')->with('error', 'این برند قبلا ثبت شده است')
//            );
//        }

        if($request->ajax()){
            $type = 'base64';
            $image = $request->input('image');
        }else{
            $type = 'file';
            $image = $request->file('image');
        }

        $imageAddress = $this->brandService->uploadImage($image, $type);

        if(!$imageAddress){
            $message = 'خطا در آپلود تصویر';
            return result(
                Response::postError(route('brands.create'), $message),
                redirect()->back()->with('add-error', $message)->withInput($request->fields())
            );
        }

        $brand = $this->brandService->updateBrand($request, $brand->id, $imageAddress);

        if ($brand) {
            $message = 'ویرایش برند با موفقیت انجام شد';
            return result(
                Response::postSuccess(route('brands.index'), $message, ['updated' => true]),
                redirect()->route('brands.index')->with('add-success', $message)
            );
        } else {
            $message = 'خطا در ویرایش برند';
            return result(
                Response::postError(route('brands.create'), $message),
                redirect()->route('brands.create')->with('add-error', $message)->withInput($request->fields())
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

    public function destroy(ImageService $imageService, Brand $brand)
    {
        $brandDelete = $this->brandService->deleteBrand($brand->id);

        if ($brandDelete) {
            $imageService->deleteImage($brand->image);

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
