@extends('layouts.admin.master')

@section('page')
    Tvc Edit
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
                <form action="" method="post" id="tvc_edit" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="" id="tvc_id" value="{{ $tvc->id }}">

                    <div class="form-group row">
                        <label for="">Date</label>
                        <input type="date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date" id="date" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="company_name" class="control-label">Company Name</label>
                        <input type="text" value="{{ $tvc->company_name }}" name="company_name" id="company_name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" value="{{ $tvc->tvc_title }}" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $tvc->description }}</textarea>
                    </div>

                    <div class="form-group row">
                        <label for="video" class="control-label">Video</label>
                        <input type="file" name="video" id="video" class="form-control">
                        <br><br>

                        @if ($tvc->video != null)
                        <video width="320" height="240" controls>
                            <source src="{{ asset('assets/admin/uploads/tvc/'. $tvc->video) }}" type="video/mp4">
                        </video>
                        @endif
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

        $("#tvc_edit").on("submit",function (e) {
            e.preventDefault();

            var id = $("#tvc_id").val();

            var formData = new FormData( $("#tvc_edit").get(0));

            $.ajax({
                url : "{{ route('tvc.update','') }}/"+id,
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