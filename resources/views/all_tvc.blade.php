@extends('layouts.front.master')

@section('page')
    All Tvc
@endsection

@push('css')
    
@endpush

@section('content')
<section class="location_area pt-40 pb-120 mb-120" id="tvc">
    <div class="container pt-60">
        <div class="row">
            <div class="col-lg-6">
                <div class="section_title pb-15">
                    <h3 class="title" style="font-size: 40px">View All Commercials</h3> </div>
            </div>
            <div class="col-lg-6">
                <form class="d-flex commercial-search">
                    <input class="form-control me-2 product-top-search" type="search" placeholder="Search For A Commercial" aria-label="Search">
                    <button class="btn btn-outline-search" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center pt-40">
            @forelse ($tvc as $tv)
            <div class="col-lg-4 col-md-7">
                <div class="single_blog mt-30">
                    <div class="blog_image">
                        <video width="360" height="240" controls title="Our video player">
                            <source src="{{asset('assets/admin/uploads/tvc/'.$tv->video)}}" type="video/mp4">
                        </video> </div>
                    <div class="blog_content">
                        <h4 class="title text-center"><a href="{{ route('front.tvc_details','') }}/{{ $tv->id }}" class="tvc_count" rel1="{{ $t->id }}">{{ $tv->tvc_title }}</a></h4>
                        <ul class="meta">
                            <li><i class="fal fa-clock"></i><a href="#">{{ \Carbon\Carbon::parse($tv->created_at)->format('j F, Y') }}</a></li>
                            <li><a class="view-count" href="#"><span class="line"></span> <i class="fas fa-eye show"></i> {{ $tv->view_count }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-4 col-md-7">
                No data found
            </div>
            @endforelse

            <div class="col-lg-12 pt-10">
                <div class="pagination_wrapper mt-50">
                    <ul class="pagination justify-content-center">
                        {{ $tvc->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
    $(document).ready(function(){

        $(".tvc_count").on('click', function(){

            var id = $(this).attr('rel1');

            $.ajax({
                url: "{{ route('front.tvc_view_count') }}",
                type: "GET",
                data: {id: id},
                dataType: "json",
                success: function(data){
                    console.log(data);
                }
            })
        })
    })
</script>
@endpush