@extends('layouts.admin.master')

@section('page')
    Cv Upload
@endsection

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-12">
    <div class="mb-2 text-right">
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> New</button>
    </div>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">All Cv Lists</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row" >

            <div class="col-sm-2" id="cv_list" style="display: flex;align-items: center;gap: 1.5rem;border: 1px solid rgba(0,0,0,.1);">
                @foreach ($cv as $c)
                <a href="{{ route('cv_upload.view','') }}/{{ $c->id }}" target="_blank" style="text-align: center;margin-top:10px;margin-left:15px;margin-bottom: 1rem">
                    <i class="fas fa-file-pdf" style="font-size: 5rem;"></i>
                    <p style="font-size: 10px;">{{ $c->cv }}</p>
                </a>
                <a style="
                  font-size: 10px;
                  position: absolute;
                  margin-top: 7rem;
                  margin-left: 3rem;
                  font-weight: bolder;
                  color: red;
                  cursor: pointer;
                " class="cv_delete" rel="{{ $c->id }}">Delete</a>
                @endforeach
            </div>
            
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cv Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" id="cv_upload_post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
            
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Upload Cv</label>
                    <input type="file" name="cv" class="form-control" id="recipient-name">
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $("#cv_upload_post").on("submit",function (e) {
                e.preventDefault();
                var APP_URL = {!! json_encode(url('/')) !!}
                var formData = new FormData( $("#cv_upload_post").get(0));

                $.ajax({
                    url : "{{ route('cv_upload.store') }}",
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

                        $("#exampleModal").modal('toggle');

                        let cv = data.cv;

                        $("#cv_list").append(
                        '<a href="'+APP_URL+'/assets/admin/uploads/cv/'+cv.cv+'">'+
                            '<i class="fas fa-file-pdf" style="font-size: 5rem;margin-left:15px"></i>'+
                            '<p style="font-size: 10px">'+cv.cv+'</p>'+
                        '</a>'+
                        '<a style="font-size: 10px;position: absolute;margin-top: 7rem;margin-left: 3rem;font-weight: bolder;color: red;cursor: pointer;" class="cv_delete" rel="'+cv.id+'">Delete</a>'
                        );
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

        $(document).ready(function(){
          $(".cv_delete").on("click", function(){

            var id = $(this).attr('rel');

            $.ajax({
              type: "delete",
              url: "{{ route('cv_upload.destroy','') }}/"+id,
              dataType: 'json',
              headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
              success: function (data) {
                  if (data.message){
                      toastr.options =
                          {
                              "closeButton" : true,
                              "progressBar" : true
                          };
                      toastr.success(data.message);
                  }

                  setTimeout(() => {
                    location.reload();
                  }, 3000);
              }
            })
          })
        })
    </script>
@endpush