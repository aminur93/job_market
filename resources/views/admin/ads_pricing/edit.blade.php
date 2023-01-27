@extends('layouts.admin.master')

@section('page')
    Ads Pricing Edit
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
                <form action="" method="post" id="ads_price_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" id="ads_price_id" value="{{ $ads_price->id }}">

                    <div class="form-group row">
                        <label for="start_price" class="control-label">Start Price</label>
                        <input type="text" value="{{ $ads_price->start_price }}" name="start_price" id="start_price" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="end_price" class="control-label">End Price</label>
                        <input type="text" value="{{ $ads_price->end_price }}" name="end_price" id="end_price" class="form-control">
                    </div>


                    <div class="form-group row">
                        <label for="ads_total" class="control-label">Total Ads</label>
                        <input type="text" value="{{ $ads_price->ads_total }}" name="ads_total" id="ads_total" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="single_month" class="control-label">Single Month</label>
                        <input type="text" value="{{ $ads_price->single_month }}" name="single_month" id="single_month" placeholder="per month" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" value="{{ $ads_price->title }}" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="title" class="control-label">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $ads_price->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('ads_price') }}" class="btn btn-warning">Back</a>
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

        $("#ads_price_edit").on("submit",function (e) {
            e.preventDefault();

            var id = $("#ads_price_id").val();

            var formData = new FormData( $("#ads_price_edit").get(0));

            $.ajax({
                url : "{{ route('ads_price.update','') }}/"+id,
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