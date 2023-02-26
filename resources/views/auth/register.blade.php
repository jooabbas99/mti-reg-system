@extends('dashboard.layouts.app')

@section('content')
<?php $favicon = favicon(); ?>
    <link rel="stylesheet" href="assets/admin/css/main.css" />
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row justify-content-md-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="login-screen">
                        <div class="login-box">
                            <a href="#" class="login-logo text-center">
                                <img src="{{ asset('assets/images/'. $favicon->logo) }}" />
                            </a>
                            @if ($errors->any())
                                <div class="validation error" id="error_msg">
                                    <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br />
                                    @endforeach
                                </div>
                            @endif

                            <div class="card-body">

                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-3" id="firstname" name="firstname"
                                                placeholder="First Name *" value="{{ old('firstname') }}" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-3" id="lastname" name="lastname"
                                                placeholder="Last Name *" value="{{ old('lastname') }}" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-3" id="username" name="username"
                                                placeholder="User Name *" value="{{ old('username') }}" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input id="password" type="password"
                                                class="form-control"
                                                placeholder="Password *" name="password"
                                                autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input id="password_confirmation" type="password" class="form-control mb-3"
                                                name="password_confirmation" placeholder="Confirm Password *"
                                                autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input id="email" type="email"
                                                class="form-control mb-3" name="email"
                                                value="{{ old('email') }}" placeholder="User Email *"
                                                autocomplete="email">
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="d-grid gap-2 col-12 mx-auto">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __(' SIGN UP') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('login') }}" class="additional-link">Have an Account?
                                            <span>Sign In
                                                Now</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

<script src="{{asset('assets/admin/js/jquery.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.validate.js')}}"></script>

<script>
    $(document).ready(function() {
        $("#cross").on('click', function() {
            $(".validation").hide();
        });

        setTimeout(function() {
            $('#error_msg').remove();
        }, 5000);
    });
</script>
