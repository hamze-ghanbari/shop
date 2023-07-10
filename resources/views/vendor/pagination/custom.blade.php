@if ($paginator->hasPages())
    <section
        class="col-12 table-footer d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
        <span class="d-md-inline-flex d-none small-copy-light">
                       تعداد کل : {{$paginator->total()}}
        </span>

        <div
            class="paginate d-flex align-items-center justify-content-md-end justify-content-center order-md-1 order-0">
            @if (!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="next"><i class="fa-solid fa-angle-right"></i></a>
            @endif
            <div class="page-list d-flex">
                @foreach ($elements as $key => $element)

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <a href="" class="active-page rounded-circle">{{$page}}</a>
                            @else

                                <a href="{{$url}}" class="rounded-circle">{{$page}}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="prev"><i class="fa-solid fa-angle-left"></i></a>
            @endif
        </div>

    </section>
@endif
