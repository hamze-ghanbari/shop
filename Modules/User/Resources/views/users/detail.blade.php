@extends('admin-layout.master')

@section('title', 'ادمین | ویرایش کاربر')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/user/css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('date-picker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <main class="w-100 h-100 flex-center flex-wrap">
        <section class="box-profile border d-flex flex-wrap col-12 col-md-8 px-2 bg-white__default">
            <section class="col-12 d-flex flex-wrap flex-md-nowrap border-bottom">
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 ps-md-2 py-2 border-left">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3">نام و نام خانوادگی</span>
                        @if($user->first_name || $user->last_name)
                            <button class="btn pointer action-icon edit-full-name bg-dark-blue__shade-3 white__default"
                                    data-bs-toggle="modal" data-bs-target="#fullName">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                        @else
                            <button class="btn pointer action-icon add-full-name bg-green__default white__default"
                                    data-bs-toggle="modal" data-bs-target="#fullName">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        @endif
                            @php
                                $data = ['user' => $user, 'action' => route('users.name.update', $user->id)];
                            @endphp
                        <x-edit-modal  target="fullName"
                                      formBody="user_module::users.components.full-name-form"
                                     :$data />
                    </div>
                    <span class="d-block small-copy-medium full-name">{{$user->full_name}}</span>
                </div>
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 pe-md-2 py-2">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3">کد ملی</span>
                        @if($user->national_code)
                            <button class="btn pointer action-icon add-national-code bg-dark-blue__shade-3 white__default"
                                    data-bs-toggle="modal" data-bs-target="#nationalCode">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        @else
                            <button class="btn pointer action-icon add-national-code bg-green__default white__default"
                                    data-bs-toggle="modal" data-bs-target="#nationalCode">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @endif
                        @php
                            $data = ['user' => $user, 'action' => route('users.national-code.update', $user->id)];
                        @endphp
                        <x-edit-modal  target="nationalCode"
                                       formBody="user_module::users.components.national-code-form"
                                       :$data />
                    </div>
                    <span class="d-block small-copy-medium national-code">{{$user->national_code ?? '-----'}}</span>
                </div>
            </section>
            <section class="col-12 d-flex flex-wrap flex-md-nowrap border-bottom">
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 ps-md-2 py-2 border-left">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3">شماره موبایل</span>
                        @if($user->mobile)
                            <span class="pointer action-icon add-mobile bg-dark-blue__shade-3 white__default">
                            <i class="fa-solid fa-edit"></i>
                        </span>
                        @else
                            <span class="pointer action-icon add-mobile bg-green__default white__default">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        @endif
                    </div>
                    <span class="d-block small-copy-medium">{{$user->mobile ?? '-----'}}</span>
                </div>
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 pe-md-2 py-2">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3">ایمیل</span>
                        @if($user->email)
                            <span class="pointer action-icon add-email bg-dark-blue__shade-3 white__default">
                            <i class="fa-solid fa-edit"></i>
                        </span>
                        @else
                            <span class="pointer action-icon add-email bg-green__default white__default">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        @endif
                    </div>
                    <span class="d-block small-copy-medium">{{$user->email ?? '-----'}}</span>
                </div>
            </section>
            <section class="col-12 d-flex flex-wrap flex-md-nowrap">
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 ps-md-2 py-2 border-left">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3">تاریخ ثبت نام </span>
                    </div>
                    <span class="d-block small-copy-medium">{{$user->created_at}}</span>
                </div>
                <div class="info-box d-flex flex-wrap bg-white__default col-12 col-md-6 pe-md-2 py-2">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <span class="small-copy-light light__shade-3"
                                >تاریخ تولد</span>
                        @if($user->birth_date)
                            <button class="btn pointer action-icon add-birth-date bg-dark-blue__shade-3 white__default"
                                    data-bs-toggle="modal" data-bs-target="#birthDate">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        @else
                            <button class="btn pointer action-icon add-birth-date bg-green__default white__default"
                                    data-bs-toggle="modal" data-bs-target="#birthDate">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @endif
                        @php
                            $data = ['user' => $user, 'action' => route('users.birth-date.update', $user->id),
                                     'years' => $years, 'months' => $months, 'days' => $days,
                                     'userYear' => $userYear, 'userMonth' => $userMonth, 'userDay' => $userDay];
                        @endphp
                        <x-edit-modal  target="birthDate"
                                       formBody="user_module::users.components.birth-date-form"
                                       :$data />
                    </div>
                    <span class="d-block small-copy-medium birth-date">{{$user->birth_date ?? '-----'}}</span>
                </div>
            </section>
        </section>
    </main>
    <x-toast/>
@endsection

@section('script')
    <script src="{{asset('date-picker/persian-date.min.js')}}"></script>
    <script src="{{asset('date-picker/persian-datepicker.min.js')}}"></script>
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/user.js') }}"></script>
@endsection

