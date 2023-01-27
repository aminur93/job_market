@extends('layouts.front.master')

@section('page')
    Marchent Register
@endsection

@push('css')
    
@endpush

@section('content')
<section class="sign_in_area pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="sign_in_form">
                    <div class="sign_title">
                        <h5 class="title">Sign Up Now For Merchent</h5>
                    </div>
                    <form action="" method="post" id="marchent_register_post" enctype="multipart/form-data">
                        @csrf
                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="name" id="name" placeholder="Username">
                                <i class="fal fa-user"></i>
                            </div>
                            <div class="single_form">
                                <input type="email" name="email" id="email" placeholder="Email">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <div class="single_form">
                                <input type="text" name="phone" id="phone" placeholder="Phone">
                                <i class="fal fa-phone"></i>
                            </div>

                            <div class="dropdown mt-15">
                                <select name="role" id="role" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="single_form signup-image-upload">
                                <input type="file" name="image" id="image">
                                <i class="fal fa-portrait"></i>
                            </div>
                            <div class="single_form">
                                <input type="password" name="password" id="password" placeholder="Password">
                                <i class="fal fa-key"></i>
                            </div>
                            <div class="single_form">
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                <i class="fal fa-key"></i>
                            </div>
                            <div class="single_form">
                                <div class="sign_checkbox">
                                    <input type="checkbox" name="terms_conditions" id="terms_conditions">
                                    <label for="terms_conditions"></label>
                                    <span>By registering, you accept our Terms & Conditions</span>
                                </div>
                                <div class="sign_new">
                                    <a href="{{route('login')}}">Already Signed Up?</a>
                                </div>
                            </div>
                           
                            <button  class="main-btn mt-20 log-in" type="submit">
                                Sign Up
                            </button>
                            
                            <div class="modal-break-sign mt-20 mb-20">
                                <div class="row" >
                                    <div class="col-5"><hr></div>
                                    <div class="col-2"><p>Or</p></div>
                                    <div class="col-5" ><hr></div>
                                </div>
                            </div>
                            <div class="social-media-sign" >
                                <div class="row" >
                                    <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3"></div>
                                    <div class="col-xl-0 col-lg-0 col-md-1 col-sm-1"></div>
                                    <div class="col-xl-12">
                                        <div class="login_social">
                                            <ul style="display: flex;
                                            align-items: center;
                                            gap: 1.5rem;
                                            margin-left: 110px;">
                                                <li><a href="https://www.facebook.com"><img class="social_media" src="{{asset('frontend/assets/images/social_media_icon/facebook.png')}}" alt="social_media"></a></li>
                                                <li><a href="https://www.facebook.com"><img class="social_media" src="{{asset('frontend/assets/images/social_media_icon/linkedin.png')}}" alt="social_media"></a></li>
                                                <li><a href="https://www.twitter.com"><img class="social_media" src="{{asset('frontend/assets/images/social_media_icon/twiter.png')}}" alt="social_media"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3"></div>
                                </div>
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

            $("#marchent_register_post").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#marchent_register_post").get(0));

                $.ajax({
                    url : "{{ route('marchent_register.store') }}",
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

                        window.location = "{{ route('marchent_register.verify','') }}/"+data.phone;
                    
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