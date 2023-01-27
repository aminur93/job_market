@extends('layouts.front.master')

@section('page')
    Customer Dashboard
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
                                <li><a class="{{ Request::routeIs('customer_ads') ? 'active' : '' }}" href="{{ route('customer_ads') }}"><i class="fal fa-layer-group"></i> My Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads_banner') ? 'active' : '' }}" href="{{ route('customer_ads_banner') }}"><i class="fal fa-layer-group"></i> My Banner Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_tvc') ? 'active' : '' }}" href="{{ route('customer_tvc') }}"><i class="fal fa-layer-group"></i> My Tvc</a></li>
                                <li><a class="{{ Request::routeIs('customer_job') ? 'active' : '' }}" href="{{ route('customer_job') }}"><i class="fal fa-layer-group"></i> My Job</a></li>
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

                    <div class="col-md-6">
                        <div class="dashboard_content mt-50">
                            <div class="post_title">
                                <h5 class="title">Dashboard</h5>
                            </div>
                            <div class="row justify-content-center mt-60 mb-20">
                                <div class="col-sm-10">
                                    <div class="card">
                                        <div class="card-body user-card">
                                            <div class="user-image-thumb">
                                                @if ($customer->image != null)
                                                <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="">
                                                @else
                                                <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="user-content pt-30">
                                                <h5 class="text-center"> {{ $customer->name }}</h5>
                                                <p class="text-center"> {{ $customer->email }}</p>
                                                <p class="text-center pt-10"><i class="far fa-map-marker-alt"></i> {{ $customer->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dash-professional-div">
                                        <a href="{{ route('customer_professonal') }}">
                                        <button class="btn professional-btn text-center mt-20">
                                            View Professional Profile
                                        </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dashboard_content message-content mt-50" id="message">
                            <div class="post_title">
                                <h5 class="title">Customer information</h5>
                            </div>
                            <div class="user_list message-list overflow-auto">
                                <ul>
                                    <li style="padding-left: 25px;font-size:15px;font-weight:bold;margin-top:20px">Full Name : {{ $customer->name }}</li>
                                    <li style="padding-left: 25px;font-size:15px;font-weight:bold;margin-top:20px">Division : {{ $customer->division_name }}</li>
                                    <li style="padding-left: 25px;font-size:15px;font-weight:bold;margin-top:20px">District : {{ $customer->district_name }}</li>
                                    <li style="padding-left: 25px;font-size:15px;font-weight:bold;margin-top:20px">Status : @if($customer->status == 1) Active @endif</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <div class="dashboard_content mt-50">
                    <div class="post_title">
                        <h5 class="title">Statistics</h5>
                    </div>
                    <div class="row justify-content-around mt-10 mb-10">
                        <div class="col-md-3 col-sm-6 equal-height card-1 text-center mt-10">
                            <a href="#myads">
                            <div class="item">
                                <i class="far fa-check-circle stat-icon"></i>
                                <h4 class="pt-10">Ads Posted</h4>
                                <h6 class="text-center pt-10">50</h6>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 equal-height card-2 text-center mt-10">
                            <a href="#myads">
                            <div class="item">
                                <i class="far fa-rocket stat-icon"></i>
                                <h4 class="pt-10">Boosted Ads</h4>
                                <h6 class="text-center pt-10">30</h6>
                            </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 equal-height card-3 text-center mt-10" >
                            <a href="#message">
                            <div class="item">
                                <i class="far fa-comment-alt-lines stat-icon"></i>
                                <h4 class="pt-10">Messages</h4>
                                <h6 class="text-center pt-10">90</h6>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-10 row justify-content-center">
                    <div class="col-2"> 
                        <a href="{{ route('customer_logout') }}" class="main-btn">Logout</a> 
                    </div>  
                </div> --}}

            </div>
        </div>
    </div>
</section>
<br/>
@endsection

@push('js')
    
@endpush