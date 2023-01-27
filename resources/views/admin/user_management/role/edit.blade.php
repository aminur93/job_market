@extends('layouts.admin.master')

@section('page')
    Role Edit
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
                <form action="" method="post" id="role_edit">
                    @method('PUT')
                    @csrf

                    <input type="hidden" name="" id="role_id" value="{{ $role->id }}">

                    <div class="form-group row">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" value="{{ $role->name }}" name="name" id="name" class="form-control">
                    </div>

                    <strong>Permission:</strong><hr>
                
                    <div class="row">
                        @foreach ($model_array as $key => $ma)
                            <div class="col-md-3">
                                <h6>{{ $key }}</h6>
                                @foreach ($ma as $m)
                                
                                    <label style="display: block">
                                        <input type="checkbox" name="permissions[]" value="{{ $m['id'] }}" @if(in_array($m['id'], $rolePermissions)) checked @endif> {{ $m['name'] }}
                                    </label>
                                
                                @endforeach
                            </div>
                           
                        @endforeach
                    </div>
                    

                    <div class="form-group">
                        <a href="{{ route('role') }}" class="btn btn-warning">Back</a>
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
        $("#role_edit").on("submit", function (e) {
            e.preventDefault();

            var role_id = $("#role_id").val();

            var formData = $("#role_edit").serializeArray();

            $.ajax({
                url: "{{ route('role.update','') }}/"+role_id,
                type: "PUT",
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