@extends('layouts.admin.master')

@section('page')
    Ads Banner Edit
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
                <form action="" method="post" id="ads_banner_edit" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="" id="ads_banner_id" value="{{ $ads_banner->id }}">

                    <div class="form-group row">
                        <label for="">Banner Category</label>
                        <select name="ads_banner_category_id" id="ads_banner_category_id" class="form-control">
                            <option value="">Chose Banner Category</option>
                            @forelse ($ads_banner_category as $abc)
                                <option value="{{ $abc->id }}" @if ($ads_banner->ads_banner_category_id == $abc->id)
                                    selected
                                @endif>{{ $abc->name }}</option>
                            @empty
                                <option value="">No data found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="company_name" class="control-label">Company Name</label>
                        <input type="text" value="{{ $ads_banner->company_name }}" name="company_name" id="company_name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" value="{{ $ads_banner->title }}" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $ads_banner->description }}</textarea>
                    </div>

                    <div class="form-group row">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <br><br>
                        @if (!empty($ads_banner->image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/banner/small/'.$ads_banner->image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif
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

        $("#ads_banner_edit").on("submit",function (e) {
            e.preventDefault();

            var id = $("#ads_banner_id").val();

            var formData = new FormData( $("#ads_banner_edit").get(0));

            $.ajax({
                url : "{{ route('ads_banner.update','') }}/"+id,
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