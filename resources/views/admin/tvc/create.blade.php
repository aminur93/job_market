@extends('layouts.admin.master')

@section('page')
    Tvc Create
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">

        <div id="success_message"></div>

        <div id="error_message"></div>

        <div class="card card-default">
            <div class="card-header">@yield('page')</div>

            <div class="card-body">
                <form action="" method="post" id="tvc_post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="">Date</label>
                        <input type="date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date" id="date" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="company_name" class="control-label">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group row">
                        <label for="video" class="control-label">Video</label>
                        <input type="file" name="video" id="video" class="form-control">
                    </div>

                    <div class="form-group">
                        <a href="{{ route('tvc') }}" class="btn btn-warning">Back</a>
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

        $("#tvc_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#tvc_post").get(0));

            $.ajax({
                url : "{{ route('tvc.store') }}",
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