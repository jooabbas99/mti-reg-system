@include('dashboard.layouts.header')

<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-users"></i>
                </div>
                <div class="page-title">
                    <h3>Students</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create"
                        href="{{ route('student.create') }}"><i class="icon-plus"></i> Add Students</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

    @if (session()->has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"
                id="cross">×</span></button>
        {!! session()->get('success') !!}
    </div>
    @endif
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="row">
                        <div class="col-6 pt-3 pl-5">
                            <h5 class="card-title ">Current Registration</h5>
                        </div>
                        <div class="col-6 ">
                            <div class="btn-group mt-2 pr-2 d-flex justify-content-end">
                                <button id="approveBtn" class="btn btn-success btn-sm btn-edit m-1" style="float:right;">
                                    <i class="icon-check"></i>
                                    <span class="">Approve Request</span>
                                </button>
                                <button id="cancelBtn" class="btn btn-danger btn-sm btn-edit m-1" style="float:right;">
                                    <i class="icon-cross"></i>
                                    <span class="">Cancel Request</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <hr>
                <div class="card custom-bdr">
                    <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="checkalluser">
                                            <label class="custom-control-label" for="checkalluser"></label>
                                        </div>
                                    </th>
                                    <th>Id</th>
                                    <th>course_code</th>
                                    <th>course_name</th>
                                    <th>student_name</th>
                                    <th>semester</th>
                                    <th>level</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: .main-content -->
@include('dashboard.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('supervisor.getRegistrations') }}",
            columns: [{
                    data: 'check',
                    name: 'check',
                    orderable: false,
                    searchable: false
                },
 
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'course_code',
                    name: 'course_code'
                },
                {
                    data: 'course_name',
                    name: 'course_name'
                },
                
                {
                    data: 'student_name',
                    name: 'student_name',
       
                },
                {
                    data: 'semester',
                    name: 'semester',
       
                },
                {
                    data: 'level',
                    name: 'level',
                    // orderable: false,
                    // searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    // orderable: false,
                    // searchable: false
                },
            ]
        });

        $('#checkallenrollments').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".values").prop('checked', true);
            } else {
                $(".values").prop('checked', false);
            }
        });

        $("body").on('click', '.values', function(e) {
            if ($('.values:checked').length == $('.values').length) {
                $('#checkallenrollments').prop('checked', true);
            } else {
                $('#checkallenrollments').prop('checked', false);
            }
        });

        $('#approveBtn').on('click', function(e) {
            var idsArr = [];
            $(".values:checked").each(function() {
                idsArr.push($(this).attr('id'));
            });
            if (idsArr.length <= 0) {
                alert("Please select atleast one Enrollemnt to Approve.");
                return false;
            } else {
                var check = confirm("Are you sure you want to Approve this Enrollemnts?");
                if (check == true) {
                    //var join_selected_values = idsArr.join(",");
                    //alert(join_selected_values);
                    $.ajax({
                        url: '{{ route('supervisor.approveRegistration') }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'enrollments_ids' : idsArr
                        },
                        success: function(data) {

                            if (data['success'] == true) {
                                $("#checkallenrollments").prop('checked', false);
                                table.ajax.reload();

                            } else {
                                alert('Something went wrong, Please try again!!');
                            }
                        },
                    });

                } else {
                    $(".values").prop('checked', false);
                    $("#checkallenrollments").prop('checked', false);
                }

            }


        });

        $('#cancelBtn').on('click', function(e) {
            var idsArr = [];
            $(".values:checked").each(function() {
                idsArr.push($(this).attr('id'));
            });
            if (idsArr.length <= 0) {
                alert("Please select atleast one Enrollemnt to cancel.");
                return false;
            } else {
                var check = confirm("Are you sure you want to cancel this Enrollemnts?");
                if (check == true) {
                    //var join_selected_values = idsArr.join(",");
                    //alert(join_selected_values);
                    $.ajax({
                        url: '{{ route('supervisor.cancelRegistration') }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'enrollments_ids' : idsArr
                        },
                        success: function(data) {

                            if (data['success'] == true) {
                                $("#checkallenrollments").prop('checked', false);
                                table.ajax.reload();

                            } else {
                                alert('Something went wrong, Please try again!!');
                            }
                        },
                    });

                } else {
                    $(".values").prop('checked', false);
                    $("#checkallenrollments").prop('checked', false);
                }

            }


        });

        $("#cross").on('click', function() {
            $(".validation").hide();
        });
    });
</script>