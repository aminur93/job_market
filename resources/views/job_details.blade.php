@extends('layouts.front.master')

@section('page')
    Job Details
@endsection

@push('css')
    <style>
        .text-center {
            text-align: center !important;
        }

        .jobtext p {
            text-align: center;
        }

        .jobtext span {
            color: red;
        }

        .pt-1, .py-1 {
            padding-top: 0.25rem !important;
        }

        .aplon {
            width: 155px;
            height: 44px;
            background-color: #FF4367;
            color: white !important;
            margin-top: 15px;
            font-size: 18px;
            line-height: 40px;
        }

        .job_summary li {
            list-style: none;
            padding-left: 10px;
            font-size: 14px;
        }

        .job_summary span {
            font-weight: bold;
            font-size: 14px;
            padding-right: 3px;
            padding-top: 5px;
        }

        .mt-4, .my-4 {
            margin-top: 1.5rem !important;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .cardbodystyle li {
            border-bottom: 1px solid #D8D8D8;
            list-style: none;
        }

        .card-body li a {
            color: #847588;
            font-size: 14px;
        }

        .card-body i {
            padding-right: 5px;
        }

        .jobsocial li {
            list-style: none;
            border-bottom: 0px;
            float: left;
            padding-right: 5px;
            padding-top: 5px;
        }
    </style>
@endpush

@section('content')
<br>
<section class="pb-120 product_details_page pt-30">
    <div class=container>
        <div class=row>
            <div class=col-lg-12>
                
                <div class="mt-50 product_details">
                    <div class=row>
                        @if(session()->has('message'))
                            
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><a href="{{ route('customer_dashboard') }}">Go to dashboard</a>!</strong> {{ session()->get('message') }}.
                            </div>
                        @endif
                        <div class=col-lg-8>
                            <div class="title_container mt-10 mb-2">
                                <div>
                                    <h5 class="title_container" style="color: #0056B3">{{ $job->position }}</h5>
                                    <p class="title_container" style="color: #0056B3">{{ $job->company_name }}</p>
                                </div>
                            </div>
                            <div class="vacancy">
                                <h6>Vacancy:</h6>
                                <p>&emsp;{{ $job->vacancy }}</p>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Job Context:</h6>
                                <p class="pl-3">
                                    {!! $job->job_description !!}
                                </p>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Job Responsibilities:</h6>
                                <p class="pl-3">
                                    {!! $job->responsibility_description !!}
                                </p>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Employment Status:</h6>
                                <ul class="pl-3">
                                    <li>{{ $job->employement_status }}</li>
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Workplace:</h6>
                                <ul class="pl-3">
                                    <li>{{ $job->work_place }}</li>
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Educational Requirements:</h6>
                                <p class="pl-3">
                                    {!! $job->qualification !!}
                                </p>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Experience Requirements:</h6>
                                <ul class="pl-3">
                                    <li>{{ $job->experience }}</li>
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Additional Requirements:</h6>
                                <ul class="pl-3">
                                    {!! $job->additional_description !!}
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Job Location:</h6>
                                <ul class="pl-3">
                                    <li>{{ $job->location }}</li>
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Salary:</h6>
                                <ul class="pl-3">
                                    <li>Tk. {{ $job->salary }} (Monthly)</li>
                                </ul>
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Compensation & Other Benefits:</h6>
                                <ul class="pl-3">
                                    {!! $job->other_benefits !!}
                                </ul>
                            </div>
                            <div class="feature_details mt-4 mb-5">
                                <h6>Job Source:</h6>
                                <ul class="pl-3">
                                    <li>PublicMarket Online Job Posting.</li>
                                </ul>
                            </div>
                        </div>

                        <div class=col-lg-4>
                            <div class=product_details_sidebar>
                                <div class="product_sidebar_owner mt-4">
                                    <div class="card">
                                        <div class="card-header">Job Summary</div>
                                        <div class="job_summary">
                                            <li><span>Published on:</span>{{ \Carbon\Carbon::parse($job->publish_date)->format('j F, Y') }}</li>
                                            <li><span>Vacancy:</span>{{ $job->vacancy }}</li>
                                            <li><span>Employment Status:</span>{{ $job->employement_status }}</li>
                                            <li><span>Experience:</span>{{ $job->experience }}</li>
                                            <li><span>Gender:</span>{{ $job->gender }}</li>
                                            <li><span>Age:</span>Age {{ $job->age }} years</li>
                                            <li><span>Job Location:</span>{{ $job->location }}</li>
                                            <li><span>Salary:</span>Tk. {{ $job->salary }} (Monthly)</li>
                                            <li><span>Application Deadline:</span>{{ \Carbon\Carbon::parse($job->expire_date)->format('j F, Y') }}</li>
                                        </div>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="card-body cardbodystyle">
                                            <li><a href="#"><i class="fa fa-star l2i"></i>Shortlist this job</a></li>
                                            <li><a href="#"><i class="fa fa-comment l2i"></i>Share by Email</a></li>
                                            <li><a href="#"><i class="fa fa-print l2i"></i>Print this job</a></li>
                                            <li><a href="#"><i class="fa fa-clipboard l2i"></i>Vies all jobs of this company</a></li>
                                            <a class="mt-2" href="#"><i class="fa fa-flag mr-1"></i>Report this job</a>
                                            <div class="card">
                                                <div class="card-body" style="background-color: #FFDDE0">
                                                    <p>এই চাকরির জন্য বিজ্ঞাপন দাতা প্রতিষ্ঠান আপনার কাছ থেকে কোন অর্থ চাইলে অথবা কোন ধরনের ভুল বা বিভ্রান্তিকর তথ্য দিলে অতি সত্ত্বর আমাদেরকে জানান অথবা জবটি রিপোর্ট করুন।</p>
                                                    <p><i class="fa fa-phone mr-1"></i>017000000</p>
                                                    <p><i class="fa fa-comment mr-1"></i>setcoldigital@gmail.com</p>
                                                </div>
                                            </div>
                                            <div class="jobsocial">
                                                <li><i class="fab fa-facebook-f"></i></li>
                                                <li><i class="fab fa-twitter"></i></li>
                                                <li><i class="fab fa-linkedin"></i></li>
                                                <li><i class="fab fa-whatsapp-square"></i></li>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <div class="jobtext text-center">
                            <h5 style="color: #FF4367">Read Before Apply</h5>
                            <hr style="color: #FF4367">
                            <p>Reference site about Lorem Ipsum, giving information on its origins</p>
                            <p><span>*Photograph</span> must be enclosed with the resume.</p>
                            <h6 class="pt-1">Apply Procedure</h6>
                            @if (Auth::guard('customer')->check())
                            <a href="{{ route('apply_job','') }}/{{ $job->id }}" class="aplon" id="apply_now">Apply Online</a> 
                            @else
                            <a href="{{ route('customer_login') }}" class="aplon" id="apply_now">Apply Online</a> 
                            @endif
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<br>
@endsection

@push('js')
    
@endpush