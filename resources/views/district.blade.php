@extends('layouts.front.master')

@section('page')
    All District
@endsection

@push('css')
    
@endpush

@section('content')
<section class="location_area pt-40 pb-120 mb-120" id="district">
    <div class="container pt-60">
        <div class="row">
            <div class="col-lg-6">
                <div class="section_title pb-15">
                    <h3 class="title2" style="margin-top: 55px">Explore All Districts In {{ $division->name }}</h3> </div>
            </div>
            <div class="col-lg-6">
                <form class="d-flex district-search">
                    <input class="form-control me-2 product-top-search " type="search" placeholder="Search For A District" aria-label="Search">
                    <button class="btn btn-outline-search" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="category_wrapper d-flex flex-wrap pt-30">
            @forelse ($district_ads_total as $key => $dat)
            <div class="district-column">
                <div class="single_district text-center mt-30">
                    <div class="icon"> <img src="{{asset('assets/admin/uploads/district/small/'.$dat['image'])}}" alt="Locations"> </div>
                    <div class="content">
                        <h4 class="district-title">{{ $key }}</h4>
                        <h6 class="district-p">Total Ads: {{ $dat['total'] }}</h6>
                    </div>
                    <a href="{{ route('front.district_ads','') }}/{{ $dat['id'] }}"></a>
                </div>
            </div>
            @empty
            <div class="district-column">
                No Data Found
            </div>
            @endforelse
            
        </div>
    </div>
</section>

@endsection

@push('js')
    
@endpush