@extends('admin-layout.master')

@section('title', 'ادمین | مدیریت نقش ها')
@section('style')
    <link rel="stylesheet" href="{{ asset('modules/user/css/app.css') }}">
@endsection

@section('content')

    <section class="col-12 table-box p-2 bg-white__default">
        <section class="col-12 filter-box d-flex flex-wrap justify-content-center justify-content-sm-between">
            <form method="get" action="{{route('roles.index')}}"
                  class="col-10 col-sm-4 col-md-6 search-box d-flex align-items-center p-2">
                <button type="submit" class="border-0 action-icon bg-primary__shade-2 white__default">
                    <i class="fa-solid fa-search"></i>
                </button>
                <input type="text" name="search" value="{{Request::query('search')}}"
                       placeholder="نام نقش را جستجو کنید"
                       class="w-100 px-1 small-copy-light"/>
            </form>
            @if(count($roles) > 0)
                <x-add-button link="{{route('roles.create')}}" title="افزودن نقش جدید"/>
            @endif
        </section>
        <section class="col-12 table-content">
            @if(count($roles) > 0)
                <table class="col-12 table table-responsive main-table p-2 bg-white__default  m-auto">
                    <thead>
                    <tr>
                        <td class="small-copy-medium">#</td>
                        <td class="small-copy-medium">نام نقش</td>
                        <td class="small-copy-medium">توضیحات نقش</td>
                        <td class="small-copy-medium">سطوح دسترسی</td>
                        <td class="small-copy-medium">وضعیت نقش</td>
                        <td class="small-copy-medium">تاریخ ثبت</td>
                        <td><span class="text-body p-2 white__default"><i class="fa fa-list"></i></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr class="bg-light">
                            <td class="small-copy-light row-num">{{$loop->iteration}}</td>
                            <td class="small-copy-light">{{$role->name}}</td>
                            <td class="small-copy-light">
                                @if(isset($role->persian_name))
                                    {{$role->persian_name}}
                                @else
                                    -----
                                @endif
                            </td>
                            <td class="small-copy-light">
                                @if(!empty($role->getRelation('permissions')->toArray()))
                                    <button
                                        class="btn pointer d-inline-flex action-icon bg-dark-blue__shade-3 white__default"
                                        data-bs-toggle="modal" data-bs-target="#role{{$role->id}}">
                                        <i class="fa-solid fa-eye"
                                           data-bs-toggle="tooltip" data-bs-placement="right"
                                           title="نمایش سطوح دسترسی"></i>
                                    </button>
                                @php
                                    $permissions = $role->getRelation('permissions');
                                    $target = 'role'.$role->id;
                                @endphp
                                    <x-permission-modal :$permissions :$target />
                                @else
                                    -----
                                @endif
                            </td>
                            <td>

                                <a href="{{route('roles.status', ['role' => $role->id, 'status' => $role->status ? '0' : '1'])}}"
                                   class="badge
                                         @if($role->status) bg-green__default @else bg-red__default @endif  py-2 px-4 change-status"
                                   data-bs-toggle="tooltip" data-bs-placement="right"
                                   title="{{$role->status ? 'غیرفعال کردن نقش' : 'فعال کردن نقش'}}">{{$role->status ? 'فعال' : 'غیرفعال'}}</a>
                            </td>
                            <td class="small-copy-light">{{$role->created_at}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{route('roles.permission.show', ['role' => $role->id])}}"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="ثبت سطوح دسترسی"
                                       class="action-icon rounded-circle flex-center bg-green__default white__default ms-2">
                                        <i class="fa-solid fa-user-check"></i>
                                    </a>
                                    <a href="{{route('roles.edit', ['role' => $role->id])}}"
                                       data-bs-toggle="tooltip" data-bs-placement="right" title="ویرایش نقش"
                                       class="action-icon bg-dark-blue__default white__default ms-2">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="{{route('roles.destroy', ['role' => $role->id])}}" id="{{$role->id}}"
                                       data-bs-toggle="tooltip"  data-bs-placement="right" title="حذف نقش"
                                       class="action-icon delete-role bg-red__shade-3 white__default">
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
                        <span class="body-copy-medium">"نقش"</span>
                        برای نمایش وجود ندارد
                    </p>
                    <x-add-button link="{{route('roles.create')}}" title="افزودن نقش جدید"/>
                </section>
            @endif
        </section>

        {{$roles->links()}}

    </section>
    <a href="{{route('roles.create')}}"
       class="add-mobile-btn rounded-circle bg-primary__shade-2 white__default position-fixed">
        <i class="fa-solid fa-plus"></i>
    </a>
{{--    <x-confirm-alert />--}}
    <x-toast/>
@endsection

@section('script')
    <script src="{{ asset('modules/user/js/app.js') }}"></script>
    <script src="{{ asset('modules/user/js/role.js') }}"></script>
@endsection
