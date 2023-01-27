<header class="header_area">
    <div class="header_navbar navbar_position">
        <div class="container">
            <div class="nav">
                <input type="checkbox" id="nav-check">
                <div class="nav-btn">
                    <label for="nav-check">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                </div>
                <div class="nav-header">
                    <a class="navbar-brand" href="{{ route('front') }}"> <img src="{{asset('frontend/assets/images/public_market.png')}}" alt="logo" style="width: 100px"> </a>
                </div>
                <div class="nav-links">
                    <ul>
                        <li><a href="{{ route('front') }}" class="active">Home <span class="line"></span></a></li>
                        <li><a href="{{ route('front.all_category') }}">Categories<i class="fa fa-angle-down navicon"></i></a>
                            <ul class="sub-menu1">
                                @foreach ($all_category as $ac)
                                <li>
                                    <a href="{{ route('front.category_ads','') }}/{{ $ac->id }}">
                                        <img src="{{ asset('assets/admin/uploads/category/small/'.$ac->image) }}" alt="" style="width: 20px" height="20px">
                                        &nbsp;{{ ucfirst($ac->name) }}
                                    </a>
                                </li>
                                @endforeach
                                
                            </ul>
                        </li>
                        <li><a href="{{ route('front.all_tvc') }}">TVC<i class="fa fa-angle-down navicon"></i></a>
                            <ul class="sub-menu2">
                                @if(Auth::guard('customer')->check())
                                <li><a href="{{ route('customer_tvc.create') }}"><i class="fal fa-upload"></i>&nbsp;Upload TVC</a></li>
                                @else
                                <li><a href="{{ route('customer_login') }}"><i class="fal fa-upload"></i>&nbsp;Upload TVC</a></li>
                                @endif
                                <li><a href="{{ route('front.all_tvc') }}"><i class="fal fa-tv-retro"></i>&nbsp;TVC Videos</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('front.all_job') }}">Job Bank<i class="fa fa-angle-down navicon"></i></a>
                            <ul class="sub-menu2">
                                @if(Auth::guard('customer')->check())
                                <li><a href="{{ route('customer_cv_upload.create') }}"><i class="fal fa-copy"></i>&nbsp;Cv Upload</a></li>
                                @else
                                <li><a href="{{ route('customer_login') }}"><i class="fal fa-upload"></i>&nbsp;Cv Upload</a></li>
                                @endif
                                
                                 @if(Auth::guard('customer')->check())
                                <li><a href="{{ route('customer_job.create') }}"><i class="fal fa-bullhorn"></i>&nbsp;Vacancy Announcement</a></li>
                                @else
                                <li><a href="{{ route('customer_login') }}"><i class="fal fa-upload"></i>&nbsp;Vacancy Announcement</a></li>
                                @endif

                                @if (Auth::guard('customer')->check())
                                <li><a href="{{ route('customer_job.cv_bank') }}"><i class="fal fa-user-tie"></i>&nbsp;Cv Bank</a></li>
                                @else
                                <li><a href="{{ route('customer_login') }}"><i class="fal fa-user-tie"></i>&nbsp;Cv Bank</a></li>
                                @endif

                                <li><a href="{{ route('front.job_category_list') }}"><i class="fal fa-user-tie"></i>&nbsp;Job Category</a></li>
                                <li><a href="{{ route('front.all_job') }}"><i class="fal fa-briefcase"></i>&nbsp;Jobs</a></li>
                            </ul>
                        </li>
                        @if (Auth::guard('customer')->user())
                        <li class="loginlist"><a href="{{ route('customer_dashboard') }}"><i class="fas fa-user navusericon"></i>Profile</a></li>
                        @else
                        <li class="loginlist"><a href="{{ route('customer_login') }}"><i class="fas fa-user navusericon"></i>Login</a></li>
                        @endif
                        <li><a href="#" class="dddddd">বাংলা</a></li>
                        <li>
                            <div class="row restricted-li">
                                <div class="col-12">
                                    <a class="view-count" href="#"><span class="line"></span> <i class="fas fa-eye show"></i>{{ isset($total_views) ? $total_views : '' }}</a>
                                </div>
                                <div class="col-12">
                                    <a class="ad-count" href=""><span class="line"></span> <i class="fas fa-ad show"></i> {{ $ads_count }}</a>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="navbar_btn">
                    <ul>
                        <li><a class="sign-up invi-button" href="#">বাংলা</a></li>
                        <li><a class="sign-up invi-button" href="{{ route('front.all_ads') }}">All Ads</a></li>
                        <li><button type="button" class="sign-up no-border"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">Post Ads</button></li>
                    </ul>
                </div>

                <div class="right_menu_mobile">
                    <ul>
                        <li><a href="{{ route('customer_login') }}"><i class="fas fa-user"></i></a></li>
                        <li><a class="view-count" href="#"><span class="line"></span> <i class="fas fa-eye show"></i> 20M</a></li>
                        <li><a class="view-count" href=""><span class="line"></span> <i class="fas fa-ad show"></i> {{ $ads_count }}</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    @if (Request::routeIs('front'))  
     <div class="header_content">
      <div class="container">
          <div class="row">
              <div class="col-lg-10">
                  <div class="row justify-content-around">
                      <div class="col-lg-7">
                          <div class="content_wrapper">
                              <h3 class="title">Welcome to PublicMarket</h3>
                              <p>Buy And Sell Everything From Used Cars To Mobile Phones And Computers, Or Search For Property, Jobs And More.Bringing All Of These To Your Fingertips Is PublicMarket.The Way Toward Buying And Selling Is Only One Click Away</p>
                          </div>
                      </div>
                      <div class="col-lg-4">
                          <video class="auto-tv" muted autoplay controls>
                              <source src="{{asset('assets/admin/uploads/auto_tv/'.$auto_tv->video)}}" type="video/mp4">
                              Your browser does not support HTML video.
                          </video>
                      </div>
                  </div>
              </div>
          </div>

          <div class="header_search">
            <form action="{{ route('search') }}" id="search_post">
            
             <div class="search_wrapper d-flex flex-wrap">
              <div class="search_column d-flex flex-wrap">

                <div class="search_select dropdown mt-15">
                    <select style="height: 50px" name="division_id" id="division_id" class="form-control">
                        <option value="">Select Division</option>
                        @forelse ($all_division as $ad)
                            <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                        @empty
                            <option value="">No Data Found</option>
                        @endforelse
                    </select>
                </div>

                <div class="search_select mt-15 dropdown">
                    <select style="height: 50px" name="category_id" id="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @forelse ($all_category as $ac)
                            <option value="{{ $ac->id }}">{{ $ac->name }}</option>
                        @empty
                            <option value="">No Data Found</option>
                        @endforelse
                    </select>
                </div>
              </div>
              <div class="search_column d-flex flex-wrap">
               <div class="search_form mt-15">
                <input class="search" name="search" id="search" type="text" placeholder="Type Your Keyword"> <i class="far fa-i-cursor drop-image"></i> </div>
               <div class="search_btn mt-15">
                <button type="submit" class="main-btn">Search</button>
               </div>
              </div>
             </div>
            </form>
            <div class="header_keyword d-sm-flex"> <span class="title">Trending Keywords:</span>
             <ul class="tags media-body">
              <li><a href="#">Camera</a></li>
              <li><a href="#">Mobile</a></li>
              <li><a href="#">DSLR</a></li>
              <li><a href="#">Packet</a></li>
              <li><a href="#">Dress</a></li>
              <li><a href="#">Shirt</a></li>
              <li><a href="#">Pant</a></li>
              <li><a href="#">Shoe</a></li>
              <li><a href="#">Table</a></li>
             </ul>
            </div>
           </div>
      </div>
    </div>
     @endif

     @if (Request::routeIs('front.all_category'))
     <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">All Categories</h3>
                        <p>We Have A Diverse Collection Of Products Arranged In Neat Categories For Your Accessibility.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#">Categories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif

     @if (Request::routeIs('front.category_ads','category_search','price_range'))
        <div class="ad-container container mt-80" >
            <img class="img-fluid" style="margin-top: 5px" src="{{ asset('frontend/assets/images/ad-background.jpg') }}">
        </div>
     @endif

     @if (Request::routeIs('front.sub_category_ads','sub_category_search','sub_category_price_range'))
        <div class="ad-container container mt-80" >
            <img class="img-fluid" style="margin-top: 5px" src="{{ asset('frontend/assets/images/ad-background.jpg') }}">
        </div>
     @endif

     @if (Request::routeIs('front.all_ads','ads_search','ads_price_range'))
        <div class="ad-container container mt-80">
            <img class="img-fluid" style="margin-top: 5px" src="{{asset('frontend/assets/images/ad-background.jpg')}}" />
        </div>
        <div class="container doorstep-banner mt-40">
                <div class="row">
                    <div class="col-sm-8">
                    <h4 class="text-center"><i class="fas fa-truck-container"></i>  View All The Ads With Doorstep Delivery Perks</h4>
                    </div>
                    <div class="col-sm-3">
                        <a href="">
                            <button class="btn main-btn btn-block">
                                View All
                            </button>
                        </a>
                    </div>
                </div>
        </div>
     @endif

     @if (Request::routeIs('front.all_tvc'))
     <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">All Television Commercials</h3>
                        <p>All Our Commercials In One Place. Take A Look At Regarding Anything You Want</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#tvc">Commercials</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif

     @if (Request::routeIs('front.all_location'))
     <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">All Location</h3>
                        <p>We Are Currently Accessible As Reliable Classified Platform In All Of The Divisions.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#location">Locations</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif

     @if (Request::routeIs('front.all_district'))
     <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">All Districts Of {{ $division->name }}</h3>
                        <p>We Are Available In All Of The Major Cities And Districts In {{ $division->name }}.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#district">Districts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif

    @if (Request::routeIs('front.division_ads'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">{{ $division->name }}</h3>
                        <p>We Have Collected All The Ads Inside {{ $division->name }} City In One Place. Find All The Ads According To Your Location</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="{{ route('front.all_ads') }}">All Ads</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.district_ads'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">{{ $district->name }}</h3>
                        <p>We Have Collected All The Ads Inside {{ $district->name }} City In One Place. Find All The Ads According To Your Location</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="{{ route('front.all_ads') }}">All Ads</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.job_category_list'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Job category</h3>
                        <p>Here user can find their desire jobs by through of job category</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="">See All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.all_job','job_search'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">All Job</h3>
                        <p>Here you can find your desire jobs and all spceifications.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#job">See All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.job_list'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">{{ $single_job_category->name }}</h3>
                        <p>Here you can find your desire jobs and all spceifications.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#job">See All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.strategy'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Our Strategy</h3>
                        <p> We Believe In Transparency And That Is Why We're Completely Open About Our Strategy. So That You As A Customer Can Easily Learn About Us As A Company. And See That We're Someone Trustable. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#strategy">Our Strategy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.mission_vission'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Mission & Vision</h3>
                        <p> Our Mission Is To Provide An Unparalleled Service To Our Customers Paired With Trust And Reliability. Enjoy A Marketplace Experience Like None Other. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#mission">Our Mission</a></li>
                            <li><a class="main-btn main-btn-2" href="#vision">Our Vision</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.management'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Our Team</h3>
                        <p> We Have An Impressive Ensemble Of Employees , That Ensure Your Every Demand Is Filled. We Are Always Hard At Work To Make Your Every Experience Better. Get To Know Us Better  </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#teams">Know Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.selling_tips'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Selling Tips</h3>
                        <p> Below are some tips on how to post ads that attract a lot of buyer interest. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#SellingTips">Selling Tips</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.buy_sell_quick_tip'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Buy & Sell Quickly Tips</h3>
                        <p> Ads with detailed information gets more views and try to include all the possible keywords and information that buyers will be interested in it is wise to be honest while providing the product details. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#BuySellQuickly">Buy & Sell Quickly</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.pricing_tips'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Pricing Tips</h3>
                        <p> Ads with detailed information gets more views and try to include all the possible keywords and information that buyers will be interested in it is wise to be honest while providing the product details. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#PricingTips">Pricing Tips</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.banner_ads'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Banner Ads</h3>
                        <p>
                            Make Your Ad Stand Out By Making It A Banner Ad. Banner Ad Will Show Up In Different Sections Of Our Platform Which Will Attract The Most Number Customers.
                        </p>
                        <ul class="header_btn">
                            <li><a class="main-btn button-margin" href="#banner-ads">Banner Ads</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.promote_ads'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Professional Help</h3>
                        <p>Make your advertising stand out on Public Market, Bangladesh's largest marketplace, to sell your products quickly and for the greatest price! While posting advertising on Public Market is free, Ad Promotions is a premium service that helps you receive more answers to your ads and sell faster.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#ProfessionalHelp">Professional Help</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.contact_us'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Contact Us</h3>
                        <p> We Are Here For You To Provide You With The Best Possible Service. Let Us know All Of Your Complements And Complaints </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#contact">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.privacy_policy'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Privacy Policy</h3>
                        <p>All together for the site to give a sheltered and valuable administration, it is essential for publicmarket.com to gather, utilize, and share individual data</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#privacypolicy">See Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.terms_conditions'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Term & Condition</h3>
                        <p>publicmarket.com is a service provided by Saltside Technologies AB (subject to your compliance with the Terms and Conditions set forth below). Please read these Terms and Conditions before using this Web Site.</p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#termcondition">See Term & Condition</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.safe'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">How To Stay Safe</h3>
                        <p> Your Safety Is Our Priority And We Regularly Take Steps To Ensure Your Most Secure Usage Experience. But Fraudulent Activity Can't be Completely Blocked. So We Have Assorted Some Steps For Your Own Safety. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#safe">How To Stay Safe</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.faq'))
    <div class="header_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">FAQ</h3>
                        <p> We Have Assorted Some Frequently Asked Questions And Answered Them. If You Have Any Question
                            Have A Look We Might've Already Answered It. </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#faq">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Request::routeIs('front.sitemap'))
    <div class="header_content" >
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content_wrapper">
                        <h3 class="title">Site Map</h3>
                        <p> We Present You With A Complete And Convenient Overview Of Our WebSite. We Have Gathered Every Link To Our Website So That You Can Have A Reference And Find WHAT YOU WAnt Easily.  </p>
                        <ul class="header_btn">
                            <li><a class="main-btn" href="#overview">Overview</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
  </header>

