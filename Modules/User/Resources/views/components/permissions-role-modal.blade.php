<div class="modal fade" id="{{$target}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-wrap">
                @foreach($permissions as $permission)
                    <span class="badge bg-primary__shade-2 p-2 mx-1 my-1">{{$permission->persian_name}}</span>
                @endforeach
            </div>

        </div>
    </div>
</div>
