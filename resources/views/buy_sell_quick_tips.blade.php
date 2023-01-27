@extends('layouts.front.master')

@section('page')
    Buy Sell Quick Tips
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
<section class="blog_details_page pt-70 pb-120 pb-30" id="BuySellQuickly">
    <div class="container">
        <h2 class="text-center mt-40 banner-ad-title">Buy & Sell Quickly Tips</h2>
        <div class="banner-ads-wrapper mt-10 mb-40 pt-30 pb-30">
            <h4 class="mt-40 text-center ad-product-title"> Add quality full photos : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-2">
                    <p class="pl-15">It is better to use clear photos of the items you are selling real and clear photos get up to 20 times more views then ads with catalogues stock photos make sure to take picture with a good lightning source and take photos from different angles.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Right pricing : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Everything can be sold if the price is right before putting a price browse similar ads on our platform and choose a competitive price in general the lower the price the higher the demand. If you are willing to negotiate be sure to select the negotiable option while posting the Ad.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Promoting Ad : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">After creating a great ad you need to show it off when an ad is promoted it gets higher views views as high as 10 x the interested buyers for your ad. The higher the demand the better the chances of selling fast for the price that you want.</p>
                    <p class="pl-15">To sell your items quickly at the best price by making your ads stand out on public market while it's free to post ads on public market at promotions is a page tools that gets you more responses on your ads and helps you sell fast.</p>
                </div>
            </div>
            <h3 class="text-center mt-60"> To know more or post an ad </h3>
            <h5 class="text-center mt-20"> <i class="fal fa-envelope"></i>  Dummy@email.com</h5>
        </div>
    </div>
</section>
<br>
@endsection

@push('js')
    
@endpush