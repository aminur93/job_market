@extends('layouts.admin.master')

@section('page')
    Change Password
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">

        <div id="success_message"></div>

        <div id="error_message"></div>

        <div class="card card-primary">
            <div class="card-header">@yield('page')</div>

            <div class="card-body">
                <form action="" method="post" id="change_password">
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="control-label">New Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="name" class="control-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>


                    <div class="form-group">
                        <a href="{{ route('dashboard') }}" class="btn btn-warning">Back</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        $("#change_password").on("submit",function (e) {
            e.preventDefault();

            var formData = new FormData( $("#change_password").get(0));

            $.ajax({
                url : "{{ route('change_password.update') }}",
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