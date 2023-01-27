@extends('layouts.front.master')

@section('page')
    Customer Profesonal Create
@endsection

@push('css')
    <style>
        .single_form #skills_chosen{
            width: 650px !important;
        }

        .language #skills_chosen{
            width: 250px !important;
        }
    </style>
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
                @if (empty($customer_professon))
                <form action="#" method="post" id="customer_information_post">
                    @csrf

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Create Professional Profile</h5>
                        </div>
                        <div class="pro-image pt-20">
                            @if ($customer->image != null)
                            <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="" style="width:150px">
                            @else
                            <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                            @endif
                        </div>
    
                        <div class="row justify-content-center">
                            <div class="col-6 mt-20">
                                <div class="post_title">
                                    <h5 class="title">Profile</h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <label>Professional Title</label>
                                        <input type="text" name="title" id="title" placeholder="Professional Title : Doctor, Lawyer, Engineer">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <label>Featured Degrees</label>
                                        <input type="text" name="degree" id="degree" placeholder="Professional Degrees : BBA, BCom">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 college-border mt-20">
                                <div class="post_title">
                                    <h5 class="title">Details</h5>
                                </div>
                                
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Small Description About Yourself</label>
                                            <textarea type="text" name="details" id="details" rows="2"  placeholder="Enter A Small Description About Yourself" style="resize: none;" ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class=" language">
                                            <label for="">Language</label>
                                            <select data-placeholder="Select Skills" multiple class="chosen-select" name="language_name[]" id="skills">
                                                <option value=""></option>
                                                <option value="bangla">Bangla</option>
                                                <option value="english">English</option>
                                                <option value="hindi">Hindi</option>
                                                <option value="urdu">Urdu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Skills</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-20">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="row justify-content-center">
                                            <div class="col-md-12">
                                                <div class="single_form">
                                                    <select data-placeholder="Select Skills" multiple class="chosen-select" name="skills_name[]" id="skills">
                                                        <option value=""></option>
                                                        <option value="html">Html5</option>
                                                        <option value="css">CSS3</option>
                                                        <option value="sass">Sass</option>
                                                        <option value="php">PHP</option>
                                                        <option value="laravel">Laravel</option>
                                                        <option value="javascript">Javascript</option>
                                                        <option value="react">React</option>
                                                        <option value="angular">Angular</option>
                                                        <option value="vue">Vue</option>
                                                        <option value="mysql">MySql</option>
                                                        <option value="postgresql">Postgresql</option>
                                                        <option value="node">Node</option>
                                                        <option value="python">Python</option>
                                                        <option value="django">Django</option>
                                                        <option value="aws">Aws</option>
                                                        <option value="digitalocean">DigitalOcean</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Experience</h5>
                        </div>
                        <div class="row" id="dataAdd">
                            <div class="col-md-12 mt-20 container">
                                <div class="row justify-content-center form-row">
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Workplace</label>
                                            <input type="text" name="workplace_name[]" id="workplace_name" placeholder="Enter Company Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Position</label>
                                            <input type="text" name="position[]" id="position" placeholder="Enter Position Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Short Description Of Your Role</label>
                                            <textarea type="text" name="description_role[]" rows="2" placeholder="Describe Your Role In Short" style="resize: none;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Date Of Joining</label>
                                            <input type="date" name="join_date[]" id="join_date">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Date Of Leaving</label>
                                            <input type="date" name="leave_date[]" id="leave_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 35px">
                            <a class="btn btn-sm btn-primary" id="addRow"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Education</h5>
                        </div>
                        <div class="row" id="dataAddEducation">
                            <div class="col-md-12 mt-20 container">
                                <div class="row justify-content-center form-row">

                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Instution</label>
                                            <input type="text" name="institution_name[]" id="institution_name" placeholder="Enter School Name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Certificate</label>
                                            <input type="text" name="institution_certificate[]" id="institution_certificate" placeholder="Enter Certificate Name : PSC/JSC/SSC">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Date OF Graduation</label>
                                            <input type="date" name="passing_year[]" id="passing_year">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>GPA</label>
                                            <input type="text" name="result[]" id="result" placeholder="Enter GPA">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-top: 35px">
                                <a class="btn btn-sm btn-primary" id="addRowEducation"><i class="fa fa-plus"></i></a>
                                <a class="btn btn-sm btn-danger" id="deleteRowEducation"><i class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Certification</h5>
                        </div>
                        <div class="row" id="dataAddcertificate">
                            <div class="col-md-12 mt-20 container">
                                <div class="row justify-content-center form-row">

                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Organization</label>
                                            <input type="text" name="organization_name[]" id="organization_name" placeholder="Enter Organization Name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Name Of Certificate</label>
                                            <input type="text" name="certificate_name[]" id="certificate_name" placeholder="Enter Name Of Certificate">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Field Name</label>
                                            <input type="text" name="certificate_area[]" id="certificate_area" placeholder="Enter Name Of Field">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Date Of Certification</label>
                                            <input type="date" name="certificate_date[]" id="certificate_date">
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 35px">
                                <a class="btn btn-sm btn-primary" id="addRowCertifeact"><i class="fa fa-plus"></i></a>
                                <a class="btn btn-sm btn-danger" id="deleteRowCertifeact"><i class="fa fa-minus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Linked Profile</h5>
                        </div>
                        <div class="row" id="dataAddprofile">
                            <div class="col-md-12 mt-20 container">
                                <div class="row justify-content-center form-row">
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Add Your Profile Link</label>
                                            <input type="text" name="profile_link[]" id="profile_link" placeholder="Social Profile Link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" style="margin-top: 35px">
                            <a class="btn btn-sm btn-primary" id="addRowPofile"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-sm btn-danger" id="deleteRowProfile"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>

                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Cv Upload</h5>
                        </div>
                        <div class="row" id="dataAddprofile">
                            <div class="col-md-12 mt-20 container">
                                <div class="row justify-content-center form-row">
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Upload Cv</label>
                                            <input type="file" name="cv" id="cv" placeholder="Enter Company Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center pt-10">
                        <div class="col-md-4">
                            <div class="single_form">
                                <button type="submit" class="main-btn btn-block">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <div class="post_form mt-50">
                        <div class="post_title">
                            <h5 class="title">Create Professional Profile</h5>
                        </div>
                        <div class="pro-image pt-20">
                            @if ($customer->image != null)
                            <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="" style="width:150px">
                            @else
                            <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                            @endif
                        </div>

                        <form action="" method="post" id="customer_profile_update">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-6 mt-20">
                                    <div class="post_title">
                                        <h5 class="title">Profile</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Professional Title</label>
                                            <input type="text" value="{{ $customer_professon->title }}" name="title" id="title" placeholder="Professional Title : Doctor, Lawyer, Engineer">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single_form">
                                            <label>Featured Degrees</label>
                                            <input type="text" value="{{ $customer_professon->degree }}" name="degree" id="degree" placeholder="Professional Degrees : BBA, BCom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 college-border mt-20">
                                    <div class="post_title">
                                        <h5 class="title">Details</h5>
                                    </div>
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Small Description About Yourself</label>
                                                <textarea type="text" name="details" id="details" rows="2"  placeholder="Enter A Small Description About Yourself" style="resize: none;" >{{ $customer_professon->details }}</textarea>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="language">
                                                <label for="">Language</label>
                                                <select data-placeholder="Select Skills" multiple class="chosen-select" name="language_name[]" id="skills">
                                                    <option value=""></option>
                                                    <option value="bangla">Bangla</option>
                                                    <option value="english">English</option>
                                                    <option value="hindi">Hindi</option>
                                                    <option value="urdu">Urdu</option>
                                                </select>
                                            </div>
                                            <hr>
                                            @if (!empty($customer_language))
                                                @foreach ($customer_language as $cl)
                                                <span class="text-danger">{{ $cl->language_name }}</span><br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <form action="" method="post" id="customer_skill_update">
                        @csrf
                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Skills</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-20">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="row justify-content-center">
                                                <div class="col-md-12">
                                                    <div class="single_form">
                                                        <select data-placeholder="Select Skills" multiple class="chosen-select" name="skills_name[]" id="skills">
                                                            <option value=""></option>
                                                            <option value="html">Html5</option>
                                                            <option value="css">CSS3</option>
                                                            <option value="sass">Sass</option>
                                                            <option value="php">PHP</option>
                                                            <option value="laravel">Laravel</option>
                                                            <option value="javascript">Javascript</option>
                                                            <option value="react">React</option>
                                                            <option value="angular">Angular</option>
                                                            <option value="vue">Vue</option>
                                                            <option value="mysql">MySql</option>
                                                            <option value="postgresql">Postgresql</option>
                                                            <option value="node">Node</option>
                                                            <option value="python">Python</option>
                                                            <option value="django">Django</option>
                                                            <option value="aws">Aws</option>
                                                            <option value="digitalocean">DigitalOcean</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @if(!empty($customer_skills))
                                                    @forelse ($customer_skills as $cs)
                                                    <span class="text-danger">
                                                        {{ $cs->skills_name }}
                                                        -
                                                        <a href="" class="skill_delete" rel="{{ $cs->id }}">Delete</a>
                                                    </span>
                                                    @empty
                                                    <span class="pro-skill-span">No Data Found</span>
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </form>
                   

                    <form action="" method="posy" id="customer_experience_update">
                        @csrf
                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Experience</h5>
                            </div>
                            <div class="row" id="dataAdd">
                                <div class="col-md-12 mt-20 container">
                                    <div class="row justify-content-center form-row">
                                        @forelse ($customer_work_exp as $cws)
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Workplace</label>
                                                <input type="text" value="{{ $cws->workplace_name }}" name="workplace_name[]" id="workplace_name_{{ $cws->id }}" rel1="{{ $cws->id }}" class="workplace_name" placeholder="Enter Company Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Position</label>
                                                <input type="text" value="{{ $cws->position  }}" name="position[]" id="position_{{ $cws->id }}" rel1="{{ $cws->id }}" class="workplace_name" placeholder="Enter Position Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Short Description Of Your Role</label>
                                                <textarea type="text" name="description_role[]" id="description_role_{{ $cws->id }}" rel1="{{ $cws->id }}" class="workplace_name" rows="2" placeholder="Describe Your Role In Short" style="resize: none;">{{ $cws->description_role }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date Of Joining</label>
                                                <input type="date" value="{{ $cws->join_date }}" id="join_date_{{ $cws->id }}" rel1="{{ $cws->id }}" name="join_date[]" class="workplace_name">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-40">
                                            <div class="single_form">
                                                <label>Date Of Leaving</label>
                                                <input type="date" value="{{ $cws->leave_date }}" id="leave_date_{{ $cws->id }}" rel1="{{ $cws->id }}" name="leave_date[]" class="workplace_name">
                                            </div>
                                        </div>
    
                                        <hr>
                                        @empty
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Workplace</label>
                                                <input type="text" name="workplace_name[]" id="workplace_name" placeholder="Enter Company Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Position</label>
                                                <input type="text" name="position[]" id="position" placeholder="Enter Position Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Short Description Of Your Role</label>
                                                <textarea type="text" name="description_role[]" rows="2" placeholder="Describe Your Role In Short" style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date Of Joining</label>
                                                <input type="date" name="join_date[]" id="join_date">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date Of Leaving</label>
                                                <input type="date" name="leave_date[]" id="leave_date">
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 35px">
                                <a class="btn btn-sm btn-primary" id="addRow"><i class="fa fa-plus"></i></a>
                                <a class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-minus"></i></a>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </form>
                    

                    <form action="" method="post" id="customer_education_update">
                        @csrf
                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Education</h5>
                            </div>
                            <div class="row" id="dataAddEducation">
                                <div class="col-md-12 mt-20 container">
                                    <div class="row justify-content-center form-row">
                                        @forelse ($customer_edu as $ce)
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Instution</label>
                                                <input type="text" value="{{ $ce->institution_name }}" rel2="{{ $ce->id }}" name="institution_name[]" id="institution_name_{{ $ce->id }}" class="education" placeholder="Enter School Name">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Certificate</label>
                                                <input type="text" value="{{ $ce->institution_certificate }}" rel2="{{ $ce->id }}" name="institution_certificate[]" id="institution_certificate_{{ $ce->id }}" class="education" placeholder="Enter Certificate Name : PSC/JSC/SSC">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date OF Graduation</label>
                                                <input type="date" value="{{ $ce->passing_year }}" rel2="{{ $ce->id }}" name="passing_year[]" id="passing_year_{{ $ce->id }}" class="education">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12 mb-40">
                                            <div class="single_form">
                                                <label>GPA</label>
                                                <input type="text" value="{{ $ce->result }}" rel2="{{ $ce->id }}" name="result[]" id="result_{{ $ce->id }}" placeholder="Enter GPA" class="education">
                                            </div>
                                        </div>
    
                                        <hr>
                                        @empty
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Instution</label>
                                                <input type="text" name="institution_name[]" rel2="{{ $ce->id }}" id="institution_name" placeholder="Enter School Name">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Certificate</label>
                                                <input type="text" name="institution_certificate[]" id="institution_certificate" placeholder="Enter Certificate Name : PSC/JSC/SSC">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date OF Graduation</label>
                                                <input type="date" name="passing_year[]" id="passing_year">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>GPA</label>
                                                <input type="text" name="result[]" id="result" placeholder="Enter GPA">
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
    
                                <div class="col-md-3" style="margin-top: 35px">
                                    <a class="btn btn-sm btn-primary" id="addRowEducation"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-sm btn-danger" id="deleteRowEducation"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </form>
                    

                    <form action="" method="post" id="customer_certificate_update">
                        @csrf
                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Certification</h5>
                            </div>
                            <div class="row" id="dataAddcertificate">
                                <div class="col-md-12 mt-20 container">
                                    <div class="row justify-content-center form-row">
                                        @forelse ($customer_certi as $cc)
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Organization</label>
                                                <input type="text" value="{{ $cc->organization_name }}" rel3="{{ $cc->id }}" class="certification" id="organization_name_{{ $cc->id }}" name="organization_name[]" placeholder="Enter Organization Name">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Certificate</label>
                                                <input type="text" value="{{ $cc->certificate_name }}" rel3="{{ $cc->id }}" class="certification" id="certificate_name_{{ $cc->id }}" name="certificate_name[]" placeholder="Enter Name Of Certificate">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Field Name</label>
                                                <input type="text" value="{{ $cc->certificate_area }}" rel3="{{ $cc->id }}" class="certification" id="certificate_area_{{ $cc->id }}" name="certificate_area[]" placeholder="Enter Name Of Field">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mb-40">
                                            <div class="single_form">
                                                <label>Date Of Certification</label>
                                                <input type="date" value="{{ $cc->certificate_date }}" rel3="{{ $cc->id }}" class="certification" id="certificate_date_{{ $cc->id }}" name="certificate_date[]">
                                            </div>
                                        </div>
    
                                        <hr>
                                        @empty
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Organization</label>
                                                <input type="text" name="organization_name[]" id="organization_name" placeholder="Enter Organization Name">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Name Of Certificate</label>
                                                <input type="text" name="certificate_name[]" id="certificate_name" placeholder="Enter Name Of Certificate">
                                            </div>
                                        </div>
    
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Field Name</label>
                                                <input type="text" name="certificate_area[]" id="certificate_area" placeholder="Enter Name Of Field">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Date Of Certification</label>
                                                <input type="date" name="certificate_date[]" id="certificate_date">
                                            </div>
                                        </div>
                                        @endforelse
                                        
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-top: 35px">
                                    <a class="btn btn-sm btn-primary" id="addRowCertifeact"><i class="fa fa-plus"></i></a>
                                    <a class="btn btn-sm btn-danger" id="deleteRowCertifeact"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </form>
                    

                    <form action="" method="post" id="customer_link_profile_update">
                        @csrf
                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Linked Profile</h5>
                            </div>
                            <div class="row" id="dataAddprofile">
                                <div class="col-md-12 mt-20 container">
                                    <div class="row justify-content-center form-row">
                                        @forelse ($customer_profile_link as $cpl)
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Add Your Profile Link</label>
                                                <input type="text" value="{{ $cpl->profile_link }}" rel4="{{ $cpl->id }}" name="profile_link[]" id="profile_link_{{  $cpl->id }}" class="customer_profile_link" placeholder="Social Profile Link">
                                            </div>
                                        </div>
                                        @empty
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Add Your Profile Link</label>
                                                <input type="text" name="profile_link[]" id="profile_link" placeholder="Social Profile Link">
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-3" style="margin-top: 35px">
                                <a class="btn btn-sm btn-primary" id="addRowPofile"><i class="fa fa-plus"></i></a>
                                <a class="btn btn-sm btn-danger" id="deleteRowProfile"><i class="fa fa-minus"></i></a>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </form>
                    

                    <form action="" method="post" id="customer_cv_update">
                        @csrf

                        <input type="hidden" name="customer_cv_id" id="customer_cv_id" value="{{ $customer_cv->id }}">

                        <div class="post_form mt-50">
                            <div class="post_title">
                                <h5 class="title">Cv Upload</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-20">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label>Upload Cv</label>
                                                <input type="file" name="cv" id="cv" placeholder="Enter Company Name">
                                            </div>
                                        </div>
    
                                        <br><br>
                                        @if (!empty($customer_cv))
                                        <a href="" target="_blank" style="margin-top:10px;margin-bottom: 1rem">
                                            <i class="fas fa-file-pdf" style="font-size: 5rem;"></i>
                                            <p style="font-size: 10px;">{{ $customer_cv->cv }}</p>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center pt-10">
                                <div class="col-md-4">
                                    <div class="single_form">
                                        <button type="submit" class="main-btn btn-block">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                @endif
            </div>
        </div>
    </div>
</section>
<br/>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#addRow").click(function(){

            var len=$('#dataAdd .container .form-row').length+1;
            console.log(len);

            $("#dataAdd .container:last").append(
                '<div class="row justify-content-center form-row">'+
                '<div class="col-md-12">'+
                    '<div class="single_form">'+
                        '<label>Name Of Workplace</label>'+
                        '<input type="text" name="workplace_name[]" id="workplace_name" placeholder="Enter Company Name">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="single_form">'+
                        '<label>Name Of Position</label>'+
                        '<input type="text" name="position[]" id="position" placeholder="Enter Position Name">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="single_form">'+
                        '<label>Short Description Of Your Role</label>'+
                        '<textarea type="text" name="description_role[]" id="description_role" rows="2" placeholder="Describe Your Role In Short" style="resize: none;"></textarea>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="single_form">'+
                        '<label>Date Of Joining</label>'+
                        '<input type="date" name="join_date[]" id="join_date">'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-12">'+
                    '<div class="single_form">'+
                        '<label>Date Of Leaving</label>'+
                        '<input type="date" name="leave_date[]" id="leave_date">'+
                    '</div>'+
                '</div>'+
                '</div>'
            );

        });
    });

    $("#deleteRow").click(function(){
        var len=$('#dataAdd .container .form-row').length;
        
        if(len>1){
            $("#dataAdd .container .form-row").last().remove();
        }else{
            alert('Not able to Delete');
        }
    });
</script>

<script>
    $(document).ready(function () {

        $("#addRowEducation").click(function(){

            var len=$('#dataAddEducation .container .form-row').length+1;

            $("#dataAddEducation .container:last").append(
                '<div class="row justify-content-center form-row">'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Name Of Instution</label>'+
                            '<input type="text" name="institution_name[]" id="institution_name" placeholder="Enter School Name">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Name Of Certificate</label>'+
                            '<input type="text" name="institution_certificate[]" id="institution_certificate" placeholder="Enter Certificate Name : PSC/JSC/SSC">'+
                        '</div>'+
                    '</div>'+
                    
                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Date OF Graduation</label>'+
                            '<input type="date" name="passing_year[]" id="passing_year">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>GPA</label>'+
                            '<input type="text" name="result[]" id="result" placeholder="Enter GPA">'+
                        '</div>'+
                    '</div>'+

                '<div>'
            );

        });
    });

    $("#deleteRowEducation").click(function(){
        var len=$('#dataAddEducation .container .form-row').length;
        
        if(len>1){
            $("#dataAddEducation .container .form-row").last().remove();
        }else{
            alert('Not able to Delete');
        }
    });
</script>

<script>
    $(document).ready(function () {

        $("#addRowCertifeact").click(function(){

            var len=$('#dataAddcertificate .container .form-row').length+1;

            $("#dataAddcertificate .container:last").append(
                '<div class="row justify-content-center form-row">'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Name Of Oragnaization</label>'+
                            '<input type="text" name="organization_name[]" id="organization_name" placeholder="Enter Organization Name">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Name Of Certificate</label>'+
                            '<input type="text" name="certificate_name[]" id="certificate_name" placeholder="Enter Name Of Certificate">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Field Name</label>'+
                            '<input type="text" name="certificate_area[]" id="certificate_area" placeholder="Enter Name Of Field">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Date Of Certification</label>'+
                            '<input type="date" name="certificate_date[]" id="certificate_date">'+
                        '</div>'+
                    '</div>'+

                '<div>'
            );

        });
    });

    $("#deleteRowCertifeact").click(function(){
        var len=$('#dataAddcertificate .container .form-row').length;
        
        if(len>1){
            $("#dataAddcertificate .container .form-row").last().remove();
        }else{
            alert('Not able to Delete');
        }
    });
</script>

<script>
    $(document).ready(function () {

        $("#addRowPofile").click(function(){

            var len=$('#dataAddprofile .container .form-row').length+1;

            $("#dataAddprofile .container:last").append(
                '<div class="row justify-content-center form-row">'+

                    '<div class="col-md-12">'+
                        '<div class="single_form">'+
                            '<label>Add Your Profile Link</label>'+
                            '<input type="text" name="profile_link[]" id="profile_link"  placeholder="Social Profile Link">'+
                        '</div>'+
                    '</div>'+

                '<div>'
            );

        });
    });

    $("#deleteRowProfile").click(function(){
        var len=$('#dataAddprofile .container .form-row').length;
        
        if(len>1){
            $("#dataAddprofile .container .form-row").last().remove();
        }else{
            alert('Not able to Delete');
        }
    });
</script>

<script>
     $(document).ready(function () {

        $("#customer_information_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#customer_information_post").get(0));

            $.ajax({
                url : "{{ route('customer_professonal.store') }}",
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

       $("#customer_profile_update").on("submit",function (e) {
           e.preventDefault();

           var formData = new FormData($("#customer_profile_update").get(0));

           $.ajax({
               url : "{{ route('customer_profile_update') }}",
               type: "post",
               data: formData,
               dataType: "json",

               contentType: false,
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

       $("#customer_skill_update").on("submit",function (e) {
           e.preventDefault();

           var formData = new FormData($("#customer_skill_update").get(0));

           $.ajax({
               url : "{{ route('customer_skill_update') }}",
               type: "post",
               data: formData,
               dataType: "json",

               contentType: false,
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
    $(document).ready(function(){

        var experience_id = [];
        var work_place_data = [];
        var position_data = [];
        var description_role = [];
        var join_date = [];
        var leave_date = [];

        $(".workplace_name").on("change", function(e){
            e.preventDefault();
            let id = $(this).attr('rel1');

            experience_id.push($(this).attr('rel1'));

            work_place_data.push($("#workplace_name_"+id).val());

            position_data.push($("#position_"+id).val());
            description_role.push($("#description_role_"+id).val());
            join_date.push($("#join_date_"+id).val());
            leave_date.push($("#leave_date_"+id).val());

        })

        $("#customer_experience_update").on("submit",function (e) {
           e.preventDefault();
          
           var new_experience_id = JSON.parse(JSON.stringify(experience_id));
           var new_work = JSON.parse(JSON.stringify(work_place_data));
           var new_position = JSON.parse(JSON.stringify(position_data));
           var new_description = JSON.parse(JSON.stringify(description_role));
           var new_join_date = JSON.parse(JSON.stringify(join_date));
           var new_leave_date = JSON.parse(JSON.stringify(leave_date));

           var workplace_name = [];
           var position = [];
           var description_role_single = [];
           var join_date_signle = [];
           var leave_date_signle = [];
           workplace_name.push($("#workplace_name").val());
           position.push($("#position").val());
           description_role_single.push($("#description_role").val());
           join_date_signle.push($("#join_date").val());
           leave_date_signle.push($("#leave_date").val());

           var get_workplace_name =  JSON.parse(JSON.stringify(workplace_name));
           var get_position =  JSON.parse(JSON.stringify(position));
           var get_description_role =  JSON.parse(JSON.stringify(description_role_single));
           var get_join_date =  JSON.parse(JSON.stringify(join_date_signle));
           var get_leave_date =  JSON.parse(JSON.stringify(leave_date_signle));

           let formData = new FormData();
           formData.append('new_experience_id', new_experience_id);
           formData.append('new_work', new_work);
           formData.append('new_position', new_position);
           formData.append('new_description', new_description);
           formData.append('new_join_date', new_join_date);
           formData.append('new_leave_date', new_leave_date);
           formData.append('get_workplace_name', get_workplace_name);
           formData.append('get_position', get_position);
           formData.append('get_description_role', get_description_role);
           formData.append('get_join_date', get_join_date);
           formData.append('get_leave_date', get_leave_date);

           $.ajax({
               url : "{{ route('customer_experience_update') }}",
               type: "post",
               data: formData,
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
               dataType: "json",
               contentType: false,
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
    $(document).ready(function(){

        var education_id = [];
        var institution_name = [];
        var institution_certificate = [];
        var passing_year = [];
        var result = [];

        $(".education").on("change", function(e){
            e.preventDefault();
            let id = $(this).attr('rel2');

            education_id.push($(this).attr('rel2'));

            institution_name.push($("#institution_name_"+id).val());

            institution_certificate.push($("#institution_certificate_"+id).val());
            passing_year.push($("#passing_year_"+id).val());
            result.push($("#result_"+id).val());

        })

        $("#customer_education_update").on("submit",function (e) {
            e.preventDefault();
            
            var new_education_id = JSON.parse(JSON.stringify(education_id));
            var new_institution_name = JSON.parse(JSON.stringify(institution_name));
            var new_institution_certificate = JSON.parse(JSON.stringify(institution_certificate));
            var new_passing_year = JSON.parse(JSON.stringify(passing_year));
            var new_result = JSON.parse(JSON.stringify(result));

            var institution_name_single = [];
            var institution_certificate_single = [];
            var passing_year_single = [];
            var result_single = [];

            institution_name_single.push($("#institution_name").val());
            institution_certificate_single.push($("#institution_certificate").val());
            passing_year_single.push($("#passing_year").val());
            result_single.push($("#result").val());

           var get_institution_name =  JSON.parse(JSON.stringify(institution_name_single));
           var get_institution_certificate =  JSON.parse(JSON.stringify(institution_certificate_single));
           var get_passing_year =  JSON.parse(JSON.stringify(passing_year_single));
           var get_result =  JSON.parse(JSON.stringify(result_single));

            let formData = new FormData();
            formData.append('new_education_id', new_education_id);
            formData.append('new_institution_name', new_institution_name);
            formData.append('new_institution_certificate', new_institution_certificate);
            formData.append('new_passing_year', new_passing_year);
            formData.append('new_result', new_result);
            formData.append('get_institution_name', get_institution_name);
            formData.append('get_institution_certificate', get_institution_certificate);
            formData.append('get_passing_year', get_passing_year);
            formData.append('get_result', get_result);

            $.ajax({
                url : "{{ route('customer_education_update') }}",
                type: "post",
                data: formData,
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                dataType: "json",
                contentType: false,
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
    $(document).ready(function(){

        var certification_id = [];
        var organization_name = [];
        var certificate_name = [];
        var certificate_area = [];
        var certificate_date = [];

        $(".certification").on("change", function(e){
            e.preventDefault();
            let id = $(this).attr('rel3');

            certification_id.push($(this).attr('rel3'));

            organization_name.push($("#organization_name_"+id).val());

            certificate_name.push($("#certificate_name_"+id).val());
            certificate_area.push($("#certificate_area_"+id).val());
            certificate_date.push($("#certificate_date_"+id).val());

        })

        $("#customer_certificate_update").on("submit",function (e) {
            e.preventDefault();
            
            var new_certification_id = JSON.parse(JSON.stringify(certification_id));
            var new_organization_name = JSON.parse(JSON.stringify(organization_name));
            var new_certificate_name = JSON.parse(JSON.stringify(certificate_name));
            var new_certificate_area = JSON.parse(JSON.stringify(certificate_area));
            var new_certificate_date = JSON.parse(JSON.stringify(certificate_date));

            var organization_name_single = [];
            var certificate_name_single = [];
            var certificate_area_single = [];
            var certificate_date_single = [];

            organization_name_single.push($("#organization_name").val());
            certificate_name_single.push($("#certificate_name").val());
            certificate_area_single.push($("#certificate_area").val());
            certificate_date_single.push($("#certificate_date").val());

            var get_organization_name =  JSON.parse(JSON.stringify(organization_name_single));
            var get_certificate_name =  JSON.parse(JSON.stringify(certificate_name_single));
            var get_certificate_area =  JSON.parse(JSON.stringify(certificate_area_single));
            var get_certificate_date =  JSON.parse(JSON.stringify(certificate_date_single));


            let formData = new FormData();
            formData.append('new_certification_id', new_certification_id);
            formData.append('new_organization_name', new_organization_name);
            formData.append('new_certificate_name', new_certificate_name);
            formData.append('new_certificate_area', new_certificate_area);
            formData.append('new_certificate_date', new_certificate_date);
            
            formData.append('get_organization_name', get_organization_name);
            formData.append('get_certificate_name', get_certificate_name);
            formData.append('get_certificate_area', get_certificate_area);
            formData.append('get_certificate_date', get_certificate_date);

            $.ajax({
                url : "{{ route('customer_certification_update') }}",
                type: "post",
                data: formData,
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                dataType: "json",
                contentType: false,
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
    $(document).ready(function(){

        $("#customer_cv_update").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData($("#customer_cv_update").get(0));
            
            $.ajax({
                url : "{{ route('customer_cv_update') }}",
                type: "post",
                data: formData,
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                dataType: "json",
                contentType: false,
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
    $(document).ready(function(){

        var link_id = [];
        var data_link = [];

        $(".customer_profile_link").on("change", function(e){
            e.preventDefault();

            let id = $(this).attr('rel4');

            link_id.push($(this).attr('rel4'));
            data_link.push($("#profile_link_"+id).val());
        })

        $("#customer_link_profile_update").on("submit",function (e) {
           e.preventDefault();

           var new_profile = JSON.parse(JSON.stringify(data_link));
           var new_link_id = JSON.parse(JSON.stringify(link_id));

           var profile_link = [];
           profile_link.push($("#profile_link").val());

           var get_proifle_link =  JSON.parse(JSON.stringify(profile_link));

            let formData = new FormData();
            formData.append('new_profile', new_profile);
            formData.append('new_link_id', new_link_id);
            formData.append('get_proifle_link', get_proifle_link);

           
           console.log(new_profile);

           $.ajax({
               url : "{{ route('customer_link_update') }}",
               type: "post",
               data: formData,
               headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
               dataType: "json",
               contentType: false,
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
    $(document).on('click','.skill_delete', function(e){
        e.preventDefault();
        
        var id = $(this).attr('rel');
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('customer_professonal.skill_delete','') }}/"+id,
            data: {id:id},
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

                location.reload(true)
            }
        });
    });
</script>
@endpush