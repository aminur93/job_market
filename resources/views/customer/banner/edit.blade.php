@extends('layouts.front.master')

@section('page')
    Customer Banner Ads Edit
@endsection

@push('css')
    
@endpush

@section('content')
<section class="dashboard_page pt-70 pb-120">
    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <div class="sidebar_profile mt-50">
                    <div class="profile_user">
                        <div class="user_author d-flex align-items-center">
                            <div class="author">
                                @if ($customer->image != null)
                                <img src="{{ asset('assets/frontend/upload/customer/'.$customer->image) }}" alt="" style="width: 150px">
                                @else
                                <img src="{{ asset('frontend/assets/images/user-1.jpg') }}" alt="">
                                @endif
                                
                            </div>
                            <div class="user_content media-body">
                                <p class="author_name">{{ $customer->name }}</p>
                                <p>{{ $customer->phone }}</p>
                            </div>
                        </div>
                        <div class="user_list">
                            <ul>
                                <li><a class="{{ Request::routeIs('customer_dashboard') ? 'active' : '' }}" href="{{ route('customer_dashboard') }}"><i class="fal fa-tachometer-alt-average"></i> Dashboard</a></li>
                                <li><a class="{{ Request::routeIs('customer_profile_setting') ? 'active' : '' }}" href="{{ route('customer_profile_setting') }}"><i class="fal fa-cog"></i> Profile Settings</a></li>
                                <li><a class="{{ Request::routeIs('customer_professonal') ? 'active' : '' }}" href="{{ route('customer_professonal') }}"><i class="fal fa-user-tie"></i> Professional Profile</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads','customer_ads.create','customer_ads.edit') ? 'active' : '' }}" href="{{ route('customer_ads') }}"><i class="fal fa-layer-group"></i> My Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads_banner','customer_ads_banner.create','customer_ads_banner.edit') ? 'active' : '' }}" href="{{ route('customer_ads_banner') }}"><i class="fal fa-layer-group"></i> My Banner Ads</a></li>
                                <li><a class="{{ Request::routeIs('customer_ads_tvc','customer_ads_tvc.create','customer_ads_tvc.edit') ? 'active' : '' }}" href="{{ route('customer_tvc') }}"><i class="fal fa-layer-group"></i> My Tvc</a></li>
                                <li><a class="{{ Request::routeIs('customer_job','customer_job.create','customer_job.edit') ? 'active' : '' }}" href="{{ route('customer_job') }}"><i class="fal fa-layer-group"></i> My Job</a></li>
                                <li><a href="{{ route('customer_logout') }}"><i class="fal fa-sign-out"></i> Sign Out</a></li>
                                <li><a href="{{ route('customer_delete_account') }}"><i class="fal fa-sign-out"></i> Delete Account</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sidebar_profile mt-30" id="sidebar_cv">
                    <div class="profile_user">
                        <div class="post_title">
                            <h5 class="title">My CV</h5>
                        </div>
                        <div class="user_list">
                            <ul>
                                <li><a class="{{ Request::routeIs('customer_cv_upload') ? 'active' : '' }}" href="{{ route('customer_cv_upload') }}"><i class="fal fa-file-upload"></i>Upload CV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mt-50">

                <h5>Customer Banner Ads Create</h5><hr>
               
                <form action="" method="post" id="customer_banner_ads_edit">
                    @method('PUT')
                    @csrf

                     <input type="hidden" name="ads_banner_id" id="ads_banner_id" value="{{ $ads_banner->id }}">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="">Banner Category</label>
                                <select name="ads_banner_category_id" id="ads_banner_category_id" class="form-control">
                                    <option value="">Chose Banner Category</option>
                                    @forelse ($ads_banner_category as $abc)
                                        <option value="{{ $abc->id }}" @if ($ads_banner->ads_banner_category_id == $abc->id)
                                            selected
                                        @endif>{{ $abc->name }}</option>
                                    @empty
                                        <option value="">No data found</option>
                                    @endforelse
                                </select>
                            </div>
        
                            <div class="form-group row">
                                <label for="company_name" class="control-label">Company Name</label>
                                <input type="text" value="{{ $ads_banner->company_name }}" name="company_name" id="company_name" class="form-control">
                            </div>
        
                            <div class="form-group row">
                                <label for="title" class="control-label">Title</label>
                                <input type="text" value="{{   $ads_banner->title }}" name="title" id="title" class="form-control">
                            </div>
        
                            <div class="form-group row">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $ads_banner->description }}</textarea>
                            </div>
        
                            <div class="form-group row">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <br><br>
                                @if (!empty($ads_banner->image))
                                <div>
                                    <img src="{{ asset('assets/admin/uploads/banner/small/'.$ads_banner->image) }}" alt="">
                                </div>
                                @else
                                    <div id="image-holder"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<br/>

@endsection

@push('js')
    <script>
        $("#image").on('change', function () {

            if (typeof (FileReader) != "undefined") {

                var image_holder = $("#image-holder");
                image_holder.empty();

                var reader = new FileReader();
                reader.onload = function (e) {
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image",
                        "width": "100px",
                        "height": "100px"
                    }).appendTo(image_holder);

                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                alert("This browser does not support FileReader.");
            }
        });

        $(document).ready(function () {

            $("#customer_banner_ads_edit").on("submit",function (e) {
                e.preventDefault();

                var id = $("#ads_banner_id").val();

                var formData = new FormData( $("#customer_banner_ads_edit").get(0));

                $.ajax({
                    url : "{{ route('customer_ads_banner.update','') }}/"+id,
                    type: "post",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {

                        if (data.message){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                };
                            toastr.success(data.message);
                        }

                        $("form").trigger("reset");

                        $('.form-group').find('.valids').hide();

                        //localStorage.setItem("customer_info", JSON.stringify(data.customer_info));

                        // setTimeout(() => {
                        //     window.location.href = "{{ route('example1') }}"
                        // }, 3000);
                    },

                    error: function (err) {

                        if (err.status === 422) {
                            $.each(err.responseJSON.errors, function (i, error) {
                                var el = $(document).find('[name="'+i+'"]');
                                el.after($('<span class="valids" style="color: red;">'+error+'</span>'));
                            });
                        }

                        if (err.status === 500)
                        {
                            $('#error_message').html('<div class="alert alert-error">\n' +
                                '<button class="close" data-dismiss="alert">×</button>\n' +
                                '<strong>Error! '+err.responseJSON.error+'</strong>' +
                                '</div>');
                        }
                    }
                });
            })
        })
    </script>
@endpush