@extends('dashboard.layouts.app')

@section('content')
<?php $favicon = favicon(); ?>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
    <div class="container">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="row justify-content-md-center">
               
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <div class="login-screen">
                        <div class="login-box text-center">
                            <a href="#" class="login-logo">
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

                            <input type="text" name="email" value="{{ $_GET['email'] }}" hidden>
                            <div class="form-group">
                                <input type="password" class="form-control mb-3" id="password" name="password"
                                    placeholder="Password *" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control mb-3" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password *" />
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="actions" style="margin-left: 84px;">
                                <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-sign-out"></span>
                                    Reset Password</button>
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
        setTimeout(function() {
        $(".alert-success").remove();
        }, 5000);

        setTimeout(function() {
        $("#error_msg").remove();
        }, 5000);
    });
</script>
