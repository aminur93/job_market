@extends('layouts.front.master')

@section('page')
    All Category
@endsection

@push('css')
    <style>
        .section_title .title {
            font-size: 40px;
            font-weight: 700;
            padding-top: 50px;
        }
    </style>
@endpush

@section('content')
<section class="location_area pt-40 pb-120 mb-120" id="category">
    <div class="container pt-60">
        <div class="row">
            <div class="col-lg-6">
                <div class="section_title pb-15">
                    <h3 class="title">Get To Know All Categories</h3> </div>
            </div>
            <div class="col-lg-6">
                <form class="d-flex district-search">
                    <input class="form-control me-2 product-top-search " type="search" placeholder="Search For A Category" aria-label="Search">
                    <button class="btn btn-outline-search" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="category_wrapper d-flex flex-wrap justify-content-center pt-30">
            @forelse ($all_category as $ac)
            <div class="category-column">
                <div class="single_category text-center mt-30">
                    <div class="icon"> <img src="{{ asset('assets/admin/uploads/category/original/'.$ac->image) }}" alt="Locations" style="width: 50px;height:50px"> </div>
                    <div class="content">
                        <h6 class="title" style="font-size: 10px;">{{ $ac->name }}</h6>
                        <p>Total Ads : 0</p>
                    </div>
                    <a href="{{ route('front.category_ads','') }}/{{ $ac->id }}"></a>
                </div>
            </div>
            @empty
            <div class="category-column">
                No Data Found
            </div>
            @endforelse
            
        </div>
    </div>
</section>
<br>
@endsection

@push('js')
    
@endpush