@extends('layouts.front.master')

@section('page')
    Apply Job Now
@endsection

@push('css')
    
@endpush

@section('content')
<section class="sign_in_area mt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div id="error_message"></div>
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="sign_in_form">
                    <div class="sign_title">
                        <h5 class="title">applying Now</h5>
                    </div>
                    <form action="#" method="post" id="job_apply_now">
                        @csrf

                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
                        <input type="hidden" name="job_id" id="job_id" value="{{ $job->id }}">

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" value="{{ $customer->email }}" name="email" id="email" placeholder="Enter your email">
                                <i class="fal fa-phone"></i>
                            </div>
                        </div>

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" value="{{ $customer->phone }}" name="phone" id="phone" placeholder="Enter your phone number">
                                <i class="fal fa-phone"></i>
                            </div>
                        </div>

                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="expacted_salary" id="expacted_salary" placeholder="Enter your Expacted Salary">
                                <i class="fal fa-dollar"></i>
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
        $(document).ready(function(){
            $("#job_apply_now").on("submit", function(e){
                e.preventDefault();

                var formData = new FormData( $("#job_apply_now").get(0));

                $.ajax({
                    url : "{{ route('apply_job.store') }}",
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
                            $('#error_message').html(
                                '<div class="alert alert-danger alert-dismissible fade show mt-10" role="alert">'+
                                '<strong>'+err.responseJSON.errors+'</strong>'+
                                '</div>'
                                );
                        }

                        if (err.status === 400)
                        {
                            $('#error_message').html(
                                '<div class="alert alert-danger alert-dismissible fade show mt-10" role="alert">'+
                                '<strong>'+err.responseJSON.error+'</strong>'+
                                '</div>'
                                );
                        }
                    }
                });
            })
        })
    </script>
@endpush