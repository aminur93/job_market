@extends('layouts.front.master')

@section('page')
    Home
@endsection

@push('css')
<style>
    .single_ads_card .ads_card_image img{
        padding-right: 2px;
    }
    
    .ads_card_image span {
        position: absolute;
        height: 2rem;
        width: 5.5rem !important;
        top: 15px;
        left: 15px;
        background-color: #ffffff;
        border-radius: 7px;
    }

    .public-market-tag {
        background-color: #ffffff;
        border-radius: 7px;
    }

    .price_card_body {
    padding: 0px!important;
}

    .price_header {
    background-color: #00ff00;
    height: 60px;
}

.price_header h5 {
    color: black;
    line-height: 70px;
}

.card-title {
    margin-bottom: 0.75rem;
}

.price_body p {
    padding-top: 46px;
    color: #1C78AD;
    font-size: 17px;
}

.header_content {
    position: relative;
    z-index: 5;
    padding-top: 120px;
    padding-bottom: 130px;
}

/* .content_wrapper .title {
    font-size: 60px;
    font-weight: 700;
    color: #fff;
} */


</style>
@endpush

@section('content')
    {{-- Catgeory section start --}}
    <section class="category_area pt-115" id="Category">
        <div class="container">
        <div class="row">
        <div class="col-lg-6">
        <div class="section_title">
            <h3 class="title">Popular Categories</h3> 
        </div>
        </div>
        </div>
        <div class="category_wrapper d-flex flex-wrap justify-content-center pt-30">
        @forelse ($categories as $category)
        <div class="category-column">
            <div class="single_category text-center mt-30">
                <div class="icon"> <img src="{{ asset('assets/admin/uploads/category/original/'.$category->image) }}" alt="Locations" style="width: 50px;height:50px"> </div>
                <div class="content">
                <h6 class="title" style="font-size: 10px;">{{ ucfirst($category->name) }}</h6> 
                <p>Total Ads : 0</p>
                </div>
                <a href="{{ route('front.category_ads','') }}/{{ $category->id }}"></a>
            </div>
        </div>
        @empty
            <div class="category-column">
                No Data Found
            </div>
        @endforelse
        <div class="category_btn"> <a class="main-btn" href="{{ route('front.all_category') }}">All Categories</a> </div>
        </div>
        </div>
    </section>
    {{-- Catgeory section end --}}
   
    {{-- popular ads section start --}}
    <section class="published_area pt-115" id="Ads">
        <div class="container">
        <div class="row">
        <div class="col-lg-6">
        <div class="section_title pb-15">
            <h3 class="title">Popular Published Ads</h3> </div>
        </div>
        </div>

        <div class="published_wrapper">
        <div class="row">
            @forelse ($ads as $ad)
            <div class="col-lg-3 col-sm-6">
                <div class="single_ads_card mt-30">
                <div class="ads_card_image"> 
                    <img src="{{ asset('assets/admin/uploads/ads/medium/'.$ad->image) }}" alt="ads"> 
                    <span><img class="public-market-tag img-fluid" src="{{asset('frontend/assets/images/logo.png')}}"/></span>
                </div>
                <div class="ads_card_content">
                <div class="meta d-flex justify-content-between">
                <p>{{ $ad->title }}</p> <a class="like" href="#"><i class="fal fa-heart"></i></a> </div>
                <h4 class="title"><a href="{{ route('front.details','') }}/{{ $ad->id }}" class="add_view" rel="{{ $ad->id }}">{{ $ad->name }}</a></h4>
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
        <div class="published_btn"> <a href="{{ route('front.all_ads') }}" class="main-btn">Popular Ads</a> </div>
        </div>
        </div>
    </section>
    {{-- popular ads section end --}}
   
   {{-- Location wise ads section start --}}
   <section class="locations_area pt-115 pb-120" id="Locations">
    <div class="container">
     <div class="row">
      <div class="col-lg-6">
       <div class="section_title pb-15">
        <h3 class="title" style="font-size: 45px;">Explore Popular Locations</h3> 
        </div>
      </div>
     </div>
     <div class="locations_wrapper">
      <div class="row justify-content-center">
        @forelse ($division_ads_total as $key => $division)
            
            <div class="col-lg-4 col-md-7 col-sm-8">
                <div class="single_locations mt-30">
                <div class="locations_image"> <img src="{{ asset('assets/admin/uploads/division/original/'.$division['image']) }}" alt="Locations"> </div>
                <div class="locations_content">
                <h5 class="title"><a href="{{ route('front.all_district','') }}/{{ $division['id'] }}"><i class="far fa-map-marker-alt"></i>{{ $key }}</a></h5>
                <p>{{ $division['total'] }} ads posted in this location</p> 
                <a class="view" href="{{ route('front.division_ads','') }}/{{ $division['id'] }}">View All Ads Here <i class="fa fa-angle-right">
                    </i></a> 
                </div>
                </div>
            </div>
            
        @empty
        <div class="col-lg-4 col-md-7 col-sm-8">
            No Data Found
        </div>
        @endforelse
      </div>
      <div class="locations_btn text-center"> <a class="main-btn" href="{{ route('front.all_location') }}">View all Locations</a> </div>
     </div>
    </div>
   </section>
   {{-- Location wise ads section end --}}


   {{-- Recently published ads section start --}}
   <section class="published_area pt-115" id="Recent">
    <div class="container">
     <div class="row">
      <div class="col-lg-6">
       <div class="section_title pb-15">
        <h3 class="title">Recently Published Ads</h3> </div>
      </div>
     </div>
     <div class="published_wrapper">
      <div class="row">
        @forelse ($recently_ads as $ra)
            <div class="col-lg-3 col-sm-6">
                <div class="single_ads_card mt-30">
                <div class="ads_card_image"> 
                    <img src="{{ asset('assets/admin/uploads/ads/medium/'.$ra->image) }}" alt="ads"> 
                    <span><img class="public-market-tag img-fluid" src="{{asset('frontend/assets/images/logo.png')}}"/></span> 
                </div>
                <div class="ads_card_content">
                <div class="meta d-flex justify-content-between">
                <p>{{ $ra->title }}</p> <a class="like" href="#"><i class="fal fa-heart"></i></a> </div>
                <h4 class="title"><a href="{{ route('front.details','') }}/{{ $ra->id }}">{{ $ra->name }}</a></h4>
                <p><i class="far fa-map-marker-alt"></i>{{ $ra->divison_name }},Bangladesh</p>
                <p><i class="fas fa-eye"></i> {{ $ra->view_count }} </p>
                <div class="ads_price_date d-flex justify-content-between"> <span class="price">{{ $ra->unit_price }}৳</span> <span class="date">{{ \Carbon\Carbon::parse($ra->date)->format('j F, Y') }}</span> </div>
                </div>
                </div>
            </div>
        @empty
        <div class="col-lg-3 col-sm-6">
            No Data Found
        </div>
        @endforelse
      </div>
      <div class="published_btn"> <a href="{{ route('front.all_ads') }}" class="main-btn">View all Ads</a> </div>
     </div>
    </div>
   </section>
   {{-- Recently published ads section end --}}
   
   {{-- PublicMarket ads pricing section start --}}
   <section class="services_area pt-115">
    <div class="container">
     <div class="row justify-content-center">
      <div class="col-lg-6">
       <div class="section_title text-center pb-15">
        <h3 class="title" style="font-size: 40px">PublicMarket Ads Pricing</h3> 
        </div>
      </div>
     </div>
     <div class="row">
        @forelse ($ads_pricing as $ap)
        <div class="col-lg-4 col-md-6 mt-4">
            <div class="card" style="height: 200px;">
                <div class="card-body price_card_body">
                    <div class="price_header">
                        <h5 class="card-title text-center">
                            ৳{{ $ap->start_price }} 
                            @if ($ap->end_price != null)
                            (per month) &৳ {{ $ap->end_price }} ({{ $ap->single_month }})
                            @else
                            ({{ $ap->single_month }})
                            @endif
                            
                        </h5>
                    </div>
                    <div class="price_body">
                        <p class="text-center">{{ $ap->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-lg-4 col-md-6 mt-4">
            No Data Found
        </div>
        @endforelse
     </div>
    </div>
   </section>
   {{-- PublicMarket ads pricing section end --}}
   
   {{-- Latest TV Commercials section start --}}
   <section class="blog_area pt-115 pb-120" id="Blog">
    <div class="container">
     <div class="row justify-content-center">
      <div class="col-lg-6">
       <div class="section_title text-center pb-15">
        <h3 class="title">Latest TV Commercials</h3> </div>
      </div>
     </div>

     <div class="row justify-content-center">

        @forelse ($tvc as $t)
        <div class="col-lg-4 col-md-7">
            <div class="single_blog mt-30">
             <div class="blog_image"> 
                <video width="360" height="240" controls title="Our video player">
                    <source src="{{asset('assets/admin/uploads/tvc/'.$t->video)}}" type="video/mp4">
                </video>     
            </div>
             <div class="blog_content">
              <h4 class="title"><a href="{{ route('front.tvc_details','') }}/{{ $t->id }}" class="tvc_count" rel1="{{ $t->id }}">{{ $t->tvc_title }}</a></h4>
              <ul class="meta">
               <li><i class="fal fa-clock"></i><a href="#">{{ \Carbon\Carbon::parse($t->created_at)->format('j F, Y') }}</a></li>
               <li>
                <a class="view-count" href="#"><span class="line"></span> <i class="fas fa-eye show"></i> {{ $t->view_count }}</a>
               </li>
              </ul>
             </div>
            </div>
        </div>
        @empty
        <div class="col-lg-4 col-md-7">
            No Data Found
        </div>
        @endforelse
     </div>
     <div class="blog_btn text-center mt-50"> <a href="{{ route('front.all_tvc') }}" class="main-btn">View All TVC</a> </div>
    </div>
    <br/>
   </section>
   {{-- Latest TV Commercials section end --}}

<div class="fixedbuttom container text-center">
    <nav class="footerbutton">
        <ul>
            <li><a href="#" class="nav__logo" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Post Ads</a></li>
            <li><a href="{{ route('front.all_ads') }}" class="nav__logo">All Ads</a></li>
        </ul>
    </nav>
</div>
  
@endsection

@push('js')
    <script>
        $(document).ready(function(){

            $(".add_view").on('click', function(){

                var id = $(this).attr('rel');

                $.ajax({
                    url: "{{ route('front.add_view_count') }}",
                    type: "GET",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                    }
                })
            })
        })
    </script>
    <script>
        $(document).ready(function(){

            $(".tvc_count").on('click', function(){

                var id = $(this).attr('rel1');

                $.ajax({
                    url: "{{ route('front.tvc_view_count') }}",
                    type: "GET",
                    data: {id: id},
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                    }
                })
            })
        })
    </script>
@endpush