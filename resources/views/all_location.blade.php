@extends('layouts.front.master')

@section('page')
    All Locations
@endsection

@push('css')
    
@endpush

@section('content')
<section class="location_area pt-40 pb-120 mb-120" id="location">
    <div class="container pt-60">
        <div class="row">
            <div class="col-lg-12">
                <div class="section_title pb-15">
                    <h3 class="title text-center">Explore All Locations</h3></div>
            </div>
        </div>
        <div class="locations_wrapper">
            <div class="row">
                @forelse ($division_ads_total as $key => $division)
                <div class="col-lg-4 col-md-7 col-sm-8">
                    <div class="single_locations mt-30">
                        <div class="locations_image"> <img src="{{ asset('assets/admin/uploads/division/original/'.$division['image']) }}" alt="Locations"> </div>
                        <div class="locations_content">
                            <h5 class="title"><a href="{{ route('front.all_district','') }}/{{ $division['id'] }}"><i class="far fa-map-marker-alt"></i>{{ $key }}</a></h5>
                            <p>{{ $division['total'] }} ads posted in this location</p> <a class="view" href="{{ route('front.division_ads','') }}/{{ $division['id'] }}">View All Ads Here <i class="fa fa-angle-right"></i></a></div>
                    </div>
                </div>
                @empty
                <div class="col-lg-4 col-md-7 col-sm-8">
                    No Data Found
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
    
@endpush