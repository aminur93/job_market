@extends('layouts.front.master')

@section('page')
    Category Ads
@endsection

@push('css')
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
                            <form class="d-flex mt-10" action="{{ route('category_search') }}">
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
                                    <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
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
                                        <input class="form-check-input filter-checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Featured
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filter-checkbox" type="checkbox" value=""
                                            id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Verified Seller
                                        </label>
                                    </div>
                                </div> --}}

                                <div class="check-features pt-20">
                                    <p class="pb-1 filter-heading">Price Range :</p>
                                    <form action="{{ route('price_range') }}">
                                        @csrf

                                        {{-- <input type="hidden" name="category_id" id="category_id" value="{{ $category_id->id }}"> --}}

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
                            <div class="small-ad"><img src="{{ asset('frontend/assets/images/side-small.jpg') }}"
                                    class="img-fluid"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="tab-content pt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                            <div class="product_list">

                                @forelse ($ads as $ad)
                                    <div class="single_ads_card ads_list d-sm-flex mt-30">
                                        <div class="ads_card_image">
                                            <img src="{{ asset('assets/admin/uploads/ads/medium/' . $ad->image) }}"
                                                alt="ads">
                                        </div>
                                        <div class="ads_card_content media-body">
                                            <div class="meta d-flex justify-content-between">
                                                <p>{{ $ad->category_name }}</p>
                                                <a class="like" href="#"><i class="fal fa-heart"></i></a>
                                            </div>
                                            <h4 class="title"><a
                                                    href="{{ route('front.details', '') }}/{{ $ad->id }}" class="add_view" rel="{{ $ad->id }}">{{ $ad->name }}</a>
                                            </h4>
                                            <p><i class="far fa-map-marker-alt"></i>{{ $ad->division_name }}, Bangladesh
                                            </p>
                                            <p>{!! Str::words($ad->description, 30) !!}</p>
                                            <div class="ads_price_date d-flex justify-content-between">
                                                <span class="price">৳{{ $ad->unit_price }}</span>
                                                <span
                                                    class="date">{{ \Carbon\Carbon::parse($ad->date)->format('j F, Y') }}</span>
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
                        <div class="small-ad"><img src="{{ asset('frontend/assets/images/banner-ad-small.jpg') }}"
                                class="img-fluid"></div>
                    </div>
                </div>
                <div class="col-lg-12 pt-10">
                    <div class="bottom-ad"><img src="{{ asset('frontend/assets/images/bottom-banner.jpg') }}"
                            class="img-fluid" /></div>
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
