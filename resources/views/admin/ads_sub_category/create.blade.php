@extends('layouts.admin.master')

@section('page')
    Ads Sub Category Create
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
                <form action="" method="post" id="sub_category_post">
                    @csrf

                    <div class="form-group row">
                        <label for="" class="control-label">Select Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chose Division</option>
                            @forelse ($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @empty
                                <option value="">No division found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <a href="{{ route('sub_category') }}" class="btn btn-warning">Back</a>
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

        $("#sub_category_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#sub_category_post").get(0));

            $.ajax({
                url : "{{ route('sub_category.store') }}",
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