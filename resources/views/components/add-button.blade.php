{{--<a href="{{$link}}"--}}
{{--   class="add-row rounded-circle flex-center bg-green__default white__default order-md-0 order-1--}}
{{--@if ($attributes->has('class')){{$class}} @endif" title="{{$title}}">--}}
{{--    <i class="fa-solid fa-plus"></i>--}}
{{--</a>--}}


<a href="{{$link}}" class="add-row">
<span class="rounded-circle mx-1 action-icon bg-primary__shade-2 white__default d-flex align-items-center justify-content-center">
    <i class="fa-solid fa-plus"></i>
</span>
    <span class="small-copy-medium ps-1 black__shade-1">{{$title}} </span>
</a>

