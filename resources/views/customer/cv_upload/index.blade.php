@extends('layouts.front.master')

@section('page')
    Customer Cv Upload
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
                <div class="row">

                    <div class="dashboard_content mt-50" id="myads">
                        <div class="post_title">
                            <h5 class="title">My Cv</h5>
                        </div>

                        <div class="text-right mt-3">
                            <a href="{{ route('customer_cv_upload.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>  Cv Upload</a>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                @foreach ($cv as $c)
                                    <div class="col-sm-3" id="cv_list" style="display: flex;align-items: center;gap: 1.5rem;border: 1px solid rgba(0,0,0,.1);margin-right: 10px;">

                                        <a href="{{ route('cv_upload.view','') }}/{{ $c->id }}" target="_blank" style="text-align: center;margin-top:10px;margin-left:-3px;margin-bottom: 1rem">
                                            <i class="fas fa-file-pdf" style="font-size: 5rem;"></i>
                                            <p style="font-size: 10px;">{{ $c->cv }}</p>
                                        </a>
                                        <a style="
                                              font-size: 10px;
                                              position: absolute;
                                              margin-top: 7rem;
                                              margin-left: 2rem;
                                              font-weight: bolder;
                                              color: red;
                                              cursor: pointer;
                                            "
                                       class="cv_delete" rel="{{ $c->id }}">Delete</a>

                                    </div>
                                @endforeach
                            </div>

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
     $(document).ready(function(){
          $(".cv_delete").on("click", function(){

            var id = $(this).attr('rel');

            $.ajax({
              type: "delete",
              url: "{{ route('customer_cv_upload.destroy','') }}/"+id,
              dataType: 'json',
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

                  setTimeout(() => {
                    location.reload();
                  }, 2000);
              }
            })
          })
        })
</script>
@endpush