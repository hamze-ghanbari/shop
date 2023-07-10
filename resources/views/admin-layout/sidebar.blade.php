<aside class="side-panel d-flex flex-wrap align-content-start overflow-hidden bg-white__default mx-2">
    <div class="header-side w-100 flex-center bg-primary__shade-2 white__default">
        <h1 class="title-4">digikala</h1>
    </div>
    <div class="body-side col-12 overflow-auto">

        <div class="d-flex flex-wrap col-12 side-item overflow-hidden p-2">
            @foreach($items as $item)
                <div class="col-12 flex-between flex-wrap menu py-2">
                    <div class="d-flex align-items-center">
                    <span class="action-icon bg-dark-blue__shade-3 white__default">
                        <i class="fa-solid {{$item['icon']}}"></i>
                    </span>
                        @if(isset($item['childs']))
                            <span class="w-100 px-2 small-copy-light black__default pointer">{{$item['name']}}</span>
                        @else
                            <a href="{{route($item['route'])}}" class="w-100 px-2 small-copy-light black__default">{{$item['name']}}</a>
                        @endif
                    </div>
                    @if(isset($item['childs']))
                        <span class="flex-center">
                    <i class="fa-solid fa-angle-down"></i>
                </span>
                        <div class="col-12 sub-menu bg-white__shade-1 mt-2 d-flex flex-wrap">
                            @foreach($item['childs'] as $child)
                                <a href="{{route($child['route'])}}" class="w-100 small-copy-light black__default py-1">{{$child['name']}}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            {{--            <div class="col-12 flex-between flex-wrap menu">--}}
            {{--                <div class="d-flex align-items-center">--}}
            {{--                    <span class="action-icon bg-dark-blue__shade-3 white__default">--}}
            {{--                        <i class="fa-solid fa-user-cog"></i>--}}
            {{--                    </span>--}}
            {{--                    <a href="{{route('roles.index')}}" class="w-100 px-2 small-copy-light black__default">مدیریت نقش--}}
            {{--                        ها</a>--}}
            {{--                </div>--}}

            {{--            </div>--}}

        </div>

    </div>
</aside>

