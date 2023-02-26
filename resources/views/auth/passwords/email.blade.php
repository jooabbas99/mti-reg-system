@extends('dashboard.layouts.app')

@section('content')
<?php $favicon = favicon(); ?>
    {{-- {{dd(session('message'))}} --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
    <div class="container">
        <form id="SignIn" action="{{ route('password.email') }}" method="post">
            @csrf

            <div class="row justify-content-md-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <div class="login-screen">
                        <div class="login-box text-center">
                            <a href="#" class="login-logo">
                                @if (session('status'))
                                    <div class="alert alert-success" id="success-msg">

                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())

                                    <div class="validation error" id="error_msg">
                                        <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br />
                                        @endforeach

                                    </div>
                                @endif
                                <img src="{{ asset('assets/images/'.$favicon->logo) }}" />
                            </a>

                            <div class="form-group">
                                <input type="email" class="form-control mb-3" id="email" name="email"
                                    placeholder="Email Address *" />
                            </div>
                            <div class="form-group row mb-0" style="margin-left: -50px;">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __(' RESET PASSWORD') }}
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('login') }}" class="additional-link">Have Password? <span>Sign
                                        In</span></a>
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
            $("#success-msg").remove();
            $('#error_msg').remove();
        }, 5000);
    });
</script>
