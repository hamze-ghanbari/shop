@extends('admin-layout.master')

@section('title', 'ادمین | مدیریت دسته بندی ها')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/product/css/app.css') }}">
@endsection

@section('content')
    <section class="col-12 table-box p-2 bg-white__default">
        <section class="col-12 filter-box overflow-auto d-flex flex-wrap">
            <div class="col-12 my-2 d-flex justify-content-center justify-content-sm-between">
                <form method="get" action="{{route('categories.index')}}"
                      class="col-10 col-sm-4 search-box d-flex align-items-center p-2">
                    <button type="submit" class="border-0 action-icon bg-primary__shade-2 white__default">
                        <i class="fa-solid fa-search"></i>
                    </button>
                    <input type="text" name="search" value="{{Request::query('search')}}"
                           placeholder="نام دسته بندی را جستجو کنید"
                           class="w-100 px-1 small-copy-light"/>
                </form>
                <x-add-button link="{{route('categories.create')}}" title="افزودن دسته بندی جدید"/>
            </div>
        </section>

        <section class="col-12 d-flex align-items-center">

        </section>

        <section class="col-12 table-content">
            @if(count($categories) > 0)
                <table class="col-12 table table-responsive main-table p-2 bg-white__default  m-auto">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>نام دسته بندی</td>
                        <td>دسته والد</td>
                        <td>توضیحات</td>
                        <td>اسلاگ</td>
                        <td>تصویر</td>
                        <td>وضعیت</td>
                        <td>وضعیت نمایش</td>
                        <td>تاریخ ثبت</td>
                        <td><span class="white__default p-2"><i class="fa fa-list"></i></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="bg-light">
                            <td class="small-copy-light row-num">{{$loop->iteration}}</td>
                            <td class="small-copy-light">
                                {{$category->name}}
                            </td>
                            <td class="small-copy-light">
                                @if(isset($category->parent))
                                    {{$category->parent->name}}
                                @else
                                    -----
                                @endif
                            </td>
                            <td class="small-copy-light">
                                {{$category->description}}
                            </td>
                            <td class="small-copy-light">
                                {{$category->slug}}
                            </td>
                            <td class="small-copy-light">
                                <a href="{{asset($category->image)}}">
                                    <img class="rounded-1" src="{{asset($category->image)}}" alt="{{$category->name}}"
                                         width="80px" height="80px"/>
                                </a>
                            </td>
                            <td class="small-copy-light">
                                {{$category->status}}
                            </td>
                            <td class="small-copy-light">
                                <a href="{{route('categories.status', ['category' => $category->id, 'status' => $category->show_in_menu ? '0' : '1'])}}"
                                   class="badge
                                         @if($category->show_in_menu) bg-green__default @else bg-red__default @endif  py-2 px-4 change-show-menu"
                                   data-bs-toggle="tooltip" data-bs-placement="right"
                                   title="{{$category->show_in_menu ? 'غیرفعال کردن دسته بندی' : 'فعال کردن دسته بندی'}}">{{$category->show_in_menu ? 'فعال' : 'غیرفعال'}}</a>
                            </td>
                            <td class="small-copy-light">
                                {{$category->created_at}}
                            </td>
                            <td>
                                <div class="overflow-auto d-flex flex-wrap  py-2">
                                    <a href="{{route('categories.edit', ['category' => $category->id])}}"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="ویرایش دسته بندی"
                                       class="action-icon gg bg-dark-blue__default white__default me-1 mb-2">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="{{route('categories.destroy', ['category' => $category->id])}}"
                                       id="{{$category->id}}"
                                       class="action-icon delete-category bg-red__shade-3 white__default me-1 mb-2"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="حذف دسته بندی">
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
                        <span class="body-copy-medium">"دسته بندی"</span>
                        برای نمایش وجود ندارد
                    </p>
                    <x-add-button link="{{route('categories.create')}}" title="افزودن دسته بندی جدید"/>
                </section>
            @endif
        </section>

        {{$categories->links()}}
        {{--            {{$categorys->appends(\Illuminate\Support\Facades\Request::query())->render()}}--}}
    </section>

    <a href="{{route('categories.create')}}"
       class="add-mobile-btn rounded-circle bg-primary__shade-2 white__default position-fixed">
        <i class="fa-solid fa-plus"></i>
    </a>
    <x-toast/>
@endsection

@section('script')
    {{--    <script src="{{ asset('modules/product/js/app.js') }}"></script>--}}
    <script src="{{ asset('modules/product/js/category.js') }}"></script>
@endsection
