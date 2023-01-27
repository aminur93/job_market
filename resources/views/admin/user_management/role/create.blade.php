@extends('layouts.admin.master')

@section('page')
    Role Create
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">

        <div id="success_message"></div>

        <div id="error_message"></div>

        <div class="card card-primary">
            <div class="card-header">@yield('page')</div>

            <div class="card-body">
                <form action="" method="post" id="role_post">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <strong>Permission:</strong><hr>
                
                    <div class="row">
                        @foreach ($model_array as $key => $ma)
                            <div class="col-md-3">
                                <h6>{{ $key }}</h6>
                                @foreach ($ma as $m)
                                
                                    <label style="display: block">
                                        <input type="checkbox" name="permissions[]" value="{{ $m['id'] }}"> {{ $m['name'] }}
                                    </label>
                                
                                @endforeach
                            </div>
                           
                        @endforeach
                    </div>
                    

                    <div class="form-group">
                        <a href="{{ route('role') }}" class="btn btn-warning">Back</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#role_post").on("submit",function (e) {
            e.preventDefault();

            var formData = $("#role_post").serializeArray();

            $.ajax({
                url : "{{ route('role.store') }}",
                type: "post",
                data: $.param(formData),
                dataType: "json",
                success: function (data) {
                    if (data.message){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                };
                            toastr.success(data.message);
                        }


                    $("form").trigger("reset");

                    $('.form-group').find('.valids').hide();
                }
            });
        })
    })
</script>
@endpush