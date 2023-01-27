@extends('layouts.front.master')

@section('page')
    Category Job List
@endsection

@push('css')
<style>
    .img_company {
        float: right;
        margin-top: -163px;
    }

    .job_deadline {
        float: right;
    }

    .header_content {
        position: relative;
        z-index: 5;
        padding-top: 120px;
        padding-bottom: 130px;
    }
</style>
@endpush

@section('content')
<section class="product_page pt-70 pb-120" id="job">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="top-content">
                    <div class="row justify-content-around">
                        <div class="col-lg-3 col-md-5 product-search-button pb-3">
                            <div class="dropdown">
                                <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-map-marker-alt drop-image"></i> &nbsp;<span>Location</span>
                                </button>
                                <ul class="dropdown-menu location-sort-ul" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="#">Barishal</a></li>
                                    <li><a class="dropdown-item" href="#">Chittagong</a></li>
                                    <li><a class="dropdown-item" href="#">Mymensingh</a></li>
                                    <li><a class="dropdown-item" href="#">Khulna</a></li>
                                    <li><a class="dropdown-item" href="#">Rajshahi</a></li>
                                    <li><a class="dropdown-item" href="#">Rangpur</a></li>
                                    <li><a class="dropdown-item" href="#">Sylhet</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 product-search-button pb-3">
                            <div class="dropdown">
                                <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-tags drop-image"></i> &nbsp;<span>Select Category</span>
                                </button>
                                <ul class="dropdown-menu location-sort-ul" aria-labelledby="dropdownMenuButton3">
                                    <li><a class="dropdown-item" href="#">Electronics</a></li>
                                    <li><a class="dropdown-item" href="#">Mobile</a></li>
                                    <li><a class="dropdown-item" href="#">Home & Living</a></li>
                                    <li><a class="dropdown-item" href="#">Transportation</a></li>
                                    <li><a class="dropdown-item" href="#">Pet & Animals</a></li>
                                    <li><a class="dropdown-item" href="#">Property</a></li>
                                    <li><a class="dropdown-item" href="#">Fashion & Beauty</a></li>
                                    <li><a class="dropdown-item" href="#">Hobby,Sports & Baby</a></li>
                                    <li><a class="dropdown-item" href="#">Daily Needs & Grocery</a></li>
                                    <li><a class="dropdown-item" href="#">Factory & Industry</a></li>
                                    <li><a class="dropdown-item" href="#">Education</a></li>
                                    <li><a class="dropdown-item" href="#">Job</a></li>
                                    <li><a class="dropdown-item" href="#">Services</a></li>
                                    <li><a class="dropdown-item" href="#">Agricultural Products</a></li>
                                    <li><a class="dropdown-item" href="#">Foreign Jobs</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <form class="d-flex">
                                <input class="form-control me-2 product-top-search" type="search" placeholder="What Are You Looking For" aria-label="Search">
                                <button class="btn btn-outline-search" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="product_sidebar pt-3">
                    <div class="sidebar_price_range mt-30">
                        <div class="sidebar_title">
                            <h5 class="title">Filters</h5>
                        </div>
                        <div class="price_range_content">
                            <div class="dropdown pt-10">
                                <p class="pb-1 filter-heading">Category :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="districtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>All Category</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="districtDropdown">
                                    @forelse ( $job_category as $jc)
                                    <li><a class="dropdown-item" href="#">{{ $jc->name }}</a></li>
                                    @empty
                                    <li>No Data Found</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="dropdown pt-10">
                                <p class="pb-1 filter-heading">Industry :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="districtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Any</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="districtDropdown">
                                    <li><a class="dropdown-item" href="#">Government</a></li>
                                    <li><a class="dropdown-item" href="#">Semi Government</a></li>
                                    <li><a class="dropdown-item" href="#">NGO</a></li>
                                    <li><a class="dropdown-item" href="#">Agro based Industry</a></li>
                                    <li><a class="dropdown-item" href="#">Airline/ Travel/ Tourism</a></li>
                                    <li><a class="dropdown-item" href="#">Architecture/ Engineering</a></li>
                                    <li><a class="dropdown-item" href="#">Education</a></li>
                                    <li><a class="dropdown-item" href="#">Software</a></li>
                                </ul>
                            </div>
                            <div class="dropdown pt-10 pb-10">
                                <p class="pb-1 filter-heading">Zones :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Zone</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="cityDropdown">
                                    <li><a class="dropdown-item" href="#">Azimpur</a></li>
                                    <li><a class="dropdown-item" href="#">Banasree</a></li>
                                    <li><a class="dropdown-item" href="#">Basundhara R/A</a></li>
                                    <li><a class="dropdown-item" href="#">Cantonment</a></li>
                                    <li><a class="dropdown-item" href="#">Demra</a></li>
                                    <li><a class="dropdown-item" href="#">Dhanmondi</a></li>
                                    <li><a class="dropdown-item" href="#">Gulshan</a></li>
                                    <li><a class="dropdown-item" href="#">Gabtoli</a></li>
                                    <li><a class="dropdown-item" href="#">Jatrabari</a></li>
                                    <li><a class="dropdown-item" href="#">Khilgaon</a></li>
                                    <li><a class="dropdown-item" href="#">Mirpur</a></li>
                                    <li><a class="dropdown-item" href="#">Mohakhali</a></li>
                                    <li><a class="dropdown-item" href="#">Mohammadpur</a></li>
                                    <li><a class="dropdown-item" href="#">Motijheel</a></li>
                                    <li><a class="dropdown-item" href="#">Mugda</a></li>
                                    <li><a class="dropdown-item" href="#">Puran Dhaka</a></li>
                                    <li><a class="dropdown-item" href="#">Uttara</a></li>
                                </ul>
                            </div>
                            <div class="dropdown pt-10 pb-10">
                                <p class="pb-1 filter-heading">Posted within :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Any</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="cityDropdown">
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">Last 2 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 3 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 4 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 5 days</a></li>
                                </ul>
                            </div>
                            <div class="dropdown pt-10 pb-10">
                                <p class="pb-1 filter-heading">Deadline :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Any</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="cityDropdown">
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">Tomorrow</a></li>
                                    <li><a class="dropdown-item" href="#">Last 2 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 3 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 4 days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 5 days</a></li>
                                </ul>
                            </div>
                            <div class="dropdown pt-10 pb-10">
                                <p class="pb-1 filter-heading">Newspaper Job :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Select One</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="cityDropdown">
                                    <li><a class="dropdown-item" href="#">The Daily Prothom Alo</a></li>
                                    <li><a class="dropdown-item" href="#">The Daily Ittefaq</a></li>
                                    <li><a class="dropdown-item" href="#">The Daily Observer</a></li>
                                    <li><a class="dropdown-item" href="#">The Daily Janakantha</a></li>
                                    <li><a class="dropdown-item" href="#">The Daily Independent</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-9">
                <div class="tab-content pt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="product_list">
                            @forelse ($jobs as $job)
                            <div class="single_ads_card ads_list d-sm-flex mt-30">
                                <div class="ads_card_content media-body single_ads_card_height">
                                    <div class="d-flex justify-content-between">
                                        <h5><a href="{{ route('front.job_details','') }}/{{ $job->id }}">{{ $job->position }}</a></h5>
                                    </div>
                                    <p><a href="{{ route('front.job_details','') }}/{{ $job->id }}">{{ $job->company_name }}</a></p>
                                    <p><i class="far fa-map-marker-alt"></i>{{ $job->location }}, Bangladesh</p>
                                    <p><i class="fa fa-graduation-cap"></i>{{ $job->qualification }}</p>
                                    <p>{!! Str::words($job->company_description, 35) !!}</p>
                                    <p><i class="fa fa-briefcase"></i>{{ $job->experience }}</p>
                                    <div class="img_company">
                                        <a href=""><img src="{{asset('assets/admin/uploads/job/small/'.$job->image)}}" alt=""></a>
                                    </div>
                                    <div class="job_deadline">
                                        <span>{{ \Carbon\Carbon::parse($job->end_date)->format('j F, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="single_ads_card ads_list d-sm-flex mt-30">
                                No Data Found
                            </div>
                            @endforelse
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 pt-10">
                <div class="pagination_wrapper mt-50">
                    <ul class="pagination justify-content-center">
                        {{ $jobs->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
@endsection

@push('js')
    
@endpush