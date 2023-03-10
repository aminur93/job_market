@extends('layouts.front.master')

@section('page')
    Customer Job Edit
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
                                <li><a class="{{ Request::routeIs('customer_ads') ? 'active' : '' }}" href="{{ route('customer_ads') }}"><i class="fal fa-layer-group"></i> My Ads</a></li>
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

                <h5>Customer Job Update</h5><hr>
               
                <form action="" method="post" id="customer_job_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="job_id" id="job_id" value="{{ $job->id }}">

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="" class="control-label">Job Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Chose Job Category</option>
                                    @forelse ($job_categories as $job_category)
                                        <option value="{{ $job_category->id }}" @if ($job->category_id == $job_category->id)
                                            selected
                                        @endif>{{ $job_category->name }}</option>
                                    @empty
                                        <option value="">No data found</option>
                                    @endforelse
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="company_name" class="control-label">Company Name</label>
                                <input type="text" value="{{ $job->company_name }}" name="company_name" id="company_name" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="position" class="control-label">Name of the position</label>
                                <input type="text" value="{{ $job->position }}" name="position" id="position" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="vacancy" class="control-label">Vacancy</label>
                                <input type="text" value="{{ $job->vacancy }}" name="vacancy" id="vacancy" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="qualification" class="control-label">Qualification</label>
                                <input type="text" value="{{ $job->qualification }}" name="qualification" id="qualification" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="location" class="control-label">Location</label>
                                <input type="text" value="{{ $job->location }}" name="location" id="location" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="employement_status" class="control-label">Employment Status</label>
                                <input type="text" value="{{ $job->employement_status }}" name="employement_status" id="employement_status" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="work_place" class="control-label">Work  Place</label>
                                <input type="text" value="{{ $job->work_place }}" name="work_place" id="work_place" class="form-control">
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="control-label">Publish Data</label>
                                <input type="date" value="{{ $job->publish_date }}" name="publish_date" id="publish_date" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="" class="control-label">expire Data</label>
                                <input type="date" value="{{ $job->expire_date }}" name="expire_date" id="expire_date" class="form-control">
                            </div>
                
                            <div class="form-group">
                                <label for="" class="control-label">Salary</label>
                                <input type="text" value="{{ $job->salary }}" name="salary" id="salary" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="" class="control-label">experience</label>
                                <input type="text" value="{{ $job->experience }}" name="experience" id="experience" class="form-control">
                            </div>
                
                            <div class="form-group">
                                <label for="" class="control-label">Image Upload</label>
                                <input type="file" name="image" id="image" class="form-control">
        
                                <br><br><br><br>
                                @if (!empty($job->image))
                                    <div>
                                        <img src="{{ asset('assets/admin/uploads/job/small/'.$job->image) }}" alt="">
                                    </div>
                                @else
                                    <div id="image-holder"></div>
                                @endif
                            </div>
        
                            <div class="form-group">
                                <label for="fresher_status">
                                    <input type="checkbox" name="fresher_status" id="fresher_status" value="{{ $job->fresher_status }}" @if ($job->fresher_status == 1) checked @endif>
                                    Fresher's Encouraged
                                </label>
                            </div>
                        </div>
                
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="Description" class="control-label">Company Description</label>
                                    <textarea name="company_description" id="company_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $job->company_description }}</textarea>
                                </div>
            
                                <div class="form-group col-md-6">
                                    <label for="Description" class="control-label">Job Description</label>
                                    <textarea name="job_description" id="job_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $job->job_description }}</textarea>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="Description" class="control-label">Responsibility Description</label>
                                    <textarea name="responsibility_description" id="responsibility_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $job->responsibility_description }}</textarea>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="Description" class="control-label">Other and benefits</label>
                                    <textarea name="other_benefits" id="other_benefits" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $job->other_benefits }}</textarea>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="Description" class="control-label">Additional Description</label>
                                    <textarea name="additional_description" id="additional_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $job->additional_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
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

            $("#customer_job_edit").on("submit",function (e) {
                e.preventDefault();

                var id = $("#job_id").val();

                var formData = new FormData( $("#customer_job_edit").get(0));

                $.ajax({
                    url : "{{ route('customer_job.update','') }}/"+id,
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

                        localStorage.setItem("customer_info", JSON.stringify(data.customer_info));

                        setTimeout(() => {
                            window.location.href = "{{ route('example1') }}"
                        }, 3000);
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
                                '<button class="close" data-dismiss="alert">??</button>\n' +
                                '<strong>Error! '+err.responseJSON.error+'</strong>' +
                                '</div>');
                        }
                    }
                });
            })
        })
    </script>
@endpush