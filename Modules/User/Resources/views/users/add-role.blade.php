@extends('admin-layout.master')
@section('title')
    {{'ادمین | افزودن نقش به کاربر'}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
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
            <form action="{{route('users.role.add', ['user' => $user->id])}}" method="post" id="user-role-form" class="col-12 d-flex flex-wrap align-items-center justify-content-start permission-box">
                @csrf
                @foreach($roles as $role)
                    <div class="col-md-3 col-6 d-flex flex-wrap justify-content-center mb-3">
                            <span class="w-100 text-center mb-1 caption-light">
                            {{$role->persian_name}}
                            </span>
                        <div class="checkbox caption-light">
                            <input type="checkbox" value="{{$role->id}}"
                                   @if(in_array($role->id, $userRoleId)) checked @endif
                                   class="switch-checkbox" id="{{$role->id}}"
                                   name="roles[]"/>
                            <label for="{{$role->id}}"></label>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 flex-center">
                    <x-submit-btn content="ثبت نقش کاربری" />
                </div>
            </form>
        </section>
    </main>

<x-toast />
@endsection


@section('script')
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/user.js') }}"></script>
@endsection

