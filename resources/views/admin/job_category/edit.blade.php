@extends('layouts.admin.master')

@section('page')
    Job Category Edit
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
                <form action="" method="post" id="job_category_edit" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="" id="job_category_id" value="{{ $job_category->id }}">

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" value="{{ $job_category->name }}" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <br><br>
                        @if (!empty($job_category->image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/job_category/small/'.$job_category->image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="{{ route('job_category') }}" class="btn btn-warning">Back</a>
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
    $("#image").on('change', function () {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#image-holder");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image",
                    "width": "100px",
                    "height": "100px"
                }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    });

</script>

<script>
    $(document).ready(function () {
        $("#job_category_edit").on("submit", function (e) {
            e.preventDefault();

            var id = $("#job_category_id").val();

            var formData = new FormData( $("#job_category_edit").get(0));

            $.ajax({
                url: "{{ route('job_category.update','') }}/"+id,
                type: "post",
                data: formData,
                dataType: 'json',
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
                            '<button class="close" data-dismiss="alert">??</button>\n' +
                            '<strong>Error! '+err.responseJSON.error+'</strong>' +
                            '</div>');
                    }
                }
            });
        })
    })
</script>
@endpush