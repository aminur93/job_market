@extends('layouts.admin.master')

@section('page')
    User Edit
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
                <form action="" method="post" id="user_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" id="user_id" value="{{ $user->id }}">

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="number" name="phone" id="phone" value="{{ $user->phone }}" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group row">
                        <label for="role" class="control-label">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('user') }}" class="btn btn-warning">Back</a>
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
        $("#user_edit").on("submit", function (e) {
            e.preventDefault();

            var user_id = $("#user_id").val();

            var formData = $("#user_edit").serializeArray();

            $.ajax({
                url: "{{ route('user.update','') }}/"+user_id,
                type: "POST",
                data: $.param(formData),
                dataType: "json",
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