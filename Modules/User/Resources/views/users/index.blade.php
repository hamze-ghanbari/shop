@extends('admin-layout.master')

@section('title', 'ادمین | مدیریت کاربران')
@section('style')

    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/user/css/user.css') }}">

    <link rel="stylesheet" href="{{ asset('date-picker/persian-datepicker.min.css') }}">
@endsection

@section('content')
        <section class="col-12 table-box p-2 bg-white__default">
            <section class="col-12 filter-box overflow-auto d-flex flex-wrap">
                <div class="col-12 my-2 d-flex justify-content-center justify-content-sm-between">
                    <form method="get" action="{{route('users.index')}}"
                          class="col-10 col-sm-4 search-box d-flex align-items-center p-2">
                        <button type="submit" class="border-0 action-icon bg-primary__shade-2 white__default">
                            <i class="fa-solid fa-search"></i>
                        </button>
                        <input type="text" name="search" value="{{Request::query('search')}}"
                               placeholder="نام کاربر، شماره همراه یا ایمیل را جستجو کنید"
                               class="w-100 px-1 small-copy-light"/>
                    </form>
                    <x-add-button link="{{route('users.create')}}" title="افزودن کاربر جدید"/>
                </div>
                <div class="col-12 my-2 d-flex justify-content-center justify-content-sm-between">
                    <form method="get" action="{{route('users.index')}}"
                          class="col-10 col-sm-4 search-box d-flex align-items-center p-2">
                        <button type="submit" class="border-0 action-icon bg-primary__shade-2 white__default">
                            <i class="fa-solid fa-calendar"></i>
                        </button>
                        <input type="text" readonly class="border-0 w-100 small-copy-light" id="filter-date-view"/>
                        <input type="text" name="filter-date" class="d-none" id="filter-date"/>
                    </form>
                </div>

            </section>

            <section class="col-12 d-flex align-items-center">

            </section>

            <section class="col-12 table-content">
                @if(count($users) > 0)
                    <table class="col-12 table table-responsive main-table p-2 bg-white__default  m-auto">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>نام کاربر</td>
                            <td>ایمیل</td>
                            <td>شماره همراه</td>
                            <td>تاریخ تولد</td>
                            <td>تاریخ ثبت</td>
                            <td><span class="white__default p-2"><i class="fa fa-list"></i></span></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="bg-light">
                                <td class="small-copy-light row-num">{{$loop->iteration}}</td>
                                <td class="small-copy-light">
                                    {{$user->full_name}}
                                </td>
                                <td class="small-copy-light">
                                    @if(isset($user->email))
                                        {{$user->email}}
                                    @else
                                        -----
                                    @endif
                                </td>
                                <td class="small-copy-light">
                                    @if(isset($user->mobile))
                                        {{$user->mobile}}
                                    @else
                                        -----
                                    @endif
                                </td>
                                <td class="small-copy-light">
                                    @if(isset($user->birth_date))
                                        {{$user->birth_date}}
                                    @else
                                        -----
                                    @endif
                                </td>
                                <td class="small-copy-light">
                                    {{$user->created_at}}
                                </td>
                                <td>
                                    <div class="overflow-auto d-flex flex-wrap  py-2">
                                        @if(isset($user->mobile) && isset($user->mobile_verified_at))
                                            <a href="{{route('roles.permission.show', ['role' => $user->id])}}"
                                               data-bs-toggle="tooltip" data-bs-placement="right" title="ارسال پیامک"
                                               class="action-icon  rounded-circle flex-center bg-orange__shade-3 white__default me-1 mb-2">
                                                <i class="fa-solid fa-sms"></i>
                                            </a>
                                        @endif
                                        @if(isset($user->email) && isset($user->email_verified_at))
                                            <a href="{{route('roles.permission.show', ['role' => $user->id])}}"
                                               data-bs-toggle="tooltip" data-bs-placement="right" title="ارسال ایمیل"
                                               class="action-icon  rounded-circle flex-center bg-green__default white__default me-1  mb-2">
                                                <i class="fa-solid fa-mail-bulk"></i>
                                            </a>
                                        @endif
                                        <a href="{{route('users.role.show', ['user' => $user->id])}}"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="افزودن نقش کاربری"
                                           class="action-icon rounded-circle flex-center bg-primary__shade-1 white__default me-1  mb-2">
                                            <i class="fa-solid fa-user-cog"></i>
                                        </a>
                                        <a href="{{route('users.permission.show', ['user' => $user->id])}}"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="افزودن سطوح دسترسی"
                                           class="action-icon rounded-circle flex-center bg-dark-blue__shade-1 white__default me-1  mb-2">
                                            <i class="fa-solid fa-user-check"></i>
                                        </a>
                                        <a href="{{route('users.profile', ['user' => $user->id])}}"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="نمایش جزئیات"
                                           class="action-icon  rounded-circle flex-center bg-primary__shade-2 white__default me-1 mb-2">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                        <a href="{{route('users.download', ['user' => $user->id])}}"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="دانلود اطلاعات"
                                           class="action-icon  rounded-circle flex-center bg-green__shade-1 white__default me-1 mb-2">
                                            <i class="fa-solid fa-file-excel"></i>
                                        </a>
                                        <a href="{{route('roles.edit', ['role' => $user->id])}}"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="ویرایش کاربر"
                                           class="action-icon gg bg-dark-blue__default white__default me-1 mb-2">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="{{route('users.destroy', ['user' => $user->id])}}" id="{{$user->id}}"
                                           class="action-icon delete-user bg-red__shade-3 white__default me-1 mb-2"
                                           data-bs-toggle="tooltip" data-bs-placement="right" title="حذف کاربر">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <section
                        class="table-empty w-100 d-flex flex-wrap justify-content-center align-content-center">
                        <i class="fa-solid fa-file-circle-question red__shade-3" style="font-size: 40px"></i>

                        <p class="w-100 text-center small-copy-light black__shade-1">
                            <span class="body-copy-medium">"کاربر"</span>
                            برای نمایش وجود ندارد
                        </p>
                        <x-add-button link="{{route('users.create')}}" title="افزودن کاربر جدید"/>
                    </section>
                @endif
            </section>

            {{$users->links()}}
{{--            {{$users->appends(\Illuminate\Support\Facades\Request::query())->render()}}--}}
        </section>

        <a href="{{route('users.create')}}"
           class="add-mobile-btn rounded-circle bg-primary__shade-2 white__default position-fixed">
            <i class="fa-solid fa-plus"></i>
        </a>
    <x-toast/>
@endsection

@section('script')
    <script src="{{asset('date-picker/persian-date.min.js')}}"></script>
    <script src="{{asset('date-picker/persian-datepicker.min.js')}}"></script>
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/user.js') }}"></script>
@endsection
