@extends('admin-layout.master')

@section('title')
    @if(empty($role))
        {{'ادمین | ثبت نقش جدید'}}
    @else
        {{'ادمین | ویرایش نقش'}}
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
@endsection

@section('content')
    <main class="w-100 h-100 flex-center flex-wrap">
            <x-alert />
        <section class="form-box col-12 col-md-6 p-2 bg-white__default">
            <div class="form-header d-flex align-items-center">
                <div class="col-3">
                    <a href="{{route('roles.index')}}"
                       class="back-btn d-inline-flex align-items-center justify-content-center"><i
                            class="fa-solid fa-arrow-right"></i></a>
                </div>
                <h3 class="body-copy-medium col-6 text-center black__shade-1">
                    @if(empty($role))
                        {{'ثبت نقش جدید'}}
                    @else
                        {{'ویرایش نقش'}}
                    @endif</h3>
            </div>
            @php
                $route = isset($role) ? 'roles.update' : 'roles.store'
            @endphp
            <form action="{{route($route, isset($role) ? $role->id : '')}}" method="post" id="role-form">
                @csrf
                @isset($role)
                    @method('PUT')
                @endisset
                <div class="d-flex flex-wrap">
                    <label class="w-100 my-2 caption-light">نام نقش (انگلیسی)</label>
                    <div class="text-field  col-12 flex-between">
                        <input type="text" name="name" autocomplete="name"
                               maxlength="30" autofocus="true" value="{{old('name', $role->name ?? '')}}"
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
                    <label class="w-100 my-2 caption-light">نام نقش (فارسی)</label>
                    <div class="text-field  col-12 flex-between">
{{--                    <textarea name="description"--}}
{{--                              class="border-0 col-11 black__shade-1 @error('description') border-red @enderror">{{old('description', $role->description ?? '')}}</textarea>--}}
                        <input type="text" name="persian_name" autocomplete="persian_name"
                               maxlength="30" autofocus="true" value="{{old('persian_name', $role->persian_name ?? '')}}"
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
                    <label class="w-100 my-2 caption-light">وضعیت نقش</label>
                    <div class="checkbox caption-light">
                        {{--                        <span class="checked green__default small-copy-strong">فعال</span>--}}
                        @if(isset($role->status))
                            <input type="checkbox" value="1" class="switch-checkbox" @if($role->status == 1) checked
                                   @endif id="checkbox-input"
                                   name="status"/>
                        @else
                            <input type="checkbox" value="1" checked class="switch-checkbox" id="checkbox-input"
                                   name="status"/>
                        @endif
                        <label for="checkbox-input"></label>
                        {{--                        <span class="unchecked red__shade-3 small-copy-strong">غیرفعال</span>--}}
                    </div>
                </div>
                <span class="red__shade-3 caption-light w-100" id="error-status">
                     @error('status')
                    {{$message}}
                    @enderror
                </span>
                <div class="col-12 d-flex justify-content-center">
                    <x-submit-btn content="{{isset($role) ? 'ویرایش نقش' : 'ثبث نقش'}}"/>
                </div>
            </form>
        </section>
    </main>
    <x-toast/>
    <x-confirm-alert/>
@endsection


@section('script')
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/role.js') }}"></script>
@endsection

