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
                    <h3>Open Courses</h3>
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true" id="cross">×</span></button>
            {!! session()->get('success') !!}
        </div>
    @endif

    <!-- Row Select Regular - irregulatr - all -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="btn-group m-2 pl-2 d-flex " >
                    <span>Semesters {{ isset($semester) ? $semester->name : '' }} </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="btn-group mt-2 pr-2 d-flex justify-content-end" style="float:right;">
                    <button id="openBtn" class="btn btn-success btn-sm btn-edit">
                        <i class="icon-check_box"></i>
                        <span class="">Open</span>
                    </button>
                </div>
                <hr>
                <div class="card custom-bdr">
                    <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="checkallcourses">
                                            <label class="custom-control-label" for="checkallcourses"></label>
                                        </div>
                                    </th>
                                    <!--<th>Id</th>-->
                                    <th>ID</th>
                                    <th>code</th>
                                    <th>name</th>
                                    <th>level</th>
                                    <th>semester</th>
                                    <th>pre requsisit</th>
                                    <th>Action</th>
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

        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('supervisor.getRecommendedCourses') }}",
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
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'level',
                    name: 'level'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'pre-requisite',
                    name: 'pre-requisite'
                },
    
                {
                    data: 'action',
                    name: 'action'
                },
               
            ]
        });

        $('#checkallcourses').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".values").prop('checked', true);
            } else {
                $(".values").prop('checked', false);
            }
        });

        $("body").on('click', '.values', function(e) {
            if ($('.values:checked').length == $('.values').length) {
                $('#checkallcourses').prop('checked', true);
            } else {
                $('#checkallcourses').prop('checked', false);
            }
        });

        $('#openBtn').on('click', function(e) {
            var idsArr = [];
            $(".values:checked").each(function() {
                idsArr.push($(this).attr('id'));
            });
            if (idsArr.length <= 0) {
                alert("Please select atleast one course to open.");
                return false;
            } else {
                var check = confirm("Are you sure you want to open this row?");
                if (check == true) {
                    // var join_selected_values = idsArr.join(",");
                    // alert(join_selected_values);
                    $.ajax({
                        url: '{{ route('supervisor.openCourses') }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'courses_ids': idsArr,
                            'semester_id': {{ isset($semester) ? $semester->id : '' }}
                        },
                        success: function(data) {

                            if (data['success'] == true) {
                                $("#checkallcourses").prop('checked', false);
                               alert('Done!!');
                            } else {
                                alert('Something went wrong, Please try again!!');
                            }
                        },
                    });

                } else {
                    $(".values").prop('checked', false);
                    $("#checkallcourses").prop('checked', false);
                }

            }


        });

        $("#cross").on('click', function() {
            $(".validation").hide();
        });
    });
</script>
