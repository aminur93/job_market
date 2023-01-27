@extends('layouts.admin.master')

@section('page')
    Ads Pricing
@endsection

@push('css')
<style type="text/css">
    /* Basic Rules */
    .switch input {
        display:none;
    }
    .switch {
        display:inline-block;
        width:55px;
        height:25px;
        margin:8px;
        transform:translateY(50%);
        position:relative;
    }
    /* Style Wired */
    .slider {
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
        border-radius:30px;
        box-shadow:0 0 0 2px #777, 0 0 4px #777;
        cursor:pointer;
        border:4px solid transparent;
        overflow:hidden;
        transition:.4s;
    }
    .slider:before {
        position:absolute;
        content:"";
        width:100%;
        height:100%;
        background:#777;
        border-radius:30px;
        transform:translateX(-30px);
        transition:.4s;
    }

    input:checked + .slider:before {
        transform:translateX(30px);
        background:limeGreen;
    }
    input:checked + .slider {
        box-shadow:0 0 0 2px limeGreen,0 0 2px limeGreen;
    }

    /* Style Flat */
    .switch.flat .slider {
        box-shadow:none;
    }
    .switch.flat .slider:before {
        background:#FFF;
    }
    .switch.flat input:checked + .slider:before {
        background:white;
    }
    .switch.flat input:checked + .slider {
        background:limeGreen;
    }
    .patch{
        margin-top: -25px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
            <a href="{{ route('ads_price.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add @yield('page')</a>
            <h3 class="card-title">@yield('page')</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="data-table" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th>#Sl No</th>
              <th>Start Price</th>
              <th>End Price</th>
              <th>Single Month</th>
              <th>Title</th>
              <th>Description</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#Sl No</th>
                <th>Start Price</th>
                <th>End Price</th>
                <th>Single Month</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
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
                url: '{!!  route('ads_price.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'start_price', name: 'start_price'},
                {data: 'end_price', name: 'end_price'},
                {data: 'single_month', name: 'single_month'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'status', name: 'status'},
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

<script>
    $(document).on('change','.status_toggle', function (e) {
        e.preventDefault();

        var id = $(this).attr('value');

        $.ajax({
            type: "GET",
            url: "{{ route('ads_price.status_change','') }}/"+id,
            dataType: 'json',
            success: function (data) {
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
    })
</script>
@endpush