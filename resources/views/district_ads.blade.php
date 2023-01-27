@extends('layouts.front.master')

@section('page')
    District All Ads
@endsection

@push('css')
    
@endpush

@section('content')
<section class="product_page pt-70 pb-120" id="ads">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="top-content">
                    <div class="row justify-content-around">
                        <div class="col-lg-3 col-md-5 product-search-button pb-3">
                            <div class="dropdown">
                                <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-map-marker-alt drop-image"></i> &nbsp;<span>Dhaka</span>
                                </button>
                                <ul class="dropdown-menu location-sort-ul" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="#">Barishal</a></li>
                                    <li><a class="dropdown-item" href="#">Chittagong</a></li>
                                    <li><a class="dropdown-item" href="#">Mymensingh</a></li>
                                    <li><a class="dropdown-item" href="#">Khulna</a></li>
                                    <li><a class="dropdown-item" href="#">Rajshahi</a></li>
                                    <li><a class="dropdown-item" href="#">Rangpur</a></li>
                                    <li><a class="dropdown-item" href="#">Sylhet</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 product-search-button pb-3">
                            <div class="dropdown">
                                <button class="btn btn-light product-sort-button" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-tags drop-image"></i> &nbsp;<span>Select Category</span>
                                </button>
                                <ul class="dropdown-menu location-sort-ul" aria-labelledby="dropdownMenuButton3">
                                    <li><a class="dropdown-item" href="#">Electronics</a></li>
                                    <li><a class="dropdown-item" href="#">Mobile</a></li>
                                    <li><a class="dropdown-item" href="#">Home & Living</a></li>
                                    <li><a class="dropdown-item" href="#">Transportation</a></li>
                                    <li><a class="dropdown-item" href="#">Pet & Animals</a></li>
                                    <li><a class="dropdown-item" href="#">Property</a></li>
                                    <li><a class="dropdown-item" href="#">Fashion & Beauty</a></li>
                                    <li><a class="dropdown-item" href="#">Hobby,Sports & Baby</a></li>
                                    <li><a class="dropdown-item" href="#">Daily Needs & Grocery</a></li>
                                    <li><a class="dropdown-item" href="#">Factory & Industry</a></li>
                                    <li><a class="dropdown-item" href="#">Education</a></li>
                                    <li><a class="dropdown-item" href="#">Job</a></li>
                                    <li><a class="dropdown-item" href="#">Services</a></li>
                                    <li><a class="dropdown-item" href="#">Agricultural Products</a></li>
                                    <li><a class="dropdown-item" href="#">Foreign Jobs</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                            <form class="d-flex">
                                <input class="form-control me-2 product-top-search" type="search" placeholder="What Are You Looking For" aria-label="Search">
                                <button class="btn btn-outline-search" type="submit">Search</button>
                            </form>
                        </div>
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
                                <p class="pb-1 filter-heading">District :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="districtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>District</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="districtDropdown">
                                    <li><a class="dropdown-item" href="#">Dhaka</a></li>
                                    <li><a class="dropdown-item" href="#">Faridpur</a></li>
                                    <li><a class="dropdown-item" href="#">Gazipur</a></li>
                                    <li><a class="dropdown-item" href="#">Gopalganj</a></li>
                                    <li><a class="dropdown-item" href="#">Kishoreganj</a></li>
                                    <li><a class="dropdown-item" href="#">Madaripur</a></li>
                                    <li><a class="dropdown-item" href="#">Manikganj</a></li>
                                    <li><a class="dropdown-item" href="#">Munshiganj</a></li>
                                    <li><a class="dropdown-item" href="#">Narayanganj</a></li>
                                    <li><a class="dropdown-item" href="#">Narsingdi</a></li>
                                    <li><a class="dropdown-item" href="#">Rajbari</a></li>
                                    <li><a class="dropdown-item" href="#">Shariatpur</a></li>
                                    <li><a class="dropdown-item" href="#">Tangail</a></li>
                                </ul>
                            </div>
                            <div class="dropdown pt-10 pb-10">
                                <p class="pb-1 filter-heading">Zones :</p>
                                <button class="btn btn-light product-sort-button" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Zone</span> <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu product-sort-ul" aria-labelledby="cityDropdown">
                                    <li><a class="dropdown-item" href="#">Azimpur</a></li>
                                    <li><a class="dropdown-item" href="#">Banasree</a></li>
                                    <li><a class="dropdown-item" href="#">Basundhara R/A</a></li>
                                    <li><a class="dropdown-item" href="#">Cantonment</a></li>
                                    <li><a class="dropdown-item" href="#">Demra</a></li>
                                    <li><a class="dropdown-item" href="#">Dhanmondi</a></li>
                                    <li><a class="dropdown-item" href="#">Gulshan</a></li>
                                    <li><a class="dropdown-item" href="#">Gabtoli</a></li>
                                    <li><a class="dropdown-item" href="#">Jatrabari</a></li>
                                    <li><a class="dropdown-item" href="#">Khilgaon</a></li>
                                    <li><a class="dropdown-item" href="#">Mirpur</a></li>
                                    <li><a class="dropdown-item" href="#">Mohakhali</a></li>
                                    <li><a class="dropdown-item" href="#">Mohammadpur</a></li>
                                    <li><a class="dropdown-item" href="#">Motijheel</a></li>
                                    <li><a class="dropdown-item" href="#">Mugda</a></li>
                                    <li><a class="dropdown-item" href="#">Puran Dhaka</a></li>
                                    <li><a class="dropdown-item" href="#">Uttara</a></li>
                                </ul>
                            </div>
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
                            <div class="check-features pt-20">
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
                                    <div class="card-header" id="headingOne">
                                        <a class="collapsed" data-bs-toggle="collapse" href="#collapse_{{ $key }}" role="button" aria-expanded="false" aria-controls="collapseOne"><img src="{{ asset('assets/admin/uploads/category/original/'.$tcs['category_image']) }}" alt="Icon" style="width: 25px"> {{ Str::ucfirst($key)  }} ({{ $tcs['category_count'] }})</a>
                                    </div>
                                    <div class="collapse" id="collapse_{{ $key }}">
                                        <div class="card-body">
                                            <ul class="sidebar_categories_list">
                                                @foreach ($tcs['sub_category'] as $sub_category)
                                                <li><a href="#">{{ $sub_category }}</a></li>
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
                        <div class="small-ad"><img src="{{asset('frontend/assets/images/side-small.jpg')}}" class="img-fluid"></div>
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
                    <div class="small-ad"><img src="{{asset('frontend/assets/images/banner-ad-small.jpg')}}" class="img-fluid"></div>
                </div>
            </div>
            <div class="col-lg-12 pt-10">
                <div class="bottom-ad"><img src="{{asset('frontend/assets/images/bottom-banner.jpg')}}" class="img-fluid"/></div>
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