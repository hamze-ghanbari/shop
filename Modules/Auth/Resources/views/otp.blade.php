@extends('auth_module::layouts.master')
@section('content')
    <main class="main-content">
        <section class="login-section">
            <h1 class="green__default title-1 flex-center">{{config('app.name')}}</h1>
            <form id="otp-form" name="otp-form" action="{{route('auth.otp')}}" method="post">
                @csrf
                <div class="d-flex flex-wrap">

                    <label class="w-100 py-3 caption-light">لطفا شماره موبایل یا ایمیل خود را وارد نمایید</label>
                    <div
                        @class(['w-100 flex-between text-field-box','border-red' => $errors->has(config('auth_module.inputs.user_name'))]) id="field-box">
                        <input type="text" id="user-name"  name="{{config('auth_module.inputs.user_name')}}" autocomplete="off" autofocus
                               class="col-11 text-field small-copy-medium black__shade-1" value="{{old(config('auth_module.inputs.user_name'))}}"/>
                        <span class="pointer flex-center d-none" id="empty-icon"><i
                                class="fa-solid fa-close red__default"></i></span>
                        <span class="flex-center d-none" id="confirm-icon"><i
                                class="fa-solid fa-check green__default"></i></span>
                    </div>
                </div>
                <span class="red__shade-3 caption-light error-message"  id="error-user-name">
                @error(config('auth_module.inputs.user_name'))
                    {{$message}}
                    @enderror
                </span>
                <button type="submit"
                        class="login-btn btn bg-green__default white__default small-copy-medium mt-4 w-100 flex-center">
                    ورود
                </button>
            </form>
            <span class="caption-light w-100 flex-center flex-wrap py-2">
                ورود شما به معنای پذیرش <a href="" class="px-1 caption-light">شرایط دیجی‌کالا</a> و <a href=""
                                                                                                       class="px-1 caption-light"> قوانین حریم‌خصوصی</a> است
            </span>
        </section>
    </main>
    <x-toast />
@endsection

@section('script')
    {{--    <script src="{{asset('js/public.js')}}"></script>--}}
    <script src="{{ asset('modules/auth/js/app.js') }}"></script>
@endsection
