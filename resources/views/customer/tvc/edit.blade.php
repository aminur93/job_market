@extends('layouts.front.master')

@section('page')
    Customer Tvc Edit
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
                                <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="" style="width: 150px">
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
                                <li><a class="{{ Request::routeIs('customer_ads_banner','customer_ads_banner.create','customer_ads_banner.edit') ? 'active' : '' }}" href="{{ route('customer_ads_banner') }}"><i class="fal fa-layer-group"></i> My Ads Banner</a></li>
                                <li><a class="{{ Request::routeIs('customer_tvc','customer_tvc.create','customer_tvc.edit') ? 'active' : '' }}" href="{{ route('customer_tvc') }}"><i class="fal fa-layer-group"></i> My Tvc</a></li>
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

            <div class="col-lg-8 mt-50">

                <h5>Customer Tvc Create</h5><hr>
               
                <form action="" method="post" id="customer_tvc_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="tvc_id" id="tvc_id" value="{{ $tvc->id }}">

                    <div class="row">

                        <div class="form-group row">
                            <label for="">Date</label>
                            <input type="date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date" id="date" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="company_name" class="control-label">Company Name</label>
                                <input type="text" value="{{ $tvc->company_name }}" name="company_name" id="company_name" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="title" class="control-label">Title</label>
                                <input type="text" value="{{ $tvc->tvc_title }}" name="title" id="title" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $tvc->description }}</textarea>
                            </div>
        
                            <div class="form-group">
                                <label for="video" class="control-label">Video</label>
                                <input type="file" name="video" id="video" class="form-control">
                                <br><br><br>
                                @if ($tvc->video != null)
                                <video width="320" height="240" controls>
                                    <source src="{{ asset('assets/admin/uploads/tvc/'. $tvc->video) }}" type="video/mp4">
                                </video>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<br/>
@endsection

@push('js')
    <script>
        
        $(document).ready(function () {

            $("#customer_tvc_edit").on("submit",function (e) {
                e.preventDefault();

                var id = $("#tvc_id").val();

                var formData = new FormData( $("#customer_tvc_edit").get(0));

                $.ajax({
                    url : "{{ route('customer_tvc.update','') }}/"+id,
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