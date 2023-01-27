@extends('layouts.admin.master')

@section('page')
    Job Create
@endsection

@push('css')
    
@endpush

@section('content')
<form action="" id="job_post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="" class="control-label">Job Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chose Job Category</option>
                            @forelse ($job_categories as $job_category)
                                <option value="{{ $job_category->id }}">{{ $job_category->name }}</option>
                            @empty
                                <option value="">No data found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="company_name" class="control-label">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="position" class="control-label">Name of the position</label>
                        <input type="text" name="position" id="position" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="vacancy" class="control-label">Vacancy</label>
                        <input type="text" name="vacancy" id="vacancy" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="qualification" class="control-label">Qualification</label>
                        <input type="text" name="qualification" id="qualification" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="location" class="control-label">Location</label>
                        <input type="text" name="location" id="location" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="employement_status" class="control-label">Employment Status</label>
                        <input type="text" name="employement_status" id="employement_status" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="work_place" class="control-label">Work  Place</label>
                        <input type="text" name="work_place" id="work_place" class="form-control">
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="control-label">Publish Data</label>
                        <input type="date" name="publish_date" id="publish_date" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="" class="control-label">expire Data</label>
                        <input type="date" name="expire_date" id="expire_date" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="control-label">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="" class="control-label">experience</label>
                        <input type="text" name="experience" id="experience" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="control-label">Image Upload</label>
                        <input type="file" name="image" id="image" class="form-control">

                        <br><br><br><br>
                        <div id="image-holder" style="text-align: center"></div>
                    </div>

                    <div class="form-group row">
                        <label for="fresher_status">
                            <input type="checkbox" name="fresher_status" id="fresher_status">
                            Fresher's Encouraged
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="Description" class="control-label">Company Description</label>
                            <textarea name="company_description" id="company_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
    
                        <div class="form-group col-md-6">
                            <label for="Description" class="control-label">Job Description</label>
                            <textarea name="job_description" id="job_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Description" class="control-label">Responsibility Description</label>
                            <textarea name="responsibility_description" id="responsibility_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Description" class="control-label">Other and benefits</label>
                            <textarea name="other_benefits" id="other_benefits" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="Description" class="control-label">Additional Description</label>
                            <textarea name="additional_description" id="additional_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 800px !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        
                    </div>

                    <div class="form-group" style="text-align:right">
                        <a href="{{ route('job') }}" class="btn btn-warning">Back</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</form>

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

        $("#job_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#job_post").get(0));

            $.ajax({
                url : "{{ route('job.store') }}",
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