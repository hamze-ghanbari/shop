@if(session('add-success'))
    <div class="col-12 flex-center">
        <div class="col-12 col-md-6 alert alert-success text-center fade show my-2" role="alert">
            {{session('add-success')}}
        </div>
    </div>
@endif
@if(session('add-error'))
    <div class="col-12 flex-center">
        <div class="col-12 col-md-6 alert alert-danger text-center fade show my-2" role="alert">
            {{session('add-error')}}
        </div>
    </div>
@endif
