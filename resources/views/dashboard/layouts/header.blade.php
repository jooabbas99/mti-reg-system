<!doctype html>
<html lang="en">

<head>
    <?php $favicon = favicon(); ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets/images/'. $favicon->favicon) }}" />
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
    <!-- Icomoon Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/fonts/icomoon/icomoon.css') }}" />
    <!-- Master CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}" />
    <!-- custom style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}" />
    <!-- Gallery CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/gallery/gallery.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bs-select.css') }}" />
    <link href="{{ asset('assets/admin/css/bootstrap-editable.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/fonts/font-awesome/font-awesome.min.css') }}" />
    <!-- jQuery JS. -->
    <script src="{{ asset('assets/admin/js/jquery.js') }}"></script>
    <!-- Tether js, then other JS. -->
    <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/c3.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bs-select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.validate.js') }}"></script>
</head>

<body>
    <!-- Loading start -->
    <div id="loading-wrapper">
        <div id="loader"></div>
    </div>
    <!-- Loading end -->
    <!-- BEGIN .app-wrap -->
    <div class="app-wrap">
        <!-- BEGIN .app-heading -->
        <header class="app-header">
            <!-- Container fluid starts -->
            <div class="container-fluid">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-7 col-7">
                        <!-- BEGIN .logo -->
                        <div class="logo-block">
                            <a href="#" class="logo">

                                <img src="{{ asset('assets/images/'.$favicon->logo) }}" />

                            </a>

                            <a class="mini-nav-btn" href="javascript:void(0);" id="onoffcanvas-nav">
                                <i class="open"></i>
                                <i class="open"></i>
                                <i class="open"></i>
                            </a>
                            <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler"
                                aria-expanded="true">
                                <i class="open"></i>
                                <i class="open"></i>
                                <i class="open"></i>
                            </a>
                        </div>
                        <!-- END .logo -->
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-5 col-5">
                        <!-- Header actions start -->
                        <ul class="header-actions">
                            <li class="dropdown">
                                <a href="{{ asset('assets/images/user.png') }}" id="userSettings"
                                    class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                    <!-- <span class="avatar"><?php //echo substr($admin['firstname'],0,1).substr($admin['lastname'],0,1);?></span> -->

                                    <div class="avatar avatar-img">

                                        @if (Auth::user()->role == '1')

                                            <img src="{{ asset('assets/images/' . auth()->user()->image) }}" />

                                        @else

                                            <img src="{{ asset('assets/images/user.png') }}" />

                                        @endif
                                    </div>
                                    <span class="user-name"> {{ Auth::user()->firstname }}
                                        {{ Auth::user()->lastname }}</span>
                                    <i class="icon-chevron-small-down downarrow"></i>
                                </a>
                                <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                                    <div class="admin-settings">

                                        @if (Auth::user()->login_type == '1')

                                            <ul class="admin-settings-list">
                                                <li>
                                                    <a href="{{ route('admin.profile') }}">
                                                        <span class="icon icon-user"></span>
                                                        <span class="text-name">Profile</span>
                                                    </a>
                                                </li>

                                                @if (Auth::user()->role != '1')

                                                    <li>
                                                        <a href="{{ route('admin.change_password') }}">
                                                            <span class="icon icon-cog"></span>
                                                            <span class="text-name">Change Password</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif

                                        <div class="actions">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="btn btn-primary btn-block" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                     this.closest('form').submit();">
                                                    <span class="icon-log-out"></span>
                                                    {{ __('Sign Out') }}
                                                </a>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- Header actions end -->
                    </div>
                </div>
                <!-- Row start -->
            </div>
            <!-- Container fluid ends -->
        </header>
        <!-- END: .app-heading -->
        <!-- BEGIN .app-container -->
        <div class="app-container">
            @include('dashboard.layouts.sidebar')
