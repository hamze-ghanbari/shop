<form method="post" action="{{$action}}" id="birth-date-form">
    @csrf
    @method('PUT')
    <div class="col-12 flex-between">
        <div class="d-flex flex-wrap col-4">
            <label class="w-100 my-2 caption-light">سال </label>
            <select class="text-field bg-white__default pointer select-birth-date" id="year">
                @foreach($years as $year)
                <option class="title-4" value="{{$year}}"
                @if($userYear == $year) selected  @endif>{{$year}}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex flex-wrap col-4">
            <label class="w-100 my-2 caption-light">ماه </label>
            <select class="text-field bg-white__default pointer select-birth-date" id="month">
                @foreach($months as $month)
                    <option class="title-4" value="{{$loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration}}"
                            @if($userMonth == $loop->iteration) selected  @endif>{{$month}}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex flex-wrap col-4">
            <label class="w-100 my-2 caption-light">روز </label>
            <select class="text-field bg-white__default pointer select-birth-date" id="day">
                @foreach($days as $day)
                    <option class="title-4" value="{{$day < 10 ? '0'.$day : $day}}"
                            @if($userDay == $day) selected  @endif>{{$day}}</option>
                @endforeach
            </select>
        </div>
    </div>
        <span class="red__shade-3 caption-light w-100" id="error-birth-date">
                     @error('birth_date')
            {{$message}}
            @enderror
                </span>
    {{--    <div class="d-flex flex-wrap">--}}
    {{--        <label class="w-100 my-2 caption-light">نام </label>--}}
    {{--        <input type="text" readonly  id="birth-date-view"--}}
    {{--               class="text-field w-100 black__shade-1 @error('birth_date') border-red @enderror"/>--}}
    {{--        <input type="text" name="birth_date" class="d-none" id="birth-date"/>--}}
    {{--        <span class="red__shade-3 caption-light w-100" id="error-birth-date">--}}
    {{--                     @error('birth_date')--}}
    {{--            {{$message}}--}}
    {{--            @enderror--}}
    {{--                </span>--}}
    {{--    </div>--}}
    <div class="flex-center">
        <x-submit-btn content="ویرایش"/>
    </div>


