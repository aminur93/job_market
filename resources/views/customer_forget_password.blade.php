@extends('layouts.front.master')

@section('page')
    Froget Password
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
                        <h5 class="title">Forget Password</h5>
                    </div>
                    <form action="#" method="post" id="forget_password_post">
                        @csrf

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="phone" id="phone" placeholder="Enter your phone number">
                                <i class="fal fa-phone"></i>
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

            $("#forget_password_post").on("submit",function (e) {
                e.preventDefault();

                var phone = $("#phone").val();

                var formData = new FormData( $("#forget_password_post").get(0));

                $.ajax({
                    url : "{{ route('customer_forget_otp_send') }}",
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

                        window.location = "{{ route('customer_pass_update','') }}/"+phone;
                    
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

