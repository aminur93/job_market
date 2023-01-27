@extends('layouts.admin.master')

@section('page')
    Subscriber
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
            {{-- <a href="{{ route('division.create') }}" class="btn btn-sm btn-primary  float-right"><i class="fas fa-plus"></i> Add @yield('page')</a> --}}
            <h3 class="card-title">@yield('page')</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="data-table" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th>#Sl No</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#Sl No</th>
                <th>Email</th>
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
                url: '{!!  route('subscriber.getData') !!}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });
</script>
@endpush