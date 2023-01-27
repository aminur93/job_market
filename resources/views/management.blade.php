@extends('layouts.front.master')

@section('page')
    Management
@endsection

@push('css')
    
@endpush

@section('content')
<section class="team-area team-sec" id="teams">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-heading text-center">
                    <h2>Our <span>Team</span></h2>
                    <h4>Meet our awesome and expert team members</h4>
                </div>
            </div>
        </div>
        <div class="row team-items">
            @forelse ($team as $t)
            <div class="col-md-4 single-item">
                <div class="item">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ $t['image'] }}" alt="Thumb" style="width:777px;height:424px">
                        <div class="overlay">
                            <h4>{{ $t['company_name'] }}</h4>
                            <p>
                                {{ $t['details'] }}
                            </p>
                            <div class="social">
                                <ul>
                                    <li class="twitter">
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li class="pinterest">
                                        <a href="#"><i class="fab fa-pinterest"></i></a>
                                    </li>
                                    <li class="instagram">
                                        <a href="#"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li class="vimeo">
                                        <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                                <span class="message">
                                    <a href="#"><i class="fas fa-envelope-open"></i></a>
                                </span>
                        <h4>{{ $t['company_name'] }}</h4>
                        <span>{{ $t['position'] }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-4 single-item">
                No Data Found
            </div>
            @endforelse
            
        </div>
    </div>
</section>

@endsection

@push('js')
    
@endpush