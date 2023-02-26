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
                    <h3>My info</h3>
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
                                <input type="text" class="form-control" id="level" name="level"
                                    placeholder="Last Name *"
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

                </div>
                <hr>
                <div class="card custom-bdr">
                    <div class="card-body table-responsive">
                        <table id="datatable-request" class="table table-bordered">
                            <thead>
                                <tr>

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
                                            <input class="custom-control-input" type="checkbox"
                                                id="checkallenrollments">
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
            columns: [
 
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
       
    });
</script>