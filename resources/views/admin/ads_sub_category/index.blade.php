@extends('layouts.admin.master')

@section('page')
    Ads Sub Category
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
            <a href="{{ route('sub_category.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add @yield('page')</a>
            <h3 class="card-title">@yield('page')</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="data-table" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th>#Sl No</th>
              <th>Category name</th>
              <th>Sub Category Name</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#Sl No</th>
                <th>Category name</th>
                <th>Sub Category Name</th>
                <th>Actions</th>
            </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
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
                url: '{!!  route('sub_category.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
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

                        if(data.flash_message_success) {
                            $('#success_message').html('<div class="alert alert-success">\n' +
                                '<button class="close" data-dismiss="alert">×</button>\n' +
                                '<strong>Success! '+data.flash_message_success+'</strong> ' +
                                '</div>');
                        }
                    }
                });
            });
    });
</script>
@endpush