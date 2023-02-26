@include('dashboard.layouts.header')
<!-- BEGIN .main-heading -->
<?php // set_select(0);
?>
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-cog"></i>
                </div>
                <div class="page-title">
                    <h3>Module Settings</h3>
                </div>
            </div>
            
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create" href="{{ route('modulesetting.index') }}"><i class="icon-eye"></i> View</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    <form id="SignUp" action="{{ isset($user) ? route('modulesetting.update', $user['id']) : route('modulesetting.store') }}" method="post">
        @csrf
        @if ($errors->any())
        <div class="validation error">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" id="cross">×</span></button>
            <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name *" value="{{ isset($user) ? $user['name'] : old('name') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="type" id="attributetype">
                                <option value=" ">Choose Attribute Type</option>
                                @foreach($attribute as $v)
                                <option value="{{$v}}" {{ isset($user) ? ($user['type'] == $v || old('type') == $v)?'selected':'' : '' }}>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control selectpicker" name="validate[]" id="validateattr" multiple="" title="Choose attribute for validation" tabindex="-98">
                                @foreach($validate_attr as $v)
                                <option value="{{$v}}" {{ isset($user) ? (in_array($v, $user['validate_attr']['rules']))?'selected':'' : '' }}>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                <div class="col-md-6 values" style=" <?php if(isset($user['type'])){  if($user['type'] == 'radio(select one)' || $user['type'] == 'checkbox(multiple select)' || $user['type'] == 'select(dropdown)'){?> display:block <?php } } ?> display:none ">
                    <div class="form-group">
                        <input type="text" class="form-control" id="attributevalue" name="attributevalue" placeholder="Attribute Value *" value="{{ isset($user['data']) ? $user['data'] : '' }}" />
                        <label for="type" class="mt-2 pl-2">Enter comma separated string</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 maximum" style="<?php if(isset($user['maximum'])){  echo 'display:block'; }else{  echo 'display:none'; } ?>">
                    <div class="form-group ">
                        <input type="number" class="form-control" id="maximum" name="maximum" placeholder="Maximum Value *" value="{{ isset($user['maximum']) ? $user['maximum'] : old('maximum') }}" />
                    </div>
                </div>
                <div class="col-md-6 minimum" style="<?php if(isset($user['minimum'])){  echo 'display:block'; }else{  echo 'display:none'; } ?>">
                    <div class="form-group ">
                        <input type="number" class="form-control" id="minimum" name="minimum" placeholder="Minimum Value *" value="{{ isset($user['minimum']) ? $user['minimum'] : old('minimum') }}" />
                    </div>
                </div>
            </div> 

            <div class="actions clearfix">
                <button type="submit" id="cms_submit" class="btn btn-primary validator"><span class="icon-save2"></span> Submit</button>
            </div>
        </div>
</div>
</form>
</div>
<!-- END: .main-content -->
@include('dashboard.layouts.footer')
<script>
    $(document).ready(function () {
        $("#attributetype").on('change', function () {
            var type1 = $(this).val();
            if (type1 == "radio(select one)" || type1 == "checkbox(multiple select)" || type1 ==
                    "select(dropdown)") {
                $('.values').show();
            } else {
                $('.values').hide();
            }
        });
        var type1 = $("#validateattr").val();
        if ($("#attributevalue").val()) {
            $('.values').show();
        }
        if ($('#maximum').val() && jQuery.inArray('max_length', type1) != '-1') {
            $('.maximum').show();
        }
        if ($('#minimum').val() && jQuery.inArray('min_length', type1) != '-1') {
            $('.minimum').show();
        }
        $("#validateattr").on('change', function () {
            var typevalue = $(this).val();
            if (jQuery.inArray('max_length', typevalue) == '-1' && jQuery.inArray('min_length',
                    typevalue) == '-1') {
                $('.maximum').hide();
                $('.minimum').hide();
            } else {
                for (var i = 0; i < typevalue.length; i++) {
                    if (typevalue[i] == "min_length") {
                        $('.minimum').show();
                        $('.maximum').hide();
                    }
                    if (typevalue[i] == "max_length") {
                        $('.maximum').show();
                        $('.minimum').hide();
                    }
                    if (jQuery.inArray('max_length', typevalue) != '-1' && jQuery.inArray('min_length',
                            typevalue) != '-1') {
                        $('.maximum').show();
                        $('.minimum').show();
                    }
                }
            }
        });

    });
</script>