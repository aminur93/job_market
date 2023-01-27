@extends('layouts.front.master')

@section('page')
    Pricing Tips
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
<section class="blog_details_page pt-70 pb-120 pb-30" id="PricingTips">
    <div class="container">
        <h2 class="text-center mt-40 banner-ad-title">Pricing Tips</h2>
        <div class="banner-ads-wrapper mt-10 mb-40 pt-30 pb-30">
            <h4 class="mt-40 text-center ad-product-title"> Right pricing : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">If the price is right, everything sells! On Public Market, look for comparable ads and choose a reasonable price. Generally speaking, the lower the price, the greater the demand. Select the Negotiable option when placing the ad if you are willing to work out a deal.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Know the market : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-2">
                    <p class="pl-15">You must learn what your clients want as well as what your competitors have to offer and how much they charge. That gives you a starting point for figuring out the range of pricing and products available, as well as where you fit in.</p>
                    <p class="pl-15"></p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Deciding your pricing objectives : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Ask yourself what you want to achieve with your pricing, and then establish a pricing plan that will help you reach your goals. If you're launching a new product, for example, you can decide to set a low price to assist you gain market share. Alternatively, you could take the opposite route and establish a premium price that early adopters will be willing to pay to get their hands on a new and exclusive product.</p>
                </div>
            </div>
            <h4 class="mt-40 text-center ad-product-title"> Consider cost-plus pricing : </h4>
            <div class="row mt-20 banner-product-wrapper ad-products-box pt-20 pb-20">
                <div class="col-sm-12 banner-product-details mb-4">
                    <p class="pl-15">Calculate what proportion of your fixed costs the product should cover. To generate a unit break-even value, add all of these costs together and divide by volume. To your break-even point, you'll need to add a margin or mark-up. Typically, this is represented as a percentage of break-even. The level of mark-up will be determined by industry norms, experience, and market understanding. If the price appears to be excessively high, cut your costs and the pricing correspondingly.</p>
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