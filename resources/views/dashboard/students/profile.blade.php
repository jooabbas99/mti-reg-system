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
                    <h3>Student Details</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create"
                        href="{{ route('student.index') }}"><i class="icon-eye"></i>All Students</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->

<div class="main-content">
 
        @if ($errors->any())
        <div class="validation error">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"
                    id="cross">×</span></button>
            <i class="icon-warning2"></i><strong>Oh snap!</strong><br>
            @foreach ($errors->all() as $error)
            {{ $error }}<br />
            @endforeach
        </div>
        @endif
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <input type="hidden" id="id" name="id" value="{{ isset($student) ? $student->id : '' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row gutters">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstname">first name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="First Name *"
                                        value="{{ isset($student->firstname) ? $student->firstname : '' }}" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastname">last name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name *"
                                        value="{{ isset($student->lastname) ? $student->lastname : '' }}" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <input type="text" class="form-control" id="level" name="level" placeholder="Last Name *"
                                        value="{{ isset($student->level) ? $student->level : '' }}" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="enrolled_passed_course_ids">enrolled passed course</label>
                                    <input type="text" class="form-control" id="enrolled_passed_course_ids" 
                                      value="{{ isset($enrolled_passed_course_ids) ? $enrolled_passed_course_ids : '' }}" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="count_not_enrolled">courses not enrolled</label>
                                    <input type="text" class="form-control" id="count_not_enrolled" 
                                        value="{{ isset($count_not_enrolled) ? $count_not_enrolled : '' }}" />
                                </div>
                            </div>
                        
                        </div>
                        <div id="formmodel">
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="row">
                        <div class="col-6 pt-3 pl-5">
                            <h5 class="card-title ">Semester Course</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="card custom-bdr">
                        <div class="card-body table-responsive">
                            <table id="datatable-current-semester" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>course_code</th>
                                        <th>course_name</th>
                                        <th>semester</th>
                                        <th>level</th>
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
                            <table id="datatable-request" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="checkallenrollments">
                                                <label class="custom-control-label" for="checkallenrollments"></label>
                                            </div>
                                        </th>
                                        <th>Id</th>
                                        <th>course_code</th>
                                        <th>course_name</th>
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

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="row">
                        <div class="col-6 pt-3 pl-5">
                            <h5 class="card-title ">Failed Courses</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="card custom-bdr">
                        <div class="card-body table-responsive">
                            <table id="datatable-failed" class="table table-bordered">
                                <thead>
                                    <tr>
                                        {{-- <th>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="checkallenrollments">
                                                <label class="custom-control-label" for="checkallenrollments"></label>
                                            </div>
                                        </th> --}}
                                        <th>Id</th>
                                        <th>course_code</th>
                                        <th>course_name</th>
                                        <th>semester</th>
                                        <th>Grade</th>
                                        <th>Students Failed</th>
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

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="row">
                        <div class="col-6 pt-3 pl-5">
                            <h5 class="card-title ">Registrations History</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="card custom-bdr">
                        <div class="card-body table-responsive">
                            <table id="datatable-all" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>course_code</th>
                                        <th>course_name</th>
                                        <th>semester</th>
                                        <th>Grade</th>
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
        var table_request = $('#datatable-request').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student.getCurrentRegistrations',$student->id) }}",
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
                
                // {
                //     data: 'student_name',
                //     name: 'student_name',
       
                // },
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
        var table_failed = $('#datatable-failed').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student.getFailedRegistrations',$student->id) }}",
            columns: [
                // {
                //     data: 'check',
                //     name: 'check',
                //     orderable: false,
                //     searchable: false
                // },
 
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
                    data: 'semester',
                    name: 'semester',
       
                },
                {
                    data: 'grade',
                    name: 'grade',
                    // orderable: false,
                    // searchable: false
                },
                {
                    data: 'grade_zero_count',
                    name: 'grade_zero_count',
                    // orderable: false,
                    // searchable: false
                },
                
            ]
        });

        var table_all = $('#datatable-all').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student.getAllRegistrations',$student->id) }}",
            columns: [
                // {
                //     data: 'check',
                //     name: 'check',
                //     orderable: false,
                //     searchable: false
                // },
 
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
                    data: 'semester',
                    name: 'semester',
       
                },
                {
                    data: 'grade',
                    name: 'grade',
                    // orderable: false,
                    // searchable: false
                },

                
            ]
        });
        var table_current_semester = $('#datatable-current-semester').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student.getSemesterCourses',$student->id) }}",
            columns: [

              
                {
                    data: 'course_code',
                    name: 'course_code'
                },
                {
                    data: 'course_name',
                    name: 'course_name'
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
                                table_request.ajax.reload();

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
                                table_request.ajax.reload();

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