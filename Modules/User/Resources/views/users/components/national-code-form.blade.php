<form method="post" action="{{$action}}" id="national-code-form">
    @csrf
    @method('PUT')
    <div class="d-flex flex-wrap">
        <label class="w-100 my-2 caption-light">کد ملی</label>
        <input type="text" name="national_code" autocomplete="national_code"
               maxlength="30" value="{{old('national_code', $user->national_code ?? '')}}"
               class="text-field w-100 black__shade-1 @error('national_code') border-red @enderror"/>
        <span class="red__shade-3 caption-light w-100" id="error-national-code">
                     @error('national_code')
            {{$message}}
            @enderror
                </span>
    </div>
    <div class="flex-center">
        <x-submit-btn content="ویرایش"/>
    </div>
</form>
