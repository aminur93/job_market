@extends('layouts.front.master')

@section('page')
    Details
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
    </style>
@endpush

@section('content')
<br><br>
<section class="pb-120 product_details_page pt-30">
    <div class=container>
        <div class=row>
            <div class=col-lg-12>
                <div class="mt-50 product_details">
                    <div class=row>
                        <div class="title_container mb-2">
                            <div>
                                <h3 class="title_container">{{ $ads->title }} ({{ $ads->condition }}) <span class="adddeadline" style="color: #FF4367; font-size:20px">Deadline: 27 Aug 2021</span><a class="product_details_view" href="#" style="font-size: 20px"><span class="line"></span> ( <i class="fas fa-eye show" style="font-size: 20px"></i> {{ $ads->view_count }} )</a></h3>
                                <span class="sub_title">Posted on {{ \Carbon\Carbon::parse($ads->date)->format('j F, Y') }}, {{ $ads->district_name }}, {{ $ads->division_name }} Division</span>
                            </div>
                        </div>
                        <div class=col-lg-8>
                            <div class=product_image>
                                <div class=tab-content id=myTabContent>
                                    <div class="fade tab-pane active show"id=details-1 aria-labelledby=details-1-tab role=tabpanel>
                                        <img alt="product details" src="{{ asset('assets/admin/uploads/ads/large/'.$ads->image) }}" class="optim base_image">
                                        <ul class=sticker>
                                            <span><img class="public-market-tag img-fluid" src="{{asset('frontend/assets/images/logo.png')}}"/></span>
                                        </ul>
                                    </div>
                                    <div class="fade tab-pane"id=details-2 aria-labelledby=details-2-tab role=tabpanel>
                                        <img alt="product details"src="{{asset('assets/frontend/images/product_details-2.jpg')}}">
                                    </div>
                                </div>

                                <ul class=nav id=myTab role=tablist>
                                    <li class="nav-item">
                                        <a href=# class=active aria-controls=details-1 aria-selected=true data-toggle=tab id=details-1-tab role=tab>
                                            <img src="{{ asset('assets/admin/uploads/ads/small/'.$ads->image) }}" alt="product details" class="getBaseUrl">
                                        </a>
                                    </li>
                                    @forelse ($ads_gallery as $ag)
                                    <li class=nav-item>
                                        <a href=# class=active aria-controls=details-1 aria-selected=true data-toggle=tab id=details-1-tab role=tab>
                                            <img alt="product details" src="{{asset('assets/admin/uploads/ads_gallery/small/'.$ag->image)}}" class="getUrl">
                                        </a>
                                    </li>
                                    @empty
                                        <p>No Image Found</p>
                                    @endforelse
                                </ul>
                            </div>
                            <br>
                            <h3 class="product_details_price">TK :{{ $ads->unit_price }}</h3>
                            <div class="about_produt mt-2">
                                <ul>
                                    <li>Condition: {{ $ads->condition }}</li>
                                    <li>Model: {{ $ads->name }}</li>
                                    <li>Authentication: Original</li>
                                    <li>Brand: {{ $ads->brand_name }}</li>
                                    <li>Price on call: {{ $ads->price_on_call == 0 ? 'No' : 'yes' }}</li>
                                </ul>
                            </div>
                            <div style="clear: both"></div>
                            <div class="feature_details mt-4">
                                <h6>Feature</h6>
                                {!! $ads->features !!}
                            </div>
                            <div class="feature_details mt-4">
                                <h6>Description</h6>
                                {!! $ads->description !!}
                            </div>

                        </div>
                        <div class=col-lg-4>
                            <div class=product_details_sidebar>
                                <div class="product_sidebar_owner">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><spna class="stitle">For sale by</spna> {{ ucfirst($ads->user_name) }}</h5>
                                            <hr>
                                            <h5 class="card-title"><i class="fa fa-phone-square" aria-hidden="true" style="padding: 3px;"></i>{{ $ads->user_phone }}</h5>
                                            <hr>
                                            <h5 class="card-title"><i class="fa fa-comments-o" style="padding: 3px;"></i>Message</h5>
                                        </div>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title"><i class="fa fa-shield" aria-hidden="true" style="padding: 3px;"></i>Safty tips</h5>
                                            <ul>
                                                <li>Avoid offers that look unrealistic</li>
                                                <li>Chat with seller to clarify item details</li>
                                                <li>Meet in a ssage & public place</li>
                                                <li>check the item before buying it</li>
                                                <li>Don't pay in advance</li>
                                                <a style="padding-top: 2px;" href="#">Stay with safty tips</a>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-4 product_sidebar_map">
                                        <div class=product_details_title>
                                            <h5 class=title>Location Map :</h5>
                                        </div>
                                        <div class=gmap_canvas>
                                            <iframe allowfullscreen aria-hidden=false frameborder=0 height=450 src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d58438.99370019598!2d90.37660034520664!3d23.73178733112072!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3755b9aaa7fb50d1%3A0x7a3104cb73a7058c!2ssetcolbd!3m2!1d23.7317127!2d90.4116198!5e0!3m2!1sen!2sbd!4v1609999884448!5m2!1sen!2sbd"style=border:0 tabindex=0 width=600></iframe>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="button_promotion">
                        <button type="button" class="btn btn-warning"><i class="fa fa-arrow-up mr-2"></i><a
                                href=""><span style="color: white;">Promote this ad</span></a></button>
                        <button type="button" class="btn btn-light"><i class="fa fa-ban mr-2" aria-hidden="true" ></i><a
                                href="">Report this ad</a></button>

                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#termConditionModal"><i class="fa fa-gavel mr-2" style="color: #FF4367" aria-hidden="true" ></i><a
                                href="#">Terms Apply</a></button>
                        <!-- Modal -->
                        <div class="modal fade" id="termConditionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{asset('assets/frontend/images/terms and condition.jpg')}}" alt="term-condition">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Modal -->

                        <button type="button" class="btn btn-light"><i class="fas fa-save mr-2" style="color: #FF4367" aria-hidden="true" ></i><a
                                href="#">Save this</a></button>
                        <button type="button" class="btn btn-light"><i class="fas fa-share-square" style="color: #FF4367"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br/>
<section class="related-product_section" >
 <div class="row justify-content-center">
  <div class="col-lg-12">
   <div class="related_product mt-45">
    <div class="section_title">
     <h3 class="title">Related Ads</h3>
    </div>
    <div class="row">
        @forelse ($related_ads  as $ra)
        <div class="col-lg-3">
            <div class="single_ads_card mt-30">
             <div class="ads_card_image"> <img src="{{ asset('assets/admin/uploads/ads/medium/'.$ra->image) }}" alt="ads"> </div>
             <div class="ads_card_content">
              <div class="meta d-flex justify-content-between">
               <p>{{ $ra->category_name }}</p> <a class="like" href="#"><i class="fal fa-heart"></i></a> </div>
              <h4 class="title"><a href="{{ route('front.details','') }}/{{ $ra->id }}">{{ $ra->name }}</a></h4>
              <p><i class="far fa-map-marker-alt"></i>{{ $ra->division_name }}, Bangladesh</p>
              <p><i class="fas fa-eye"></i> {{ $ra->view_count }} </p>
              <div class="ads_price_date d-flex justify-content-between"> <span class="price">{{ $ra->unit_price }}৳</span> <span class="date">{{ \Carbon\Carbon::parse($ra->date)->format('j F, Y') }}</span> </div>
             </div>
            </div>
        </div>
        @empty
        <div class="col-lg-3">
            No Related Ads Found
        </div>
        @endforelse
    </div>
    <div class="related_product_btn">
     <a class="main-btn" href="{{ route('front.all_ads') }}">View all Ads</a>
    </div>
   </div>
  </div>
 </div>

</section>
<br/>
@endsection

@push('js')
    <script>
        $(document).on("click", ".getUrl", function (e) {
            e.preventDefault();

            var image = $(this).attr('src');
            const myArray = image.split("/");
            
            var base_url = window.location.origin;
            console.log(base_url);
            var new_image = base_url + "/assets/admin/uploads/ads_gallery/original/"+myArray[8]

            $(".base_image").attr('src',new_image);
        })

        $(document).on("click", ".getBaseUrl", function (e) {
            e.preventDefault();

            var image = $(this).attr('src');
            const myArray = image.split("/");
            
            var base_url = window.location.origin;
            console.log(base_url);
            var new_image = base_url + "/assets/admin/uploads/ads/original/"+myArray[8]

            $(".base_image").attr('src',new_image);
        })
    </script>
@endpush