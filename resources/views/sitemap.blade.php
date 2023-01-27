@extends('layouts.front.master')

@section('page')
    SiteMap
@endsection

@push('css')
    
@endpush

@section('content')
<section class="blog_details_page pt-70 pb-120 pb-30" id="overview">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-sm-6 col-md-6 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">Home</h5>
                            <ul class="link">
                                <li><a href="{{ route('front.all_category') }}"><i class="fal fa-list-ul"></i>&nbsp; Category</a></li>
                                <li><a href="{{ route('front.all_tvc') }}"><i class="fal fa-sticky-note"></i>&nbsp; Tvc</a></li>
                                <li><a href="{{ route('front.all_ads') }}"><i class="fab fa-hotjar"></i>&nbsp; Popular Published Ads</a></li>
                                <li><a href="{{ route('front.all_ads') }}"><i class="fal fa-history"></i>&nbsp; Recently Published Ads </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">Locations</h5>
                            <ul class="link">
                                @forelse ($divisions as $division)
                                <li><a href="{{ route('front.division_ads','') }}/{{ $division->id }}"><i class="fal fa-map-marker-alt drop-image"></i>&nbsp; {{ $division->name }}</a></li>
                                @empty
                                    <p>No Data Found</p>
                                @endforelse
                                
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-7 col-sm-8 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">My Account</h5>
                            <ul class="link">
                                <li><a href="{{ route('customer_dashboard') }}"><i class="fal fa-tachometer-alt-average"></i>&nbsp; Dashboard</a></li>
                                <li><a href=""><i class="fal fa-cog"></i>&nbsp; Profile Settings</a></li>
                                <li><a href=""><i class="fal fa-layer-group"></i>&nbsp; My Ads</a></li>
                                <li><a href=""><i class="fal fa-envelope"></i>&nbsp; Messages</a></li>
                                <li><a href=""><i class="fal fa-wallet"></i>&nbsp; Payments</a></li>
                                <li><a href=""><i class="fal fa-heart"></i>&nbsp; My Favourites</a></li>
                                <li><a href=""><i class="fal fa-star"></i>&nbsp; Privacy Settings</a></li>
                                <li><a href="{{ route('customer_login') }}"><i class="fal fa-sign-out"></i>&nbsp; Sign In</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-7 col-sm-8 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">Categories</h5>
                            <ul class="link">
                                @forelse ($all_category as $ac)
                                <li><a href="{{ route('front.category_ads','') }}/{{ $ac->id }}"><img src="{{ asset('assets/admin/uploads/category/small/'.$ac->image) }}" alt="" style="width: 15px">&nbsp; {{ ucfirst($ac->name) }}</a></li>
                                @empty
                                    <p>No Data Found</p>
                                @endforelse

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-md-6 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">Quick Links</h5>
                            <ul class="link">
                                <li><a href="{{ route('front.strategy') }}"><i class="lni lni-blackboard"></i>&nbsp; Strategy</a></li>
                                <li><a href="{{ route('front.mission_vission') }}"><i class="lni lni-target"></i>&nbsp; Mission & Vision</a></li>
                                <li><a href="{{ route('front.management') }}"><i class="fal fa-user-friends"></i>&nbsp; Our Team</a></li>
                                <li><a href="{{ route('front.selling_tips') }}"><i class="far fa-lightbulb-on"></i>&nbsp; Selling Tips</a></li>
                                <li><a href="{{ route('front.buy_sell_quick_tip') }}"><i class="fal fa-shipping-fast"></i>&nbsp; Buy & Sell Quickly</a></li>
                                <li><a href="{{ route('front.pricing_tips') }}"><i class="fal fa-tags"></i>&nbsp; Pricing Tips</a></li>
                                <li><a href="{{ route('front.banner_ads') }}"><i class="fal fa-sign"></i>&nbsp; Banner Ads</a></li>
                                <li><a href="{{ route('front.promote_ads') }}"><i class="fal fa-ad"></i>&nbsp; Promote Ads</a></li>
                                <li><a href="{{ route('front.terms_conditions') }}"><i class="fal fa-file-contract"></i>&nbsp; Terms Of Service</a></li>
                                <li><a href="{{ route('front.privacy_policy') }}"><i class="fal fa-user-secret"></i>&nbsp; Privacy Policy</a></li>
                                <li><a href="{{ route('front.faq') }}"><i class="fal fa-question-square"></i>&nbsp; FAQ</a></li>
                                <li><a href="{{ route('front.safe') }}"><i class="fal fa-exclamation-triangle"></i>&nbsp; How To Stay Safe</a></li>
                                <li><a href="{{ route('front.contact_us') }}"><i class="fal fa-mail-bulk"></i>&nbsp; Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 border mt-30 mb-30 site_map">
                        <div class="footer_link">
                            <h5 class="site_map_title">Post Ad</h5>
                            <ul class="link">
                                @forelse ($all_category as $ac)
                                <li><a href="{{ route('front.category_ads','') }}/{{ $ac->id }}"><img src="{{ asset('assets/admin/uploads/category/small/'.$ac->image) }}" alt="" style="width: 15px">&nbsp; {{ ucfirst($ac->name) }}</a></li>
                                @empty
                                    <p>No Data Found</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<br />
@endsection

@push('js')
    
@endpush