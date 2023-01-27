@extends('layouts.front.master')

@section('page')
    Search Result
@endsection

@push('css')
    
@endpush

@section('content')
<section class="published_area pt-115" id="Ads">
    <div class="container">
    <div class="row">
    <div class="col-lg-6">
    <div class="section_title pb-15">
        <h3 class="title" style="font-size: 35px">Search Result</h3> </div>
    </div>
    </div>

    <div class="published_wrapper">
    <div class="row">
        @forelse ($result as $ad)
        <div class="col-lg-3 col-sm-6">
            <div class="single_ads_card mt-30">
            <div class="ads_card_image"> 
                <img src="{{ asset('assets/admin/uploads/ads/medium/'.$ad->image) }}" alt="ads"> 
                <span><img class="public-market-tag img-fluid" src="{{asset('frontend/assets/images/logo.png')}}"/></span>
            </div>
            <div class="ads_card_content">
            <div class="meta d-flex justify-content-between">
            <p>{{ $ad->title }}</p> <a class="like" href="#"><i class="fal fa-heart"></i></a> </div>
            <h4 class="title"><a href="{{ route('front.details','') }}/{{ $ad->id }}">{{ $ad->name }}</a></h4>
            <p><i class="far fa-map-marker-alt"></i>{{ $ad->division_name }},Bangladesh</p>
            <p><i class="fas fa-eye"></i> {{ $ad->view_count }} </p>
            <div class="ads_price_date d-flex justify-content-between"> <span class="price">{{ $ad->unit_price }}৳</span> <span class="date">{{ \Carbon\Carbon::parse($ad->date)->format('j F, Y') }}</span> </div>
            </div>
            </div>
        </div>
        @empty
        <div class="col-lg-3 col-sm-6">
            No Data Found
        </div>
        @endforelse
    </div>
    </div>
    </div>
</section>
<br>
@endsection

@push('js')
    
@endpush