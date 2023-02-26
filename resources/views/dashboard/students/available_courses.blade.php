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
                            <h5 class="card-title ">Opened Courses To Register</h5>
                        </div>
                        <div class="col-6 ">
                            <div class="btn-group mt-2 pr-2 d-flex justify-content-end">
                                <button id="requestBtn" class="btn btn-success btn-sm btn-edit m-1" style="float:right;">
                                    <i class="icon-check"></i>
                                    <span class="">Request</span>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                    <div class="card custom-bdr">
                        <div class="card-body table-responsive">
                            <table id="datatable-avilable" class="table table-bordered">
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


</div>
<!-- END: .main-content -->
@include('dashboard.layouts.footer')

<script type="text/javascript">
$(document).ready(function() {
        var table_avilable = $('#datatable-avilable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student.getAvailableCourses',$student->id) }}",
            columns: [
                {
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
                    data: 'semester',
                    name: 'semester',
       
                },
                {
                    data: 'level',
                    name: 'level',
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

        $('#requestBtn').on('click', function(e) {
            var idsArr = [];
            $(".values:checked").each(function() {
                idsArr.push($(this).attr('id'));
            });
            if (idsArr.length <= 0) {
                alert("Please select atleast one Course.");
                return false;
            } else {
                var check = confirm("Are you sure you want to Enroll these Courses?");
                if (check == true) {

                    $.ajax({
                        url: '{{ route('student.register') }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'courses_ids' : idsArr
                        },
                        success: function(data) {

                            if (data['success'] == true) {
                                $("#checkallenrollments").prop('checked', false);
                                table_avilable.ajax.reload();

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