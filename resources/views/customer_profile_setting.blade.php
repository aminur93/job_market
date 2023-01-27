@extends('layouts.front.master')

@section('page')
    Customer Profile Setting
@endsection

@push('css')
    
@endpush

@section('content')
<section class="dashboard_page pt-70 pb-120">
    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <div class="sidebar_profile mt-50">
                    <div class="profile_user">
                        <div class="user_author d-flex align-items-center">
                            <div class="author">
                                @if ($customer->image != null)
                                <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="">
                                @else
                                <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                                @endif
                                
                            </div>
                            <div class="user_content media-body">
                                <p class="author_name">{{ $customer->name }}</p>
                                <p>{{ $customer->phone }}</p>
                            </div>
                        </div>
                        <div class="user_list">
                            <ul>
                                <li><a class="{{ Request::routeIs('customer_dashboard') ? 'active' : '' }}" href="{{ route('customer_dashboard') }}"><i class="fal fa-tachometer-alt-average"></i> Dashboard</a></li>
                                <li><a class="{{ Request::routeIs('customer_profile_setting') ? 'active' : '' }}" href="{{ route('customer_profile_setting') }}"><i class="fal fa-cog"></i> Profile Settings</a></li>
                                <li><a class="{{ Request::routeIs('customer_professonal') ? 'active' : '' }}" href="{{ route('customer_professonal') }}"><i class="fal fa-user-tie"></i> Professional Profile</a></li>
                                                                <li><a class="{{ Request::routeIs('customer_ads','customer_ads.create','customer_ads.edit') ? 'active' : '' }}" href="{{ route('customer_ads') }}"><i class="fal fa-layer-group"></i> My Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads_banner','customer_ads_banner.create','customer_ads_banner.edit') ? 'active' : '' }}" href="{{ route('customer_ads_banner') }}"><i class="fal fa-layer-group"></i> My Banner Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads_tvc','customer_ads_tvc.create','customer_ads_tvc.edit') ? 'active' : '' }}" href="{{ route('customer_tvc') }}"><i class="fal fa-layer-group"></i> My Tvc</a></li>
                                <li><a class="{{ Request::routeIs('customer_job','customer_job.create','customer_job.edit') ? 'active' : '' }}" href="{{ route('customer_job') }}"><i class="fal fa-layer-group"></i> My Job</a></li>
                                <li><a href="{{ route('customer_logout') }}"><i class="fal fa-sign-out"></i> Sign Out</a></li>
                                <li><a href="{{ route('customer_delete_account') }}"><i class="fal fa-sign-out"></i> Delete Account</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sidebar_profile mt-30" id="sidebar_cv">
                    <div class="profile_user">
                        <div class="post_title">
                            <h5 class="title">My CV</h5>
                        </div>
                        <div class="user_list">
                            <ul>
                                <li><a class="{{ Request::routeIs('customer_cv_upload') ? 'active' : '' }}" href="{{ route('customer_cv_upload') }}"><i class="fal fa-file-upload"></i>Upload CV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="post_form mt-50">
                    <div class="post_title">
                        <h5 class="title">Profile Settings</h5>
                    </div>
                    <div class="pro-image pt-20">
                        @if ($customer->image != null)
                        <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="" style="width: 150px">
                        @else
                        <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                        @endif
                    </div>
                    <form action="#" method="post" id="customer_profile_update" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="single_form">
                                    <label>First Name</label>
                                    <input type="text" value="{{ $customer->name }}" name="name" id="name" placeholder="First Name">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="single_form">
                                    <label>Email</label>
                                    <input type="email" value="{{ $customer->email }}" name="email" id="email" placeholder="E-mail Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_form">
                                    <label>Phone Number</label>
                                    <input type="text" value="{{ $customer->phone }}" name="phone" id="phone" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_form">
                                    <label>Local Address</label>
                                    <input type="text" value="{{ $customer->address }}" name="address" id="address" placeholder="Flat No. Road No.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-20">
                                    <label>Division Name</label>
                                    <select name="division_id" id="division_id" class="form-control">
                                        <option value="">Select Division</option>
                                        @forelse ($divisions as $division)
                                            <option value="{{ $division->id }}" @if ($customer->division_id == $division->id)
                                                selected
                                            @endif>{{ $division->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-20">
                                    <label>District Name</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="">Select District</option>
                                        @forelse ($district as $d)
                                            <option value="{{ $d->id }}" @if ($customer->district_id == $d->id)
                                                selected
                                            @endif>{{ $d->name }}</option>
                                        @empty
                                            <option value="">No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="single_form pro-setting-image">
                                    <label>Profile Image</label>
                                    <input type="file" name="image" id="image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                                <div class="single_form">
                                    <button type="submit" class="main-btn">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        
                <div class="post_form mt-50">
                    <div class="post_title">
                        <h5 class="title">Update Password</h5>
                    </div>
                    <form action="#" method="POST" id="customer_password_update">
                        @method('PUT')
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="single_form">
                                    <label>Old Password</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single_form">
                                    <label>New Password</label>
                                    <input type="password" name="password" id="password" placeholder="New Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single_form">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_form">
                                    <button type="submit" class="main-btn">Update Password</button>
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
            $("#division_id").on("change",function () {

                var division_id = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('customer_profile_setting.getDistrict') }}",
                    type: "post",
                    data: {division_id:division_id, _token:_token},
                    dataType: "html",
                    success: function (html) {
                        $("#district_id").html(html);
                    }
                });
            })
        })

        $(document).ready(function () {

            $("#customer_profile_update").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#customer_profile_update").get(0));

                $.ajax({
                    url : "{{ route('customer_profile_setting.customer_profile_update') }}",
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

        $(document).ready(function () {

            $("#customer_password_update").on("submit",function (e) {
                e.preventDefault();

                var formData = new FormData( $("#customer_password_update").get(0));

                $.ajax({
                    url : "{{ route('customer_profile_setting.customer_password_update') }}",
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