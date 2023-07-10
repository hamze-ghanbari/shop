@extends('admin-layout.master')
@section('title')
    {{' ادمین | افزودن سطوح دسترسی به کاربر'}}
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/user/css/user.css') }}">
@endsection

@section('content')

    <main class="w-100 h-100 flex-center flex-wrap">
        <section class="form-box col-12 col-md-7 d-flex flex-wrap p-2 bg-white__default">
            <div class="col-12 d-flex align-items-center mb-3 py-3 border-bottom">
                <div class="checkbox caption-light">
                    <input type="checkbox" class="switch-checkbox" id="select-all"/>
                    <label for="select-all"></label>
                </div>
                <span class="caption-light mx-1">انتخاب همه</span>
            </div>
            <form action="{{route('users.permission.add', ['user' => $user->id])}}" method="post" id="permission-form" class="col-12 d-flex flex-wrap align-items-center justify-content-start permission-box">
                @csrf
                @foreach($permissions as $permission)
                    <div class="col-md-3 col-6 d-flex flex-wrap justify-content-center mb-3">
                            <span class="w-100 text-center mb-1 caption-light">
                            {{$permission->persian_name}}
                            </span>
                        <div class="checkbox caption-light">
                            <input type="checkbox" value="{{$permission->id}}"
                                   @if(in_array($permission->id, $rolePermissionsId)) checked @endif
                                   class="switch-checkbox" id="{{$permission->id}}"
                                   name="permissions[]"/>
                            <label for="{{$permission->id}}"></label>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 flex-center">
                    <x-submit-btn content="ثبت سطوح دسترسی" />
                </div>
            </form>
        </section>
    </main>


    <x-toast/>
@endsection


@section('script')
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/user.js') }}"></script>
@endsection

