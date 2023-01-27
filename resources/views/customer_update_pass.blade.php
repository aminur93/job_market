@extends('layouts.front.master')

@section('page')
    Customer Update Password
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
                        <h5 class="title">Customer Update Password</h5>
                    </div>
                    <form action="#" method="post" id="customer_update_password">
                        @csrf

                        <input type="hidden" id="customer_id" name="customer_id" value="{{ $customer->id }}">

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="otp_code" placeholder="Enter your otp code">
                                <i class="fal fa-barcode"></i>
                            </div>
                        </div>

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <label>New Password</label>
                                <input type="password" name="password" id="password" placeholder="New Password">
                            </div>
                        </div>
                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button class="main-btn mt-20 log-in" type="submit">
                                    submit
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

            $("#customer_update_password").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#customer_update_password").get(0));

                $.ajax({
                    url : "{{ route('customer_pass_update_phone') }}",
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

    </script>
@endpush

