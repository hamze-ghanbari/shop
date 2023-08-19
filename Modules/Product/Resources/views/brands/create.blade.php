@extends('admin-layout.master')

@section('title')
    @if(empty($brand))
        {{'ادمین | ثبت برند جدید'}}
    @else
        {{'ادمین | ویرایش برند'}}
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/product/css/app.css') }}">
@endsection

@section('content')
    <main class="w-100 h-100 flex-center flex-wrap">
        <x-alert />
        <section class="form-box col-12 col-md-6 p-2 bg-white__default">
            <div class="form-header d-flex align-items-center">
                <div class="col-3">
                    <a href="{{route('brands.index')}}"
                       class="back-btn d-inline-flex align-items-center justify-content-center"><i
                            class="fa-solid fa-arrow-right"></i></a>
                </div>
                <h3 class="body-copy-medium col-6 text-center black__shade-1">
                    @if(empty($brand))
                        {{'ثبت برند جدید'}}
                    @else
                        {{'ویرایش برند'}}
                    @endif</h3>
            </div>
            @php
                $route = isset($brand) ? 'brands.update' : 'brands.store'
            @endphp
            <form action="{{route($route, isset($brand) ? $brand->id : '')}}" method="post" id="brand-form"
                  enctype="multipart/form-data">
                @csrf
                @isset($brand)
                    @method('PUT')
                @endisset
                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">نام برند (انگلیسی)</label>
                    <div class="text-field  col-12 flex-between">
                        <input type="text" name="name" autocomplete="name"
                               autofocus="true" value="{{old('name', $brand->name ?? '')}}"
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
                    <label class="w-100 my-2 caption-light">نام برند (فارسی)</label>
                    <div class="text-field  col-12 flex-between">
                        <input type="text" name="persian_name" autocomplete="persian_name"
                               value="{{old('persian_name', $brand->persian_name ?? '')}}"
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
                    <label class="w-100 my-2 caption-light">توضیحات برند</label>
                    <div class="text-field  col-12 flex-between">
                        <textarea name="description"
                                  class="border-0 col-11 black__shade-1 @error('description') border-red @enderror">{{old('description', $brand->description ?? '')}}</textarea>
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
                        <label class="w-100 my-2 caption-light">تصویر برند</label>
                        <div class="text-field  col-12 flex-between">
                            <input type="file" name="image" id="ImageBrowse"
                                   value="{{old('image', $brand->image ?? '')}}"
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
                        <label class="w-100 my-2 caption-light">وضعیت نمایش</label>
                        <div class="checkbox caption-light">
                            @if(isset($brand->status))
                                <input type="checkbox" value="1" class="switch-checkbox"
                                       @if($brand->status == 1) checked @endif
                                       id="checkbox-input" name="status"/>
                            @else
                                <input type="checkbox" value="1" checked class="switch-checkbox"
                                       id="checkbox-input" name="status"/>
                            @endif
                            <label for="checkbox-input"></label>
                            {{--                        <span class="unchecked red__shade-3 small-copy-strong">غیرفعال</span>--}}
                        </div>
                        <span class="red__shade-3 caption-light w-100" id="error-show-in-menu">
                     @error('status')
                            {{$message}}
                            @enderror
                </span>
                    </div>
                </div>


                <div class="col-12 d-flex justify-content-center">
                    <x-submit-btn content="{{isset($brand) ? 'ویرایش برند' : 'ثبث برند'}}"/>
                </div>
            </form>
        </section>
    </main>
    <x-toast/>
@endsection


@section('script')
    <script src="{{ asset('modules/product/js/brand.js') }}"></script>
@endsection

