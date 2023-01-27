@extends('layouts.front.master')

@section('page')
    Tvc Details
@endsection

@push('css')
    
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
                                <h3 class="title_container">{{ $tvc->tvc_title }}</h3>
                                <span class="sub_title">Posted on {{ \Carbon\Carbon::parse($tvc->created_at)->format('j F, Y') }}, <i class="fas fa-eye"></i> {{ $tvc->view_count }} </span>
                            </div>
                        </div>

                        <div class=col-lg-12>
                            <div class=product_image>
                                <div class=tab-content id=myTabContent>
                                    <div class="fade tab-pane active show"id=details-1 aria-labelledby=details-1-tab role=tabpanel>
                                        <video width="100%" height="600" controls title="Our video player">
                                            <source src="{{asset('assets/admin/uploads/tvc/'.$tvc->video)}}" type="video/mp4">
                                        </video>    
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="feature_details mt-4">
                                <h6 class="mb-4">{{ $tvc->company_name }}</h6>
                                {{ $tvc->description }}
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
@endsection

@push('js')
    
@endpush