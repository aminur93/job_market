@extends('layouts.front.master')

@section('page')
    All Ads
@endsection

@push('css')
    <style>
        .top-ad-carousel .carousel-inner {
            border-radius: 7px;
            height: 20rem;
        }
        .mt-50 {
            margin-top: 50px;
        }

        .carousel-caption {
            position: absolute;
            right: 15%;
            bottom: 20px;
            left: 15%;
            z-index: 10;
            padding-top: 20px;
            padding-bottom: 20px;
            color: #fff;
            text-align: center;
        }

        .top-ad-carousel .carousel-inner .carousel-item img {
            height: 20rem;
            filter: brightness(40%);
        }

        .w-100 {
            width: 100% !important;
        }

        .store-name {
            color: #ff4367;
            font-size: 20px;
            font-weight: 500;
            padding-bottom: 5px;
        }

        .product-carousel-title {
            color: #ffffff;
            font-size: 35px;
            padding-bottom: 10px;
        }

        .product-carousel-price {
            color: #ff4367;
            font-size: 20px;
            font-weight: 600;
            padding-bottom: 30px;
        }

        .carousel-caption .auth-dealer-badge, .carousel-caption .verified-seller-badge, .carousel-caption .premium-member-badge {
            position: absolute; 
            left: 15px; 
            bottom: 5px;
            margin-left: 0!important;
        }

        .auth-dealer-badge {
            display: inline-block;
            background-color: #ff4367;
            padding: 5px 10px 5px 25px;
            color: #ffffff;
            border-radius: 7px;
            margin-left: 30%;
            position: relative;
        }

        .auth-dealer-badge i {
            color: #ffffff;
            position: absolute;
            font-size: 25px;
            left: -18px;
            bottom: 0;
            background-color: #fe7c96;
            padding: 5px;
            border-radius: 50%;
        }

        .carousel-caption .auth-dealer-badge, .carousel-caption .verified-seller-badge, .carousel-caption .premium-member-badge {
            position: absolute;
            left: 15px;
            bottom: 5px;
            margin-left: 0!important;
        }

        .verified-seller-badge {
            display: inline-block;
            background-color: #00d1c1;
            padding: 5px 10px 5px 25px;
            color: #ffffff;
            border-radius: 7px;
            margin-left: 30%;
            position: relative;
        }

        .verified-seller-badge i {
            color: #ffffff;
            position: absolute;
            font-size: 25px;
            left: -18px;
            bottom: 0;
            background-color: #8ec2bc;
            padding: 5px;
            border-radius: 50%;
        }
    </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.css"/>
     
<style>
   .mall-slider-handles{
      margin-top: 50px;
   }
   .filter-container-1{
      display: flex;
      justify-content: center;
      margin-top: 60px;
   }
   .filter-container-1 input{
      border: 1px solid #ddd;
      width: 100%;
      text-align: center;
      height: 30px;
      border-radius: 5px;
   }
   .filter-container-1 button{
      background: #51a179;
      color: red;
      padding: 5px 20px;
   }
   .filter-container-1 button:hover{
      background: #2e7552;
      color: red;
   }
    
</style>
@endpush

@section('content')
<section class="product_page pt-70 pb-120" id="ads">
    <div class="container">
        <div class="row ad-wrapper">

            <div class="col-12">
                <div class="top-content">
                    <div class="row justify-content-around">
                        <form class="d-flex mt-10" action="{{ route('ads_search') }}">
                            <div class="col-lg-3 col-md-5 product-search-button pb-3 mr-5">
                                <select style="height: 40px" name="division_id" id="division_id" class="form-control">
                                    <option value="">Select Division</option>
                                    @forelse ($all_division as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @empty
                                        <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-5 product-search-button pb-3">
                                <select style="height: 40px" name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @forelse ($all_category as $ac)
                                        <option value="{{ $ac->id }}">{{ $ac->name }}</option>
                                    @empty
                                        <option value="">No Data Found</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <div class="d-flex">
                                    <input class="form-control me-2 product-top-search" type="search" name="search"
                                    placeholder="What Are You Looking For" aria-label="Search">
                                    <button class="btn btn-outline-search" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="product_sidebar pt-3">

                    <div class="sidebar_price_range mt-30">
                        <div class="sidebar_title">
                            <h5 class="title">Filters</h5>
                        </div>
                        <div class="price_range_content">

                            <div class="dropdown pt-10">
                                <p class="pb-1 filter-heading">Sort By :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Date & Price</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Date : Newest On Top</a></li>
                                    <li><a class="dropdown-item" href="#">Date : Oldest On Top</a></li>
                                    <li><a class="dropdown-item" href="#">Price : High To Low</a></li>
                                    <li><a class="dropdown-item" href="#">Price : Low To High</a></li>
                                </ul>
                            </div>

                            {{-- <div class="check-features pt-20">
                                <p class="pb-1 filter-heading">Filter Ads By :</p>
                                <div class="form-check">
                                    <input class="form-check-input filter-checkbox" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Featured
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-checkbox" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Verified Seller
                                    </label>
                                </div>
                            </div> --}}

                            <div class="check-features pt-20">
                                <p class="pb-1 filter-heading">Price Range :</p>
                                <form action="{{ route('ads_price_range') }}">
                                    @csrf

                                    <div class="mall-property">
                                       <div class="mall-property__label">
                                          <a class="mall-property__clear-filter js-mall-clear-filter" href="javascript:;" data-filter="price" style="">
                                          </a> 
                                       </div>
                                       <div class="mall-slider-handles" data-start="{{ $filter_min_price ?? $min_price }}" data-end="{{ $filter_max_price ?? $max_price }}" data-min="{{ $min_price}}" data-max="{{ $max_price }}" data-target="price" style="width: 100%">
                                       </div>
                                       <div class="row filter-container-1">
                                          <div class="col-md-4">
                                             <input type="hidden" data-min="price" id="skip-value-lower" name="min_price" value="{{ $filter_min_price ?? $min_price }}" readonly>  
                                          </div>
                                          <div class="col-md-4">
                                             <input type="hidden" data-max="price" id="skip-value-upper" name="max_price" value="{{ $filter_max_price ?? $max_price }}" readonly>
                                          </div>
                                          <div class="col-md-4">
                                             <button type="submit" class="btn btn-sm">Filter</button>
                                          </div>
                                       </div>
                                    </div>
                                </form>
                            </div>

                            <div class="radio-features pt-20">
                                <div class="discount_content">
                                    <p class="pb-1 filter-heading">Some More Filters :</p>
                                    <ul class="discount_radio">
                                        <li>
                                            <input type="radio" checked="" name="radio" id="radio4">
                                            <label for="radio4"></label> <span>Top Sellers</span>
                                        </li>
                                        <li>
                                            <input type="radio" name="radio" id="radio5">
                                            <label for="radio5"></label> <span>PublicMarket Members</span>
                                        </li>
                                        <li>
                                            <input type="radio" name="radio" id="radio6">
                                            <label for="radio6"></label> <span>Banner Advertisements</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="sidebar_categories mt-30">
                        <div class="sidebar_title">
                            <h5 class="title">Categories</h5>
                        </div>
                        <div class="sidebar_categories_content">
                            <div class="accordion" id="accordionExample">

                                @forelse ($total_cat_sub as $key => $tcs)
                                    <div class="card">
                                        <div class="card-header" id="heading{{ $key }}">
                                            <a class="collapsed" data-bs-toggle="collapse" href="#collapse{{ $key }}" role="button" aria-expanded="false" aria-controls="collapse{{ $key }}"><img src="{{ asset('assets/admin/uploads/category/original/'.$tcs['category_image']) }}" alt="Icon" style="width: 25px"> {{ $tcs['category_name']  }} ({{ $tcs['category_count'] }})</a>
                                        </div>
                                        <div class="collapse" id="collapse{{ $key }}">
                                            <div class="card-body">
                                                <ul class="sidebar_categories_list">
                                                    @foreach ($sub_category as $sc)
                                                        @if ($key == $sc->category_id)
                                                        <li><a href="{{ route('front.sub_category_ads','') }}/{{ $sc->id }}">{{ $sc->name }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="card">
                                        No Data Found
                                    </div>
                                    @endforelse
                                
                            </div>
                        </div>
                    </div>

                    <div class="sidebar_discount mt-30">
                        <div class="sidebar_title">
                            <h5 class="title">Top Deals</h5>
                        </div>
                        <div class="discount_content">
                            <ul class="discount_radio">
                                <li>
                                    <input type="radio" checked="" name="radio" id="radio1">
                                    <label for="radio1"></label> <span>Flat 10% Off</span>
                                </li>
                                <li>
                                    <input type="radio" name="radio" id="radio2">
                                    <label for="radio2"></label> <span>Flat 20% Off</span>
                                </li>
                                <li>
                                    <input type="radio" name="radio" id="radio3">
                                    <label for="radio3"></label> <span>Flat 50% Off</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="sidebar_price_range mt-30">
                        <div class="sidebar_title">
                            <h5 class="title">Featured Ad</h5>
                        </div>
                        <div class="small-ad"><img src="{{ asset('frontend/assets/images/side-small.jpg') }}" class="img-fluid"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">

                <div id="carouselExampleControls" class="carousel slide carousel-fade mt-50 top-ad-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="3000">
                            <img src="{{asset('frontend/assets/images/ads-9.png')}}" class="d-block w-100" alt="...">
                            <div class="carousel-caption">
                                <p class="store-name">Store Name</p>
                                <h4 class="text-left product-carousel-title">Nomet Cycle</h4>
                                <p class="product-carousel-price">৳29,999.00</p>
                                <p class="text-left auth-dealer-badge"><i class="fas fa-check-circle"></i> Auth Dealer</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{asset('frontend/assets/images/ads-10.png')}}" class="d-block w-100" alt="...">
                            <div class="carousel-caption">
                                <p class="store-name">Store Name</p>
                                <h4 class="text-left product-carousel-title">Samsung Galaxy S8</h4>
                                <p class="product-carousel-price">৳33,000.00</p>
                                <p class="text-left verified-seller-badge"><i class="fas fa-check-circle"></i> Verified Seller</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="{{asset('frontend/assets/images/ads-11.png')}}" class="d-block w-100" alt="...">
                            <div class="carousel-caption">
                                <p class="store-name">Store Name</p>
                                <h4 class="text-left product-carousel-title">LG V30</h4>
                                <p class="product-carousel-price">৳12,000.00</p>
                                <p class="text-left premium-member-badge"><i class="fas fa-check-circle"></i>Member</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="tab-content pt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="product_list">

                            @forelse ($ads as $ad)
                            <div class="single_ads_card ads_list d-sm-flex mt-30">
                                <div class="ads_card_image">
                                    <img src="{{ asset('assets/admin/uploads/ads/medium/'.$ad->image) }}" alt="ads" style="width: 270px;height:270px">
                                </div>
                                <div class="ads_card_content media-body">
                                    <div class="meta d-flex justify-content-between">
                                        <p>{{ $ad->category_name }}</p>
                                        <a class="like" href="#"><i class="fal fa-heart"></i></a>
                                    </div>
                                    <h4 class="title"><a href="{{ route('front.details','') }}/{{ $ad->id }}" class="add_view" rel="{{ $ad->id }}">{{ $ad->name }}</a></h4>
                                    <p><i class="far fa-map-marker-alt"></i>{{ $ad->division_name }}, Bangladesh</p>
                                    <p>{!! Str::words($ad->description, 30) !!}</p>
                                    <div class="ads_price_date d-flex justify-content-between">
                                        <span class="price">৳{{ $ad->unit_price }}</span>
                                        <span class="date">{{ \Carbon\Carbon::parse($ad->date)->format('j F, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="single_ads_card ads_list d-sm-flex mt-30">
                                No Data Found
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mt-30 pt-3">
                <div class="sidebar-ad">
                    <div class="small-ad"><img src="{{ asset('frontend/assets/images/banner-ad-small.jpg') }}" class="img-fluid"></div>
                </div>
            </div>
            <div class="col-lg-12 pt-10">
                <div class="bottom-ad"><img src="{{ asset('frontend/assets/images/bottom-banner.jpg') }}" class="img-fluid"/></div>
                <div class="pagination_wrapper mt-50">
                    <ul class="pagination justify-content-center">
                        {{ $ads->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<br>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>

<script>
    $(function () {
           var $propertiesForm = $('.mall-category-filter');
           var $body = $('body');
           $('.mall-slider-handles').each(function () {
               var el = this;
               noUiSlider.create(el, {
                   start: [el.dataset.start, el.dataset.end],
                   connect: true,
                   tooltips: true,
                   range: {
                       min: [parseFloat(el.dataset.min)],
                       max: [parseFloat(el.dataset.max)]
                   },
                   pips: {
                       mode: 'range',
                       density: 20
                   }
               }).on('change', function (values) {
                   $('[data-min="' + el.dataset.target + '"]').val(values[0])
                   $('[data-max="' + el.dataset.target + '"]').val(values[1])
                   $propertiesForm.trigger('submit');
               });
           })
       })   
</script>

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
@endpush