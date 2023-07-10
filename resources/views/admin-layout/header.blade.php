<header class="header-panel col-12 flex-between p-2 bg-white__default">
    <div class="d-flex align-items-center">
{{--        <img src="{{asset('images/logo.png')}}" width="60px" height="60px"/>--}}
        <button class="border-0 rounded-circle bg-dark-blue__shade-3 white__default mx-2 d-none" id="toggle-side">
            <i class="fa-solid fa-list"></i>
        </button>
    </div>
    <div class="d-flex align-items-center">
        <button class="border-0 action-icon flex-center bg-green__default white__default mx-2">
            <i class="fa-solid fa-message"></i>
        </button>
        <button class="border-0 action-icon flex-center bg-red__shade-3 white__default mx-2 position-relative"
        id="notification">
            <i class="fa-solid fa-bell"></i>
            <div class="notification-box position-absolute overflow-hidden bg-white__default">
                    <div class="col-12 notification-header bg-primary__shade-2 d-flex align-items-center justify-content-between p-2">
                        <span class="small-copy-medium white__default">نوتیفیکیشن ها</span>
                        <a href="" class="caption-medium white__default">نمایش همه</a>
                    </div>
                    <div class="notification-body d-flex flex-wrap overflow-auto">
                        @foreach([1,1,1,1,3,3,4,5,6] as $notify)
                        <a href="" class="col-12 d-flex align-items-center border-bottom">
                            <img src="{{asset('images/user.png')}}" width="30px" height="30px" />
                            <div class="d-flex flex-wrap pe-2">
                                <span class="w-100 small-copy-light black__default">حمزه قنبری کاکاوندی</span>
                                <span class="caption-light black__shade-1">{{\Illuminate\Support\Carbon::now()}}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
            </div>
        </button>
        <div class="mx-2 flex-center" id="user-info">
              <span class="small-copy-light">{{auth()->user()->full_name !== '-----' ? auth()->user()->full_name : auth()->user()->mobile}}</span>
            <button class="btn mx-2 flex-center">
                <i class="fa-solid fa-angle-down"></i>
            </button>
        </div>
    </div>
</header>
