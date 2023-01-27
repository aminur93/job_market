@extends('layouts.front.master')

@section('page')
    Customer Professoanl Setting
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
                                <li><a class="{{ Request::routeIs('customer_professonal','customer_professonal.create') ? 'active' : '' }}" href="{{ route('customer_professonal') }}"><i class="fal fa-user-tie"></i> Professional Profile</a></li>
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
                <div class=row>
                    <div class=col-md-6>
                        <div class="mt-50 dashboard_content">
                            <div class=post_title>
                                <h5 class=title>Professional Profile</h5>
                            </div>
                            <div class="row justify-content-center mb-20 mt-60">
                                <div class=col-sm-12>
                                    <div class=card>
                                        <div class="card-body user-card">
                                            <div class=pro-user-image-thumb>
                                                @if ($customer->image != null)
                                                <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="">
                                                @else
                                                <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="pt-100 user-content">
                                                <h5 class="text-center pl-3">{{ $customer->name }}</h5>
                                                <p class="text-center pl-3 pt-1"><i class="fal fa-briefcase"></i> {{ $customer_professon->title }}</p>
                                                <p class="text-center pl-3 pt-1"><i class="fal fa-graduation-cap"></i>{{ $customer_professon->degree }}</p>
                                                <div class="row pl-2 pr-2 pt-30 pro-user-content">
                                                    <div class="col-4"><p class="text-left"><i class="far fa-map-marker-alt"></i> From :</p></div>
                                                    <div class="col-8"><p class="text-right">{{ $customer->division_name }}, Bangladesh</p></div>
                                                </div>
                                                <div class="row pl-2 pr-2 pt-10 pro-user-content">
                                                    <div class="col-6"><p class="text-left"><i class="far fa-calendar-alt"></i> Member Since:</p></div>
                                                    <div class="col-6"><p class="text-right">{{ $customer->created_at->diffForHumans() }}</p></div>
                                                </div>
                                                <div class="row pl-2 pr-2 pt-10 pro-user-content">
                                                    <div class="col-6"><p class="text-left"><i class="far fa-calendar-check"></i> Availability:</p></div>
                                                    <div class="col-6"><p class="text-right">9:00Am - 6:00Pm</p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @if (empty($customer_av))
                                        <button class="btn professional-btn text-center mt-20 available" type=button>
                                            Set Availability
                                        </button>
                                        @endif

                                        @if ($customer_av->available == 1)
                                        <button class="btn professional-btn text-center mt-20 available" type=button>
                                            I am  Available
                                        </button>

                                        @else
                                        <button class="btn professional-btn text-center mt-20 available" type=button>
                                            I am not  Available
                                        </button>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30 dashboard_content">
                            <div class=post_title>
                                <h5 class=title>Details</h5>
                            </div>
                            <div class="row justify-content-center mb-20 mt-15">
                                <div class="pro-desc-title pb-2">
                                    <h5 class="title pb-2">Description</h5>
                                </div>
                                <div class=col-sm-12>
                                    <div class=card>
                                        <div class="card-body user-card">
                                            <div class=" pl-3 text-justify user-content">
                                                <p>
                                                    {{ $customer_professon->details }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-20 mt-15">
                                <div class="pro-desc-title pb-2">
                                    <h5 class="title pb-2">Languages</h5>
                                </div>
                                <div class=col-sm-12>
                                    <div class=card>
                                        <div class="card-body user-card">
                                            <div class=" pl-3 text-justify user-content pro-language">
                                                @forelse ($customer_language as $cl)
                                                <p class="pb-1">
                                                    <i class="fal fa-language"></i> {{ $cl->language_name }} 
                                                 </p>
                                                @empty
                                                <p class="pb-1">
                                                    No Data found
                                                 </p>
                                                @endforelse
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30 dashboard_content">
                            <div class=post_title>
                                <h5 class=title>Skills</h5>
                            </div>
                            <div class="row justify-content-center mb-20 mt-15">
                                <div class="pro-desc-title pb-2">
                                    <h5 class="title pb-2">Skills</h5>
                                </div>
                                <div class=col-sm-12>
                                    <div class=card>
                                        <div class="card-body skill-card-body">
                                            <div class=" pl-3 text-justify user-content">
                                                @forelse ($customer_skills as $cs)
                                                <span class="pro-skill-span">{{ $cs->skills_name }}</span>
                                                @empty
                                                <span class="pro-skill-span">No Data Found</span>
                                                @endforelse
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30 dashboard_content message-content">
                            <div class=post_title>
                                <h5 class=title>Linked Profiles</h5>
                            </div>
                            <div class="ml-10 mr-10 linked-profile mt-10 mb-10">
                                @forelse ($customer_profile_link as $cpl)
                                <p class="linked-icon"><i class="lni lni-facebook-original"></i> {{ $cpl->profile_link }}</p>
                                @empty
                                <p class="linked-icon"><i class="lni lni-facebook-original"></i> No Data Found</p>
                                @endforelse
                              
                    
                            </div>
                        </div>
                    </div>
                    <div class=col-md-6>
                        <div class="mt-50 dashboard_content message-content">
                            <div class=post_title>
                                <h5 class=title>Experience</h5>
                            </div>
                            @forelse ($customer_work_exp as $cws)
                            <div class="pl-3 education pt-10">
                                <h5 class="education-title mb-3 pb-2">{{ $cws->position }}</h5>
                                <p class=institute-name><i class="fal fa-building"></i>{{ $cws->workplace_name }}</p>
                                <p class="degree-name"><i class="fal fa-address-card"></i> {{ $cws->position }}</p>
                                <p class="certi-des pb-3 pt-3">{{ $cws->description_role }}</p>
                                <p>
                                <div class="row exp-description justify-content-between">
                                    <div class=col-12>
                                        <p><span><i class="fal fa-calendar-alt"></i> Working Period:</span> {{ \Carbon\Carbon::parse($cws->join_date)->format('j F, Y') }} - {{ \Carbon\Carbon::parse($cws->leave_date)->format('j F, Y') }}</p>
                                    </div>
                                </div>
                                </p>
                            </div>
                            @empty
                            <div class="pl-3 education pt-10">No Data Found</div>
                            @endforelse
                            
                        </div>

                        <div class="mt-30 dashboard_content message-content">
                            <div class=post_title>
                                <h5 class=title>Education</h5>
                            </div>
                            @forelse ($customer_edu as $ce)
                            <div class="pl-3 education pt-10">
                                {{-- <h5 class="education-title mb-3 pb-2">School</h5> --}}
                                <p class=institute-name><i class="fal fa-school"></i>{{ $ce->institution_name }}</p>
                                <p class="degree-name"><i class="fal fa-diploma"></i> {{  $ce->institution_certificate }}</p>
                                {{-- <p class="edu-department pb-1 pt-1"><span><i class="fal fa-code-branch"></i>Branch:</span> Science</p> --}}
                                <p>
                                <div class="row edu-description justify-content-between">
                                    <div class=col-7>
                                        <p><span><i class="fal fa-graduation-cap"></i>Graduation:</span> {{ \Carbon\Carbon::parse($ce->passing_year)->format('j F, Y') }}</p>
                                    </div>
                                    <div class=col-5>
                                        <p class="mr-2 text-right">GPA: {{ $ce->result }}</p>
                                    </div>
                                </div>
                                </p>
                            </div>
                            @empty
                            <div class="pl-3 education pt-10">No Data Found</div>
                            @endforelse
                        </div>

                        <div class="mt-30 dashboard_content message-content">
                            <div class=post_title>
                                <h5 class=title>Certification</h5>
                            </div>
                            @forelse ($customer_certi as $cc)
                            <div class="pl-3 education pt-30">
                                <h5 class="education-title mb-3 pb-2">{{ $cc->organization_name }}</h5>
                                <p class=institute-name><i class="fal fa-file-certificate"></i> &nbsp;&nbsp;{{ $cc->certificate_name }}</p>
                                {{-- <p class="certi-des pb-1 pt-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur, dolorem ducimus error ex nihil soluta suscipit vol</p> --}}
                                <p class="edu-department pb-1 pt-1"><span><i class="fal fa-code-branch"></i>Field:</span>{{ $cc->certificate_area }}</p>
                                <p>
                                <div class="row edu-description justify-content-between">
                                    <div class=col-7>
                                        <p><span><i class="fal fa-graduation-cap"></i>Date:</span>{{ \Carbon\Carbon::parse($cc->certificate_date)->format('j F, Y') }}</p>
                                    </div>
                                </div>
                                </p>
                            </div>
                            @empty
                            <div class="pl-3 education pt-30">No Data Found</div>
                            @endforelse
                            
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-20 text-center">
                    <a href="{{ route('customer_professonal.create') }}">
                    <button class="main-btn">
                        Edit Professional Profile
                    </button>
                    </a>
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
            $(".available").on('click', function(){

                $.ajax({
                    url: "{{ route('customer_professonal.available') }}",
                    type: "GET",
                    datatype: "json",
                    success: function(data){

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
                    }
                })
            })
        })
    </script>
@endpush