@extends('layouts.front.master')

@section('page')
    Contact Us
@endsection

@push('css')
    
@endpush

@section('content')
<section class="contact_page pt-120 pb-120" id="contact">
    <div class="container">
        <div class="contact_map">
            <div class="gmap_canvas">
                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d58438.99370019598!2d90.37660034520664!3d23.73178733112072!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3755b9aaa7fb50d1%3A0x7a3104cb73a7058c!2ssetcolbd!3m2!1d23.7317127!2d90.4116198!5e0!3m2!1sen!2sbd!4v1609999884448!5m2!1sen!2sbd" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="contact_form mt-30">
                    <div class="contact_title">
                        <h5 class="title">Send Us Your Thoughts </h5>
                    </div>
                    <form id="contact_form" action="" method="post">
                        @csrf
                        <div class="contact_form_wrapper">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single_form">
                                        <input type="text" name="name" id="name" placeholder="Name">
                                        <i class="fal fa-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single_form">
                                        <input type="email" name="email" id="email" placeholder="Email">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <input type="text" name="subject" name="subject" placeholder="Subject">
                                        <i class="far fa-i-cursor"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <textarea name="message" id="message" placeholder="Message"></textarea>
                                        <i class="fal fa-edit"></i>
                                    </div>
                                </div>
                                <p class="form-message"></p>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn">Sand Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact_info">
                    <div class="contact_title mt-30">
                        <h5 class="title">Get In Touch</h5>
                    </div>
                    <p> Contact Us For Your Any Need.</p>
                    <div class="single_info d-flex">
                        <div class="info_icon">
                            <i class="far fa-map-marker-alt"></i>
                        </div>
                        <div class="info_content media-body">
                            <p> Level 10, Shorif Complex Purana Polton, Dhaka </p>
                        </div>
                    </div>
                    <div class="single_info d-flex">
                        <div class="info_icon">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="info_content media-body">
                            <p>: +88-01234567890</p>
                            <p>: +88-01234567891</p>
                        </div>
                    </div>
                    <div class="single_info d-flex">
                        <div class="info_icon">
                            <i class="fal fa-envelope-open-text"></i>
                        </div>
                        <div class="info_content media-body">
                            <p><a> info@publicmarket.com </a></p>
                        </div>
                    </div>
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

            $("#contact_form").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#contact_form").get(0));

                $.ajax({
                    url : "{{ route('contact_us.store') }}",
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