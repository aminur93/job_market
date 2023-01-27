@extends('layouts.admin.master')

@section('page')
    Ads Create
@endsection

@push('css')
    
@endpush

@section('content')
    <form action="" id="ads_post" enctype="multipart/form-data">
        @csrf

        <div class="form-group row col-md-12">
            <label for="">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Select category</option>
                @forelse ($ads_category as $ac)
                    <option value="{{ $ac->id }}">{{ $ac->name }}</option>
                @empty
                    <option value="">No data found</option>
                @endforelse
            </select>
        </div>

        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="">SubCategory</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                <option value="">Select Sub category</option>
                            </select>
                        </div>

                        <div id="form_input_append_left"></div>

                        <div class="form-group row">
                            <label for="description" class="control-label">Description</label>
                            <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 100% !important; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4"> 

                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="">Division</label>
                            <select name="division_id" id="division_id" class="form-control">
                                <option value="">Select Division</option>
                                @forelse ($division as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @empty
                                    <option value="">No data found</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="upzilla" class="control-label">District</label>
                            <select name="district_id" id="district_id" class="form-control">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="">Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="">Unit Price</label>
                            <input type="text" name="unit_price" id="unit_price" class="form-control">
                        </div>

                        <div class="form-group row">
                            <label for="price_on_call">
                                <input type="checkbox" name="price_on_call" id="price_on_call">
                                Price On Call
                            </label>
                        </div>

                        <div id="form_input_append_right"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="">Base Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <br><br>
                            <div id="image-holder" style="text-align: center"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <h6>Gallery Image Upload</h6><hr>
                            <div class="custom-file">
                              <input type="file" name="gallery_image[]" multiple class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                          </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="form-group" style="text-align:center;margin-top:15px">
                            <a href="{{ route('ads') }}" class="btn btn-warning">Back</a>
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

        $("#ads_post").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#ads_post").get(0));

            $.ajax({
                url : "{{ route('ads.store') }}",
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

    $(document).ready(function () {
        $("#division_id").on("change",function () {

            var division_id = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('ads.get_district') }}",
                type: "post",
                data: {division_id:division_id, _token:_token},
                dataType: "json",
                success: function (data) {
                    $.each(data.district, function(index, value) {
                        console.log(value.district_name);
                        $("#district_id").append('<option value="'+value.id+'">'+value.district_name+'</option>');
                    });
                    
                }
            });
        })
    })

    $(document).ready(function(){
        $("#category_id").on("change", function(){

            var category = $(this).val();

            $.ajax({
                url : "{{  route('ads.get_category_value')  }}",
                type: "get",
                data: {category:category},
                dataType: "json",
                success: function(data){

                    $.each(data.sub_cat, function(index, value) {
                        $("#sub_category_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });

                    if(data.category.name == 'Mobile')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(

                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Authenticity</label>'+
                                '<select name="authenticity" id="authenticity" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="original">Original</option>'+
                                    '<option value="refurbished">Refurbished</option>'+
                                '</select>'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Bluetooth</label>'+
                                '<input type="text" name="bluetooth" id="bluetooth" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Camera</label>'+
                                '<input type="text" name="camera" id="camera" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Platform</label>'+
                                '<input type="text" name="platform" id="platform" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Display</label>'+
                                '<input type="text" name="display" id="display" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Memory</label>'+
                                '<input type="text" name="memory" id="memory" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Features</label>'+
                                '<input type="text" name="features" id="features" class="form-control">'+
                            '</div>'
                        )
                    }
                    
                    if(data.category.name == 'Electronics')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").html(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }
                    
                    if(data.category.name == 'Home & Living')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(

                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }
                    
                    if(data.category.name == 'Vehicles & Transportation')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Daily Essential Products')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Health & Beauty')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Garments & Clothing')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Hobbies, Sports & Babies')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Agriculture & Agro Products')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Business & Industry')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Education')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Fuel, Oil & Gas')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Real Estate & Property')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Pet & Animals')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    } 
                    
                    if(data.category.name == 'PM Food Bank & Restaurants')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    } 
                    
                    if(data.category.name == 'Personal Advertisements')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    } 
                    
                    if(data.category.name == 'Companies Product Branding')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }
                    
                    if(data.category.name == 'Service')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }
                    
                    if(data.category.name == 'Tour & Travels')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Local Business Point')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Resort Hotel & Community Centre')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Rent/To-Let')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Land Type</label>'+
                                '<select name="land_type" id="land_type" class="form-control">'+
                                    '<option value="">Select Land Type</option>'+
                                    '<option value="agriculture">Agriculture</option>'+
                                    '<option value="residential">Residential</option>'+
                                    '<option value="commercial">Commercial</option>'+
                                '</select>'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Bedrooms</label>'+
                                '<select name="bedrooms" id="bedrooms" class="form-control">'+
                                    '<option value="">Select Bedrooms</option>'+
                                    '<option value="3">2</option>'+
                                    '<option value="3">3</option>'+
                                    '<option value="4">4</option>'+
                                    '<option value="5">5</option>'+
                                    '<option value="6">6</option>'+
                                '</select>'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Bathrooms</label>'+
                                '<select name="bathrooms" id="bathrooms" class="form-control">'+
                                    '<option value="">Select Bathrooms</option>'+
                                    '<option value="3">2</option>'+
                                    '<option value="3">3</option>'+
                                    '<option value="4">4</option>'+
                                    '<option value="5">5</option>'+
                                    '<option value="6">6</option>'+
                                '</select>'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Size(sqft)</label>'+
                                '<input type="text" name="size" id="size" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Address</label>'+
                                '<input type="text" name="address" id="address" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Land Size</label>'+
                                '<input type="text" name="land_size" id="land_size" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Unit</label>'+
                                '<input type="text" name="unit" id="unit" placeholder="katha, bigha etc" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">House Size</label>'+
                                '<input type="text" name="house_size" id="house_size" class="form-control">'+
                            '</div>'
                        )
                    }

                    if(data.category.name == 'Others')
                    {
                        $("#form_input_append_left").empty('');

                        $("#form_input_append_left").append(
                            '<div class="form-group row">'+
                                '<label for="">title</label>'+
                                '<input type="text" name="title" id="title" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Name</label>'+
                                '<input type="text" name="name" id="name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Brand</label>'+
                                '<input type="text" name="brand_name" id="brand_name" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Model</label>'+
                                '<input type="text" name="model" id="model" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Type</label>'+
                                '<input type="text" name="type" id="type" class="form-control">'+
                            '</div>'+

                            '<div class="form-group row">'+
                                '<label for="">Condition</label>'+
                                '<select name="condition" id="condition" class="form-control">'+
                                    '<option value="">Select Conditions</option>'+
                                    '<option value="new">New</option>'+
                                    '<option value="used">Used</option>'+
                                '</select>'+
                            '</div>'
                        )
                    }
                }
            })
        });
    });

</script>
@endpush