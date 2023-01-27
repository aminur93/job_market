@extends('layouts.admin.master')

@section('page')
    Permission
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="success_message"></div>

        <div id="error_message"></div>

        <div class="card">
            <div class="card-header">
                <a href="{{ route('permission.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add Permissions</a>
                <h3 class="card-title">@yield('page')</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#Sl NO</th>
                        <th>Model Name</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#Sl NO</th>
                        <th>Model Name</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){

        $('#data-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            pagingType: "full_numbers",
            ajax: {
                url: '{!!  route('permission.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'permission_model_name', name: 'permission_model_name'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });
</script>

<script>
    $(document).on('click','.deleteRecord', function(e){
        e.preventDefault();
        var id = $(this).attr('rel');
        var deleteFunction = $(this).attr('rel1');
        swal({
                title: "Are You Sure?",
                text: "You will not be able to recover this record again",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete It"
            },
            function(){
                $.ajax({
                    type: "DELETE",
                    url: deleteFunction+'/'+id,
                    data: {id:id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {

                        $('#data-table').DataTable().ajax.reload();

                        if (data.message){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                };
                            toastr.success(data.message);
                        }
                    }
                });
            });
    });
</script>
@endpush