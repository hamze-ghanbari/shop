@extends('admin-layout.master')

@section('title', 'ادمین | مدیریت برند ها')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/product/css/app.css') }}">
@endsection

@section('content')
    <section class="col-12 table-box p-2 bg-white__default">
        <section class="col-12 filter-box overflow-auto d-flex flex-wrap">
            <div class="col-12 my-2 d-flex justify-content-center justify-content-sm-between">
                <form method="get" action="{{route('brands.index')}}"
                      class="col-10 col-sm-4 search-box d-flex align-items-center p-2">
                    <button type="submit" class="border-0 action-icon bg-primary__shade-2 white__default">
                        <i class="fa-solid fa-search"></i>
                    </button>
                    <input type="text" name="search" value="{{Request::query('search')}}"
                           placeholder="نام برند را جستجو کنید"
                           class="w-100 px-1 small-copy-light"/>
                </form>
                <x-add-button link="{{route('brands.create')}}" title="افزودن برند جدید"/>
            </div>
        </section>

        <section class="col-12 d-flex align-items-center">

        </section>

        <section class="col-12 table-content">
            @if(count($brands) > 0)
                <table class="col-12 table table-responsive main-table p-2 bg-white__default  m-auto">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>نام برند</td>
                        <td>توضیحات</td>
                        <td>اسلاگ</td>
                        <td>تصویر</td>
                        <td>وضعیت</td>
                        <td>تاریخ ثبت</td>
                        <td><span class="white__default p-2"><i class="fa fa-list"></i></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $brand)
                        <tr class="bg-light">
                            <td class="small-copy-light row-num">{{$loop->iteration}}</td>
                            <td class="small-copy-light">
                                {{$brand->name}}
                            </td>
                            <td class="small-copy-light">
                                {{$brand->description}}
                            </td>
                            <td class="small-copy-light">
                                {{$brand->slug}}
                            </td>
                            <td class="small-copy-light">
                                <img class="rounded-1" src="{{asset($brand->image)}}" alt="{{$brand->name}}" width="80px" height="80px" />
                            </td>
                            <td class="small-copy-light">
                                <a href="{{route('brands.status', ['brand' => $brand->id, 'status' => $brand->status ? '0' : '1'])}}"
                                   class="badge
                                         @if($brand->status) bg-green__default @else bg-red__default @endif  py-2 px-4 change-show-menu"
                                   data-bs-toggle="tooltip" data-bs-placement="right"
                                   title="{{$brand->status ? 'غیرفعال کردن برند' : 'فعال کردن برند'}}">{{$brand->status ? 'فعال' : 'غیرفعال'}}</a>
                            </td>
                            <td class="small-copy-light">
                                {{$brand->created_at}}
                            </td>
                            <td>
                                <div class="overflow-auto d-flex flex-wrap  py-2">
                                    <a href="{{route('brands.edit', ['brand' => $brand->id])}}"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="ویرایش برند"
                                       class="action-icon gg bg-dark-blue__default white__default me-1 mb-2">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="{{route('brands.destroy', ['brand' => $brand->id])}}" id="{{$brand->id}}"
                                       class="action-icon delete-brand bg-red__shade-3 white__default me-1 mb-2"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="حذف برند">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <section
                    class="table-empty w-100 d-flex flex-wrap justify-content-center align-content-center">
                    <i class="fa-solid fa-file-circle-question red__shade-3" style="font-size: 40px"></i>

                    <p class="w-100 text-center small-copy-light black__shade-1">
                        <span class="body-copy-medium">"برند"</span>
                        برای نمایش وجود ندارد
                    </p>
                    <x-add-button link="{{route('brands.create')}}" title="افزودن برند جدید"/>
                </section>
            @endif
        </section>

        {{$brands->links()}}
        {{--            {{$brands->appends(\Illuminate\Support\Facades\Request::query())->render()}}--}}
    </section>

    <a href="{{route('brands.create')}}"
       class="add-mobile-btn rounded-circle bg-primary__shade-2 white__default position-fixed">
        <i class="fa-solid fa-plus"></i>
    </a>
    <x-toast/>
@endsection

@section('script')
    {{--    <script src="{{ asset('modules/product/js/app.js') }}"></script>--}}
    <script src="{{ asset('modules/product/js/brand.js') }}"></script>
@endsection
