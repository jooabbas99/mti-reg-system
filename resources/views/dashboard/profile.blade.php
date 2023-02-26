@include('dashboard.layouts.header')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-user"></i>
                </div>
                <div class="page-title">
                    <h3>Profile</h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    <form id="SignUp" action="{{route('admin.storeProfile')}}" method="post" enctype="multipart/form-data">
        @csrf
        @if (session()->has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true" id="cross">×</span></button>
            {!! session()->get('success') !!}
        </div>
    @endif
         @if ($errors->any())
            <div class="validation error">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true" id="cross">×</span></button>
                <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br />
                @endforeach
            </div>
        @endif
        @if (Auth::user()->role == 1)
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">

                        @if ($user->image != '')

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <!-- Gallery start -->
                                    <div class="baguetteBoxThree gallery">
                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                                @if ($user->image_flag == '0')
                                                    <a href="{{ asset('assets/images/' . $user->image) }}"
                                                        class="effects">
                                                        <img src="{{ asset('assets/images/' . $user->image) }}"
                                                            class="img-responsive">
                                                        <div class="overlay">
                                                            <span class="expand">+</span>
                                                        </div>
                                                    </a>

                                                @else
                                                    <a href="{{ asset('assets/images/' . $user->image) }}"
                                                        class="effects">
                                                        <img src="{{ asset('assets/images/' . $user->image) }}"
                                                            class="img-responsive">
                                                        <div class="overlay">
                                                            <span class="expand">+</span>
                                                        </div>
                                                    </a>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="First Name *"
                                    value="{{ isset($user->firstname) ? $user->firstname : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="Last Name *"
                                    value="{{ isset($user->lastname) ? $user->lastname : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username *"
                                    value="{{ isset($user->username) ? $user->username : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" />
                                <label class="custom-file-label custom-file-label-primary" for="image">Choose
                                    file</label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address *"
                                    value="{{ isset($user->email) ? $user->email : '' }}" readonly="true" />
                            </div>
                        </div>
                    </div>
                     <div id="div1">
            		</div>
                    <div class="actions clearfix">
                        <button type="submit" class="btn btn-primary"><span class="icon-save2"></span>
                            @if ($result['method'] == 'add')
                                Save
                            @else
                                Update
                            @endif
                        </button>
                    </div>

                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">

                        @if ($user->image != '')

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <!-- Gallery start -->
                                    <div class="baguetteBoxThree gallery">
                                        <!-- Row start -->
                                        <div class="row gutters">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                                @if ($user->image_flag == '0')
                                                    <a href="{{ asset('assets/images/user.png') }}"
                                                        class="effects">
                                                        <img src="{{ asset('assets/images/user.png') }}"
                                                            class="img-responsive">
                                                        <div class="overlay">
                                                            <span class="expand">+</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="{{ asset('assets/images/' . $user->image) }}"
                                                        class="effects">
                                                        <img src="{{ asset('assets/images/' . $user->image) }}"
                                                            class="img-responsive">
                                                        <div class="overlay">
                                                            <span class="expand">+</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input type="text" name="id" value="{{ auth()->user()->id }}" hidden>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="First Name *"
                                    value="{{ isset($user->firstname) ? $user->firstname : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="Last Name *"
                                    value="{{ isset($user->lastname) ? $user->lastname : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username *"
                                    value="{{ isset($user->username) ? $user->username : '' }}" />
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" />
                                <label class="custom-file-label custom-file-label-primary" for="image">Choose
                                    file</label>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address *"
                                    value="{{ isset($user->email) ? $user->email : '' }}" readonly="true" />
                            </div>
                        </div>
                    </div>
                     <div id="div1">
            		</div>
                    <div class="actions clearfix">
                        <button type="submit" class="btn btn-primary"><span class="icon-save2"></span>
                            @if ($result['method'] == 'add')
                                Save
                            @else
                                Update
                            @endif
                        </button>
                    </div>

                </div>
            </div>
        @endif
    </form>
</div>
<!-- END: .main-content -->
@include('dashboard.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput: false,
            maxDate: 'now()',
        });
        //$(".validation").hide();
        $("#SignUp").on('submit', function(e) {
            //prevent Default functionality
            e.preventDefault();

            //get the action-url of the form
            var actionurl = e.currentTarget.action;
            //do your own request an handle the results
            $.ajax({
                url: actionurl,
                type: 'post',
                data: $("#SignUp").serialize(),
                success: function(data) {
                    var d = JSON.parse(data);
                    if (d.status === false) {
                        $(".validation").show();
                        var html =
                            '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" id="cross">×</span></button><i class="icon-warning2"></i><strong>Oh snap!</strong><ul></ul></div>';
                        $(".validation").html(html);
                        $(".validation").find("ul").html(d.validation);
                    } else {
                        window.location = "url('admin/user')";
                    }
                }
            });

        });

        $("#cross").on('click', function() {
            $(".validation").hide();
        })
        var id = 'user';
       var url = "{{route('modulesetting.editattribute',Auth::user()->id)}}";

       $.ajax({

        "url": url,
        success: function(data){
            if(data != "false"){
                $("#div1").html(data);
            }
            },
      
 	}); 

    });
</script>
