@extends('layouts.admin.master')

@section('page')
    Profile
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">

    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                @if(auth()->user()->profile_image != null)
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/admin/uploads/user/small/'.auth()->user()->profile_image) }}" alt="User profile picture">
                    </div>
                @else
                    <div class="text-center" v-else>No image Found</div>
                @endif

                <h3 class="profile-username text-center"></h3>

                <p class="text-muted text-center"></p>
                <hr>

                <ul class="list-group list-group-unbordered mb-3">
                    <strong style="margin-left: 10px"><i class="fas fa-book mr-1"></i> Email</strong>

                    <p class="text-muted"  style="margin-left: 10px">
                        {{ auth()->user()->email }}
                    </p>

                    <strong style="margin-left: 10px"><i class="fas fa-book mr-1"></i> Name</strong>

                    <p class="text-muted"  style="margin-left: 10px">
                        {{ auth()->user()->name }}
                    </p>

                    <strong style="margin-left: 10px"><i class="fas fa-book mr-1"></i> Company Name</strong>

                    <p class="text-muted"  style="margin-left: 10px">
                        Public Market
                    </p>

                </ul>

                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-block"><b>Back</b></a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><p class="nav-link">Edit Your Information</p></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">

                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="post" id="profile_update">
                            @method('PUT')
                            @csrf

                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10" style="margin-top: 5px">
                                        <input type="text" value="{{ auth()->user()->name }}" class="form-control" name="name" placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10" style="margin-top: 5px">
                                        <input type="email" value="{{ auth()->user()->email }}" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10" style="margin-top: 5px">
                                        <input type="file" class="form-control" name="profile_image">
                                        <input type="hidden" value="{{ auth()->user()->profile_image }}" name="current_image">

                                        <br>

                                        @if(auth()->user()->profile_image != null)
                                            <img src="{{ asset('assets/admin/uploads/user/small/'.auth()->user()->profile_image) }}" alt="">
                                        @else
                                            <div>No image found</div>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection

@push('js')
    <script>
    $(document).ready(function () {

        $("#profile_update").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#profile_update").get(0));

            $.ajax({
                url : "{{ route('profile.update') }}",
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

                error : function (err) {
                    if (err.status === 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="'+i+'"]');
                            el.after($('<span class="valids" style="color: red;">'+error+'</span>'));
                        });
                    }
                }
            });
        })
    })
</script>
@endpush