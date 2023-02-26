@include('dashboard.layouts.header')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-semesters"></i>
                </div>
                <div class="page-title">
                    <h3>Semesters</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" class="btn btn-primary btn-sm btn-create"
                        href="{{ route('supervisor.semestersIndex') }}"><i class="icon-eye"></i> View</a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->

<div class="main-content">
    <form id="newSemester" action="{{ isset($semester->id) ? route('supervisor.updateNewSemester', $semester->id) : route('supervisor.storeNewSemester') }}"
        method="POST" enctype="multipart/form-data">
        @csrf

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
        <input type="hidden" id="id" name="id" value="{{ isset($semester) ? $semester->id : '' }}">
        <div class="card">
            <div class="card-body">
                <div class="row gutters" >
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7col-12">
                        <div class="form-group">
                            <label for="name">Semester Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Semester Name *"
                                value="{{ isset($semester->name) ? $semester->name : '' }}" />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="start_at">start date</label>
                            <input type="date" class="form-control" id="start_at" name="start_at"
                                placeholder="start date"
                                value="{{ isset($semester->start_at) ? $semester->start_at : '' }}" />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="end_at">end date</label>
                            <input type="date" class="form-control" id="end_at" name="end_at"
                                placeholder="end date"
                                value="{{ isset($semester->end_at) ? $semester->end_at : '' }}" />
                        </div>
                    </div>
                    
                </div>
                        <div id="formmodel">
            		</div>
                <div class="actions clearfix">
                    <button type="submit" class="btn btn-primary"><span class="icon-save2"></span>
                        @if ($result ?? ''['method'] == 'add')
                            Save
                        @else
                            Update
                        @endif
                    </button>
                </div>
            </div></div>
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
        // $(".validation").hide();
        $("#cross").on('click', function() {
            $(".validation").hide();
        });
    });
</script>
