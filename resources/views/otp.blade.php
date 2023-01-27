@extends('layouts.front.master')

@section('page')
    Verify
@endsection

@push('css')
    
@endpush

@section('content')
<section class="sign_in_area mt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="sign_in_form">
                    <div class="sign_title">
                        <h5 class="title">Please Verify Now</h5>
                    </div>
                    <form action="#" method="post" id="otp_post">
                        @csrf

                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
                        <input type="hidden" name="phone" id="phone" value="{{ $customer->phone }}">

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="otp_code" placeholder="Enter 4 digits code">
                                <i class="fas fa-barcode"></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button class="main-btn mt-20 log-in" type="submit">
                                    Verify
                                </button>
                            </div>

                            <div class="col-md-6">
                                <button class="main-btn mt-20 log-in" id="resend_code">
                                    Resend Code
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<br/>

@endsection

@push('js')
    <script>
         $(document).ready(function () {

            $("#otp_post").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#otp_post").get(0));

                $.ajax({
                    url : "{{ route('customer_register.check') }}",
                    type: "post",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    // cache: false,
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

                        window.location = "{{ route('customer_login') }}";
                    
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

        $(document).ready(function () {

            $("#resend_code").on("click",function (e) {
                e.preventDefault();

                var phone = $("#phone").val();
                var customer_id = $("#customer_id").val();

                $.ajax({
                    url : "{{ route('customer_register.resend') }}",
                    type: "post",
                    data: {phone:phone, customer_id:customer_id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
                                '<strong>Error! '+err.responseJSON.errors+'</strong>' +
                                '</div>');
                        }
                    }
                });
            })
        })
    </script>
@endpush

