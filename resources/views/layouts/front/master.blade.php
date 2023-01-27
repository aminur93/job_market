<!doctype html>
<html class="no-js" lang="en">

<head>
 <meta charset="utf-8">
 <title>@yield('page') | {{ config('app.name') }}</title>
 <meta name="description" content="">
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <!-- For Bootstrap Js To Work Like The Burger Button -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="shortcut icon" href="assets/images/FabIcon.png" type="image/png">
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/font/flaticon.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/testimonial.css') }}">
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet">

     <!-- summernote -->
     <link rel="stylesheet" href="{{ asset('assets/admin/plugins/summernote/summernote-bs4.css') }}">
     
     <!-- DataTables -->
     <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap4.css') }}">

 <!-- Select2 -->
 <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
 <style>
     
     .doorstep-banner {
        background-color: #463ce5;
        padding: 15px;
        width: 85%;
    }

    .doorstep-banner .row div h4 {
        color: #ffffff;
        margin-top: 2%;
    }

    .doorstep-banner .row div a {
        margin-left: 80%;
    }

    .doorstep-banner .row div button:hover{
        color: #fff;
    }

    .footer_title {
        font-size: 30px;
        font-weight: bold;
        position: relative;
        padding-bottom: 15px;
        color: #FC7892;
    }

    .footericon {
        color: #FF4367;
        padding-right: 4px;
    }
 </style>

 @stack('css')
</head>
<body class="gray-bg">

@include('layouts.front.header')

@yield('content')

<section class="call_to_action_area pt-20 pb-70">
    <div class="container">
     <div class="row align-items-center">
      <div class="col-lg-5">
       <div class="call_to_action_content mt-45">
        <h4 class="title">Subscribe For Update</h4> </div>
      </div>
      <div class="col-lg-7">
       <div class="call_to_action_form mt-50">
        <form action="#" method="post" id="subscribe_post"> <i class="fal fa-envelope"></i>
         <input type="text" name="email" placeholder="Enter your mail address . . .">
         <button type="submit" class="main-btn">Subscribe</button>
        </form>
       </div>
      </div>
     </div>
    </div>
</section>

@include('layouts.front.footer')

<!--Modal For PostAd    -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 <div class="modal-dialog modal-">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Login Now</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-body">
    <div class="row" id="email_input">
     <form action="" method="post" id="customer_login_post">
         @csrf
        <div class="sign_form_wrapper">
            <div class="single_form">
                <input type="text" name="phone" id="phone" placeholder="phone">
                <i class="fal fa-user"></i>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="single_form">
                <input type="password" name="password" id="password" placeholder="Password">
                <i class="fal fa-key"></i>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <button class="main-btn mt-20 log-in" type="submit">Sign In</button>
        <div class="modal-break-sign mt-20 mb-20">
            <div class="row" >
                <div class="col-5"><hr></div>
                <div class="col-2"><p>Or</p></div>
                <div class="col-5" ><hr></div>
            </div>
        </div>
        <div class="form-group">
            <a href="{{ route('social.facebook') }}" class="btn btn-danger btn-block">Login Wth Facebook</a>
            <a href="{{ route('social.google') }}" class="btn btn-primary btn-block">Login Wth Google</a>
            <a href="" class="btn btn-primary btn-block email_login">Login Wth Email</a>
        </div>
     </form>
    </div>
   </div>
   {{-- <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
   </div> --}}
  </div>
 </div>
</div>

<!-- jQuery -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- Summernote -->
<script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap4.js') }}"></script>


<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>

<script>
    $(function () {
        // Summernote
        $('.textarea').summernote()
    })
</script>

<script>
    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
</script>

<script>
    $(document).ready(function () {

        $("#customer_login_post").on("submit",function (e) {
            e.preventDefault();

            var phone = $("#phone").val();

            var password = $("#password").val();

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url : "{{ route('customer_login.store') }}",
                type: "post",
                data: {phone:phone, password:password, _token:_token},
                dataType: "json",
                success: function (data) {

                    if(data.message) {
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            },
                            toastr.success(data.message);

                        window.location.href = "{{ route('customer_dashboard') }}";
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
                        $('#error_message').append(
                            '<div class="alert alert-danger alert-dismissible fade show mt-10" role="alert">'+
                            '<strong>'+err.responseJSON.errors+'</strong>'+
                            '</div>'
                        );
                    }
                }
            });
        })
    })
</script>

<script>
    $(document).ready(function () {

      $("#subscribe_post").on("submit",function (e) {
          e.preventDefault();

          var formData = new FormData( $("#subscribe_post").get(0));

          $.ajax({
              url : "{{ route('front.subscribe') }}",
              headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
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

<script>
    $(document).ready(function(){

        $(".email_login").on("click", function(e){
            e.preventDefault();

            $("#email_input").empty('');

            $("#email_input").append(

                '<form action="" method="post" id="customer_email_login_post">'+
                    '@csrf'+
                    '<div class="sign_form_wrapper">'+
                        '<div class="single_form">'+
                            '<input type="email" name="email" id="email" placeholder="email">'+
                            '<i class="fal fa-user"></i>'+
                        '</div>'+
                        '<div class="single_form">'+
                            '<input type="password" name="password" id="password" placeholder="Password">'+
                            '<i class="fal fa-key"></i>'+
                        '</div>'+
                    '</div>'+
                    '<button class="main-btn mt-20 log-in" type="submit">Sign In</button>'+
                    '<div class="modal-break-sign mt-20 mb-20">'+
                        '<div class="row" >'+
                            '<div class="col-5"><hr></div>'+
                            '<div class="col-2"><p>Or</p></div>'+
                            '<div class="col-5" ><hr></div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<a href="{{ route('social.facebook') }}" class="btn btn-danger btn-block">Login Wth Facebook</a>'+
                        '<a href="{{ route('social.google') }}" class="btn btn-primary btn-block">Login Wth Google</a>'+
                    '</div>'+
                '</form>'
            );

        })
    })
</script>

<script>
    $(document).ready(function(){

        $('body').on('submit', '#customer_email_login_post', function(e){
            e.preventDefault();

            var email = $("#email").val();

            var password = $("#password").val();

            var _token = $('input[name="_token"]').val();

            $.ajax({
                url : "{{ route('customer_login.email_login') }}",
                type: "post",
                data: {email:email, password:password, _token:_token},
                dataType: "json",
                success: function (data) {

                    if(data.message) {
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            },
                            toastr.success(data.message);

                        window.location.href = "{{ route('customer_dashboard') }}";
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
                        $('#error_message').append(
                            '<div class="alert alert-danger alert-dismissible fade show mt-10" role="alert">'+
                            '<strong>'+err.responseJSON.errors+'</strong>'+
                            '</div>'
                        );
                    }
                }
            });
        })
    })
</script>

@stack('js')
</body>
</html>