@extends('layouts.front.master')

@section('page')
    Job Category
@endsection

@push('css')
<style>
    .header_content {
        position: relative;
        z-index: 5;
        padding-top: 120px;
        padding-bottom: 130px;
    }
</style>
@endpush

@section('content')
<section class="location_area pt-40 pb-120 mb-120" id="cvbank">
    <div class="container pt-60">
        <div class="row">
            <div class="col-lg-6">
                <div class="section_title pb-15">
                    <h3 class="title2" style="margin-top: 48px">Get To Know All Jobs</h3> </div>
            </div>
            <div class="col-lg-6">
                <form class="d-flex district-search">
                    <input class="form-control me-2 product-top-search " type="search" placeholder="Search For A Jobs" aria-label="Search">
                    <button class="btn btn-outline-search" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="category_wrapper d-flex flex-wrap justify-content-center pt-30">
            @forelse ($total_cat_job as $key => $tcj)
            <div class="category-column">
                <div class="single_category text-center mt-30">
                    <div class="icon"> <img src="{{asset('assets/admin/uploads/job_category/original/'.$tcj['image'])}}" alt="Locations"> </div>
                    <div class="content">
                        <h6 class="title" style="font-size: 10px">{{ $key }}</h6>
                        <p>Total Jobs : {{ $tcj['total'] }}</p>
                    </div>
                    <a href="{{route('front.job_list','')}}/{{ $tcj['id'] }}"></a>
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

<br/>
@endsection

@push('js')
    
@endpush