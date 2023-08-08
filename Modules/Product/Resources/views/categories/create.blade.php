@extends('admin-layout.master')

@section('title')
    @if(empty($category))
        {{'ادمین | ثبت دسته بندی جدید'}}
    @else
        {{'ادمین | ویرایش دسته بندی'}}
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/product/css/app.css') }}">
@endsection

@section('content')
    <main class="w-100 h-100 flex-center flex-wrap">
        <section class="form-box col-12 col-md-6 p-2 bg-white__default">
            <div class="form-header d-flex align-items-center">
                <div class="col-3">
                    <a href="{{route('categories.index')}}"
                       class="back-btn d-inline-flex align-items-center justify-content-center"><i
                            class="fa-solid fa-arrow-right"></i></a>
                </div>
                <h3 class="body-copy-medium col-6 text-center black__shade-1">
                    @if(empty($category))
                        {{'ثبت دسته بندی جدید'}}
                    @else
                        {{'ویرایش دسته بندی'}}
                    @endif</h3>
            </div>
            @php
                $route = isset($category) ? 'categories.update' : 'categories.store'
            @endphp
            <form action="{{route($route, isset($category) ? $category->id : '')}}" method="post" id="category-form"
                  enctype="multipart/form-data">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset
                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">نام دسته بندی (انگلیسی)</label>
                    <div class="text-field  col-12 flex-between">
                        <input type="text" name="name" autocomplete="name"
                               autofocus="true" value="{{old('name', $category->name ?? '')}}"
                               class="border-0 col-11 black__shade-1 @error('name') border-red @enderror"/>
                        <i></i>
                    </div>
                    <span class="red__shade-3 caption-light w-100" id="error-name">
                     @error('name')
                        {{$message}}
                        @enderror
                </span>
                </div>

                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">نام دسته بندی (فارسی)</label>
                    <div class="text-field  col-12 flex-between">
                        <input type="text" name="persian_name" autocomplete="persian_name"
                               value="{{old('persian_name', $category->persian_name ?? '')}}"
                               class="border-0 col-11 black__shade-1 @error('persian_name') border-red @enderror"/>
                        <i></i>
                    </div>
                    <span class="red__shade-3 caption-light w-100" id="error-persian-name">
                     @error('persian_name')
                        {{$message}}
                        @enderror
                </span>
                </div>

                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">توضیحات دسته بندی</label>
                    <div class="text-field  col-12 flex-between">
                        <textarea name="description"
                                  class="border-0 col-11 black__shade-1 @error('description') border-red @enderror">{{old('description', $category->description ?? '')}}</textarea>
                        <i></i>
                    </div>
                    <span class="red__shade-3 caption-light w-100" id="error-description">
                     @error('description')
                        {{$message}}
                        @enderror
                </span>
                </div>

                <div class="flex-between">
                    <div class="d-flex flex-wrap col-6 ms-1">
                        <label class="w-100 my-2 caption-light">تصویر دسته بندی</label>
                        <div class="text-field  col-12 flex-between">
                            <input type="file" name="image" id="ImageBrowse"
                                   value="{{old('image', $category->image ?? '')}}"
                                   class="border-0 col-11 black__shade-1 @error('image') border-red @enderror"/>
                            <i></i>
                        </div>
                        <span class="red__shade-3 caption-light w-100" id="error-image">
                     @error('image')
                            {{$message}}
                            @enderror
                </span>
                    </div>
                    <div class="d-flex flex-wrap col-6">
                        <label class="w-100 my-2 caption-light">دسته بندی والد</label>
                        <div class="text-field  col-12 flex-between">
                            <select class="border-0 col-11 black__shade-1 @error('parent_id') border-red @enderror"
                                    name="parent_id">
                                <option value="">هیچکدام</option>
                                @if(isset($category->id))
                                    @foreach ($categories as $cate)
                                        <option value="{{old('parent_id', $cate->id)}}"
                                                @if ($cate->id == $category->parent_id) selected @endif>{{ $cate->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($categories as $cate)
                                        <option value="{{old('parent_id', $cate->id)}}">{{ $cate->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                            <i></i>
                        <span class="red__shade-3 caption-light w-100" id="error-parent-id">
                     @error('parent_id')
                            {{$message}}
                            @enderror
                </span>
                    </div>
                </div>

                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">وضعیت نمایش</label>
                    <div class="checkbox caption-light">
                        @if(isset($category->show_in_menu))
                            <input type="checkbox" value="1" class="switch-checkbox"
                                   @if($category->show_in_menu == 1) checked @endif
                                   id="checkbox-input" name="show_in_menu"/>
                        @else
                            <input type="checkbox" value="1" checked class="switch-checkbox"
                                   id="checkbox-input" name="show_in_menu"/>
                        @endif
                        <label for="checkbox-input"></label>
                        {{--                        <span class="unchecked red__shade-3 small-copy-strong">غیرفعال</span>--}}
                    </div>
                    <span class="red__shade-3 caption-light w-100" id="error-show-in-menu">
                     @error('show_in_menu')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <x-submit-btn content="{{isset($category) ? 'ویرایش دسته بندی' : 'ثبث دسته بندی'}}"/>
                </div>
            </form>
        </section>
    </main>
    <x-toast/>
@endsection


@section('script')
    {{--    <script src="{{ asset('modules/product/js/app.js') }}"></script>--}}
    <script src="{{ asset('modules/product/js/category.js') }}"></script>
@endsection

