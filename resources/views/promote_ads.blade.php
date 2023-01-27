@extends('layouts.front.master')

@section('page')
    Promote Ads
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
</style>
@endpush

@section('content')
<section class="blog_details_page pt-70 pb-120 pb-30" id="ProfessionalHelp">
    <div class="container">
        <h2 class="text-center mt-40 banner-ad-title">Professional Help</h2>
        <div class="banner-ads-wrapper mt-10 mb-40 pt-30 pb-30">
            <h4 class="mt-40 text-center ad-product-title"> Apply Ad Promotions : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-2">
                    <p class="pl-15">Now that you've made a fantastic advertisement, it's time to flaunt it! Use Ad Promotions to increase the number of views and interested buyers for your ad by up to tenfold. The bigger the demand, the more likely you are to sell quickly and for the price you want.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Right pricing : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">If the price is right, everything will sell! On Public Market, look for comparable ads and pick a reasonable price. The lower the price, the greater the demand. Select the Negotiable option when placing the ad if you're willing to work out a deal.</p>

                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Add as much detail as you can : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Ads in the Public Market with detailed details receive more views! Include keywords and facts that will pique the curiosity of potential buyers. Remember to be truthful when giving these details.</p>

                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Get more views and responses : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Ad Promotions are meant to increase the number of people who see and respond to your ad while saving you time and effort.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Expand your business with Membership : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Memberships include free Ad Promotions and are loaded with extra features to give your business a bigger presence on Public Market.</p>
                </div>
            </div>
            <h3 class="text-center mt-60"> To know more or post an ad </h3>
            <h5 class="text-center mt-20"> <i class="fal fa-envelope"></i>  Dummy@email.com</h5>
        </div>
    </div>
</section>
    <br />
@endsection

@push('js')
    
@endpush