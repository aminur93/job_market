@extends('layouts.admin.master')

@section('page')
    Ads Banner Create
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
                <form action="" method="post" id="ads_banner_post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="">Banner Category</label>
                        <select name="ads_banner_category_id" id="ads_banner_category_id" class="form-control">
                            <option value="">Chose Banner Category</option>
                            @forelse ($ads_banner_category as $abc)
                                <option value="{{ $abc->id }}">{{ $abc->name }}</option>
                            @empty
                                <option value="">No data found</option>
                            @endforelse
                        </select>
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
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group row">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <br><br>
                        <div id="image-holder"></div>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('ads_banner') }}" class="btn btn-warning">Back</a>
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

    $(document).ready(function () {

        $("#ads_banner_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#ads_banner_post").get(0));

            $.ajax({
                url : "{{ route('ads_banner.store') }}",
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