@extends('layouts.front.master')

@section('page')
    Login
@endsection

@push('css')
    
@endpush

@section('content')
<section class="sign_in_area mt-120 pb-120">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="sign_in_form">
                    <div id="error_message"></div>
                    <div class="sign_title">
                        <h5 class="title">Sign In Now</h5>
                    </div>
                    <form action="#" method="post" id="customer_login_post">
                        @csrf
                        <div class="sign_form_wrapper">
                            <div class="single_form">
                                <input type="text" name="phone" id="phone" placeholder="phone">
                                <i class="fal fa-user"></i>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="single_form">
                                <input type="password" name="password" id="password" placeholder="Password">
                                <i class="fal fa-key"></i>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="single_form d-sm-flex justify-content-between">
                                <div class="sign_checkbox">
                                    <input type="checkbox" id="checkbox">
                                    <label for="checkbox"></label>
                                    <span>Keep me logged in</span>
                                </div>
                                <div class="sign_forgot">
                                    <a href="{{ route('customer_forget_password') }}">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="sign_new">
                                <a href="{{ route('customer_register') }}">New To PublicMarket?</a>
                            </div>
                        </div>
                        <button class="main-btn mt-20 log-in" type="submit">Sign In</button>
                        
                        <div class="modal-break-sign mt-20 mb-20">
                            <div class="row" >
                                <div class="col-5"><hr></div>
                                <div class="col-2"><p>Or</p></div>
                                <div class="col-5" ><hr></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('social.facebook') }}" class="btn btn-danger btn-block">Login Wth Facebook</a>
                            <a href="{{ route('social.google') }}" class="btn btn-primary btn-block">Login Wth Google</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
@endsection

@push('js')
@endpush