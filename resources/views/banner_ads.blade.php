@extends('layouts.front.master')

@section('page')
    Banner Ads
@endsection

@push('css')
<style>
    .banner-ad-title {
        position: relative;
        padding-bottom: 10px;
    }

    .ad-product-title {
        position: relative;
        padding-bottom: 10px;
    }

    .ad-product-title::before{
        position: absolute;
        content: "";
        background-color: #ff4367;
        width: 10%;
        height: 1px;
        bottom: 0;
        left: 45%;
    }

    .mt-40 {
        margin-top: 40px;
    }

    .text-center {
        text-align: center !important;
    }

    .ad-products-box {
        border: 1px solid #ff4367;
        border-radius: 7px;
        margin-left: 10px!important;
        margin-right: 10px!important;
    }

    .banner-ads-wrapper {
    background-color: white;
    border-radius: 7px;
}

.banner-ads-wrapper .advertising-banner-title {
    font-size: 22px;
    color: #ff4367;
    padding-bottom: 10px;
    border-bottom: 1px solid #333333;
}
</style>
@endpush

@section('content')
<div class="banner-ads" id="banner-ads">
    <div class="container">
        <h2 class="text-center mt-40 banner-ad-title">Our Banner Ad Packages</h2>
        <div class="banner-ads-wrapper mt-20 mb-40 pt-30 pb-30">
            <p class="ml-15 mr-15 advertising-banner-title">Our Advertising Products</p>
            <h4 class="mt-40 text-center ad-product-title"> Leader Board </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-6 banner-product-details mb-4">
                    <p class="pt-10 pl-15"> In this type of banner design the ad banner is strategically placed right above the navigation bar on mobile and below on desktop. the leader board is butte literally by every visitor on the site. A great choice for building brand awareness for everyone or in any specific categories.</p>
                </div>
                <div class="col-sm-5">
                    <img class="img-fluid" src="{{asset("frontend/assets/images/leader-board.png")}}" />
                </div>
            </div>
            <h4 class="mt-60 text-center ad-product-title"> Sky Scraper </h4>
            <div class="row mt-20 banner-product-wrapper justify-content-around ad-products-box pt-20 pb-20">
                <div class="col-sm-5">
                    <img class="img-fluid" src="{{asset("frontend/assets/images/sky-scraper.png")}}" />
                </div>
                <div class="col-sm-6 banner-product-details">
                    <p class="pt-10 pl-15 mb-4">
                        If you are thinking about advertisement with minimum cost then skyscraper banner Ad is for you. Skyscraper is cost effective with placement on our search result page with high reach. A good option for brand building.
                    </p>
                </div>
            </div>
            <h4 class="mt-60 text-center ad-product-title"> Base Line </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-6 banner-product-details">
                    <p class="pt-10 pl-15">
                        This type of banner Add has double the height compare it to the leaderboard and is placed just before paging pagination links on each search results page it is viewed by almost everyone.
                    </p>
                </div>
                <div class="col-sm-5">
                    <img class="img-fluid" src="{{asset("frontend/assets/images/bottom-border.png")}}" />
                </div>
            </div>
            <h4 class="mt-60 text-center ad-product-title"> Featured Box </h4>
            <div class="row mt-20 banner-product-wrapper justify-content-around ad-products-box pt-20 pb-20">
                <div class="col-sm-5">
                    <img class="img-fluid" src="{{asset("frontend/assets/images/bottom-border.png")}}" />
                </div>
                <div class="col-sm-6 banner-product-details">
                    <p class="pt-10 pl-15">
                        This type of banner Ad is an optimal placement on each of our Ad pages .This is one of the most effective way to reach a specific target audience when they are reading about the Ad.
                    </p>
                </div>
            </div>
            <h3 class="text-center mt-60"> To know more or post an ad </h3>
            <h5 class="text-center mt-20"> <i class="fal fa-envelope"></i>  Dummy@email.com</h5>
        </div>
    </div>
</div>
@endsection

@push('js')
    
@endpush