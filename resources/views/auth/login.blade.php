@extends('dashboard.layouts.app')

@section('content')
<?php $favicon = favicon(); ?>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="row justify-content-md-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <div class="login-screen">
                        <div class="login-box">
                            <a href="#" class="login-logo text-center">
                                <img src="{{ asset('assets/images/'.$favicon->logo) }}" />
                            </a>
                            @if ($errors->any())
                                <div class="validation error" id="error_msg">
                                    <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br />
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="email" class="form-control mb-3" id="email" name="email"
                                    placeholder="User Email *" value="{{ old('email') }}" />

                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control mb-3"
                                    id="password" name="password" placeholder="Password *" />

                            </div>
                            <div class="form-group row mb-0">
                                <div class="d-grid gap-2 col-12 mx-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __(' SIGN IN') }}
                                    </button>

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
