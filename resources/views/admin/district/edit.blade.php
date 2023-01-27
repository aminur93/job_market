@extends('layouts.admin.master')

@section('page')
    District Edit
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
                <form action="" method="post" id="district_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" id="district_id" value="{{ $district->id }}">

                    <div class="form-group row">
                        <label for="" class="control-label">Select Division</label>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="">Chose Division</option>
                            @forelse ($divisions as $division)
                                <option value="{{ $division->id }}" @if ($division->id == $district->division_id)
                                    selected
                                @endif>{{ $division->name }}</option>
                            @empty
                                <option value="">No division found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" value="{{ $district->name }}" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="image" class="control-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <br><br>
                        @if (!empty($district->image))
                            <div>
                                <img src="{{ asset('assets/admin/uploads/district/small/'.$district->image) }}" alt="">
                            </div>
                        @else
                            <div id="image-holder"></div>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="{{ route('district') }}" class="btn btn-warning">Back</a>
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

            $("#district_edit").on("submit",function (e) {
                e.preventDefault();

                var id = $("#district_id").val();

                var formData = new FormData( $("#district_edit").get(0));

                $.ajax({
                    url : "{{ route('district.update','') }}/"+id,
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