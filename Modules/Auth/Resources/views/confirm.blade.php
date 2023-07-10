@extends('auth_module::layouts.master')

@section('content')
    <main class="main-content">
        <section class="login-section">
            <div class="d-flex">
                <a href="{{route('auth.show-otp-form')}}" class="flex-center pointer black__default"><i
                        class="fa-solid fa-arrow-right"></i></a>
                <h1 class="col-11 green__default title-1 flex-center">{{config('app.name')}}</h1>
            </div>
            <form id="confirm-form" action="{{route('auth.confirm', $token)}}" method="post">
                @csrf
                <div class="d-flex flex-wrap">
                    <label class="w-100 py-3 caption-light text-center">کد تایید
                        برای {{ $otp->type === TypeEnum::Email->value ? 'ایمیل' : 'شماره' }} <span
                            class="small-copy-strong">{{$otp->login_id}}</span> {{ $otp->type === TypeEnum::Email->value ? 'ارسال' : 'پیامک' }}
                        شد</label>
                    <div class="w-100 flex-center @error(config('auth_module.inputs.confirm_code')) border-red @enderror">
                        <input type="text" name="{{config('auth_module.inputs.confirm_code')}}" autocomplete="off"
                               maxlength="5" autofocus="true" value="{{old(config('auth_module.inputs.confirm_code'))}}"
                               class="w-100 text-field-box text-field code-field title-2 text-center black__shade-1"/>
                    </div>
                </div>
                <span class="red__shade-3 caption-light" id="error-confirm-code">
                     @error(config('auth_module.inputs.confirm_code'))
                    {{$message}}
                    @enderror
                </span>
                <div class="caption-light flex-center my-2" id="timer">
                    <span class="small-copy-strong px-1 s"></span>
                    <span class="seperator"></span>
                    <span class="small-copy-strong px-1 m"></span>مانده
                    تا
                    دریافت مجدد کد
                </div>
                {{--                <a href="#" id="resend" class="w-100 my-2 primary__shade-1 pointer caption-light flex-center"></a>--}}
                <button type="submit" id="confirm-btn"
                        class="login-btn btn bg-green__default white__default small-copy-strong mt-4 w-100 flex-center">
                    تایید
                </button>
            </form>
        </section>
    </main>
    <x-toast />
@endsection

@section('script')
    <script src="{{ asset('modules/auth/js/app.js') }}"></script>

    <script type="text/javascript">
        let countDownTime = new Date().getTime() + {{$timer}};
        let timer = $('#timer'), secondBox = $(".s"), minuteBox = $(".m");
        let seperator = $('.seperator');
        let minutes = '0' + Math.floor(((countDownTime - new Date().getTime()) % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor(((countDownTime - new Date().getTime()) % (1000 * 60)) / 1000);
        if (countDownTime - new Date().getTime() > 0) {
            seperator.html(':');
            minuteBox.html(minutes);
            secondBox.html(seconds);
        }
        let time = setInterval(function () {
            let now = new Date().getTime();
            let distance = countDownTime - now;
            minutes = '0' + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((distance % (1000 * 60)) / 1000);
            seconds = seconds < 10 ? '0' + seconds : seconds;
            secondBox.html(seconds);
            minuteBox.html(minutes);
            if (distance < 0) {
                clearInterval(time);
                timer.empty();
                timer.after(`<a href="{{route('auth.otp.resend', $token)}}" class="w-100 my-2 primary__shade-1 pointer caption-light flex-center">دریافت مجدد کد تایید</a>`);
                timer.remove();
            }
        }, 1000);
    </script>
@endsection
