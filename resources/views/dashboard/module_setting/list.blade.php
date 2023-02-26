@include('dashboard.layouts.header')
<!-- BEGIN .main-heading -->

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
                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create"
                        href="{{ route('modulesetting.create') }}"><i class="icon-plus"></i> Add Module's
                        Attribute</a>
                </div>
            </div>

        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="btn-group mt-2 pr-2 d-flex justify-content-end" style="float:right;">
                    <button id="delBtn" class="btn btn-danger btn-sm btn-edit">
                        <i class="icon-trash2"></i>
                        <span class="">Delete</span>
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
                                            <input class="custom-control-input" type="checkbox" id="checkalluser">
                                            <label class="custom-control-label" for="checkalluser"></label>
                                        </div>
                                    </th>

                                    <!--<th>Id</th>-->
                                    <th>Name</th>
                                    <th>Type</th>
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
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('modulesetting.index') }}",
            columns: [{
                    data: 'check',
                    name: 'check',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#checkalluser').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".values").prop('checked', true);
            } else {
                $(".values").prop('checked', false);
            }
        });

        $("body").on('click', '.values', function(e) {
            if ($('.values:checked').length == $('.values').length) {
                $('#checkalluser').prop('checked', true);
            } else {
                $('#checkalluser').prop('checked', false);
            }
        });

        $('#delBtn').on('click', function(e) {
            var idsArr = [];
            $(".values:checked").each(function() {
                idsArr.push($(this).attr('id'));
            });
            if (idsArr.length <= 0) {
                alert("Please select atleast one record to delete.");
                return false;
            } else {
                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {
                    //var join_selected_values = idsArr.join(",");
                    //alert(join_selected_values);
                    $.ajax({
                        url: '{{ route('modulesetting.destroy') }}',
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ids: idsArr
                        },
                        success: function(data) {

                            if (data['success'] == true) {
                                $("#checkalluser").prop('checked', false);
                                table.ajax.reload();

                            } else {
                                alert('Something went wrong, Please try again!!');
                            }
                        },
                    });

                } else {
                    $(".values").prop('checked', false);
                    $("#checkalluser").prop('checked', false);
                }

            }


        });

        $("#cross").on('click', function() {
            $(".validation").hide();
        });
    });
</script>
