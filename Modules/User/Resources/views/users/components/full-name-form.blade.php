<form method="post" action="{{$action}}" id="full-name-form">
    @csrf
    @method('PUT')
    <div class="d-flex flex-wrap">
        <label class="w-100 my-2 caption-light">نام </label>
        <input type="text" name="first_name" autocomplete="first_name" id="first_name"
               maxlength="30" value="{{old('first_name', $user->first_name ?? '')}}"
               class="text-field w-100 black__shade-1 @error('first_name') border-red @enderror"/>
        <span class="red__shade-3 caption-light w-100" id="error-first-name">
                     @error('first_name')
            {{$message}}
            @enderror
                </span>
    </div>
    <div class="d-flex flex-wrap">
        <label class="w-100 my-2 caption-light">نام خانوادگی</label>
        <input type="text" name="last_name" autocomplete="last_name"
               maxlength="30" value="{{old('last_name', $user->last_name ?? '')}}"
               class="text-field w-100 black__shade-1 @error('last_name') border-red @enderror"/>
        <span class="red__shade-3 caption-light w-100" id="error-last-name">
                     @error('last_name')
            {{$message}}
            @enderror
                </span>
    </div>
    <div class="flex-center">
    <x-submit-btn content="ویرایش"/>
{{--        <button type="button"--}}
{{--                class="btn d-sm-flex col-sm-4 col-4 submit-btn bg-red__default white__default small-copy-medium mt-4 ms-2 flex-center"--}}
{{--                data-bs-dismiss="modal">بستن</button>--}}
{{--        <button type="submit"--}}
{{--                class="btn d-sm-flex col-sm-6 col-7 submit-btn bg-green__default white__default small-copy-medium mt-4 flex-center">ویرایش</button>--}}
    </div>
</form>
