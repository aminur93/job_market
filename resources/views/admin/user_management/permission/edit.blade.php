@extends('layouts.admin.master')

@section('page')
    Permission Edit
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
                <form action="" method="post" id="permission_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="" id="permission_id" value="{{ $permission->id }}">

                    <div class="form-group row">
                        <label for="permission_model_name" class="control-label">Permission Model Name</label>
                        <input type="text" value="{{ $permission->permission_model_name }}" name="permission_model_name" id="permission_model_name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="name" class="control-label">Permission Name</label>
                        <input type="text" value="{{ $permission->name }}" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <a href="{{ route('permission') }}" class="btn btn-warning">Back</a>
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

            $("#permission_edit").on("submit",function (e) {
                e.preventDefault();

                var id = $("#permission_id").val();

                var formData = new FormData( $("#permission_edit").get(0));

                $.ajax({
                    url : "{{ route('permission.update','') }}/"+id,
                    type: "post",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
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
                    },

                    error: function (err) {

                        if (err.status === 422) {
                            $.each(err.responseJSON.errors, function (i, error) {
                                var el = $(document).find('[name="'+i+'"]');
                                el.after($('<span class="valids" style="color: red;">'+error+'</span>'));
                            });
                        }

                        if (err.status === 500)
                        {
                            $('#error_message').html('<div class="alert alert-error">\n' +
                                '<button class="close" data-dismiss="alert">×</button>\n' +
                                '<strong>Error! '+err.responseJSON.error+'</strong>' +
                                '</div>');
                        }
                    }
                });
            })
        })
    </script>
@endpush