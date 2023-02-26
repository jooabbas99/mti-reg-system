<?php

namespace App\Http\Controllers;

use App\Models\AvailableCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Semester;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;




class SupervisorMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create()
    {
        // create a new semesters Offers
        $data['result'] = ['method' => 'add'];
        return view('dashboard.supervisor.form_new_semester', $data);
    }
    public function createNewSemester()
    {
        // create a new semesters Offers
        $data['result'] = ['method' => 'add'];
        return view('dashboard.supervisor.form_new_semester', $data);
    }
    public function storeNewSemester(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:semesters,name',
        ]);
        if ($validator->fails()) {
            return redirect()->route('dashboard.supervisor.form_new_semester')->withErrors($validator)->withInput();
        } 
        $semester = new Semester();
        $semester->name = $request->name;
        $semester->start_at = $request->start_at ?? null;
        $semester->end_at = $request->end_at ?? null;
        $semester->save();
        return redirect()->route('supervisor.currentSemester')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
    }

    public function currentSemester(Request $request){
        // get the current Semester
        $currentSemester = Semester::latest()->first();
        // show regular offers 
        // show irregular offers 
        $data = [
            'semester'=> $currentSemester,
        ];
        return view('dashboard.supervisor.currentSemester', $data);
    }

    public function getRecommendedCourses(Request $request)
    {
        if ($request->ajax()) {
            $semester = Semester::latest()->first();
            $data = Course::orderBy('id', 'DESC')->where('semester','=', $semester->semester)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('pre-requisite', function ($row1) {
                    if (isset($row1->Prerequisite)) {
                        return $row1->Prerequisite->code . ' ' . $row1->Prerequisite->name;
                    }
                    return 'No pre-requisites';
                })
                ->addColumn('action', function ($row) {
                    if($row->isAssigned(Semester::latest()->first()->id)){
                        $btn = '<div class="col-md-8 row p-2">
                        <div class="btn btn-success btn-sm btn-edit">
                            <i class="icon-check_box"></i>
                            <span class="">Opened</span>
                        </div>
                        </div>';
                        return $btn;
                    }
                    $btn = '<div class="col-md-8 row p-2">
                        <div class="btn btn-info btn-sm btn-edit">
                            <i class="icon-check_box"></i>
                            <span class="">Available</span>
                        </div>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['check', 'pre-requisite', 'action'])
                ->make(true);
        }
        $currentSemester = Semester::latest()->first();
        // show regular offers 
        // show irregular offers 
        $data = [
            'semester' => $currentSemester,
        ];
        return view('dashboard.supervisor.currentSemester', $data);
    }
    public function getRecommendedCoursesIrregular(Request $request)
    {
        if ($request->ajax()) {
            
            $data = DB::table('courses as nc')
                ->join('transcripts as pc', 'nc.id','=', 'pc.course_id')
                ->leftJoin('courses as c','c.id','=', 'nc.pre_course_id')
                ->where('pc.grade','=','0')
                ->selectRaw('nc.id, nc.name,nc.code,nc.level,nc.semester, count(pc.grade) as zero_grades , c.name as pre_requisites')
                ->groupByRaw('nc.id, nc.name')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('pre-requisite', function ($row1) {
                    if (isset($row1->pre_requisites)) {
                        return $row1->pre_requisites ;
                    }
                    return 'No pre-requisites';
                })
                
                ->rawColumns(['check', 'pre-requisite'])
                ->make(true);
        }
        $currentSemester = Semester::latest()->first();
        // show regular offers 
        // show irregular offers 
        $data = [
            'semester' => $currentSemester,
        ];
        return view('dashboard.supervisor.currentSemesterIrregular', $data);
    }
    public function getAllCourses(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('pre-requisite', function ($row1) {
                    if(isset($row1->Prerequisite)){
                        return $row1->Prerequisite->code .' '.$row1->Prerequisite->name;
                    }
                    return 'No pre-requisites';
                })

                ->addColumn('action', function ($row) {
                    $btn = '<div class="col-md-8 row p-2">
                    <a data-toggle="tooltip" href="" class="btn btn-success btn-sm btn-preview">
                    <i class="icon-eye2"></i>Preview</a>
                    <a data-toggle="tooltip" href="" class="btn btn-primary btn-sm btn-edit ml-1">
                    <i class="icon-pencil"></i>Edit</a>
                    </div>';

                    return $btn;
                })
                ->rawColumns(['check','pre-requisite','action'])
                ->make(true);
        }
    }

    public function getRegistrations(Request $request)
    {
        $currentSemester = Semester::latest()->first();
        if ($request->ajax()) {
            $data = Enrollment::where('semester_id', $currentSemester->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';
                    return $btn1;
                })
                ->editColumn('course_code', function ($row1) {
                    return $row1->Course->code;
                })
                ->editColumn('course_name', function ($row1) {
                    return $row1->Course->name;
                })
                ->editColumn('student_name', function ($row1) {
                    return $row1->Student->firstname. ' '.$row1->Student->lastname;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->Semester->name;
                })
                ->editColumn('level', function ($row1) {
                    return $row1->Student->level;
                })
                ->rawColumns(['check','course_code','course_name','student_name','semester','level'])
                ->make(true);
        }
        $data = [
            'currentSemester'=>$currentSemester,
        ];
        return view('dashboard.supervisor.registrations', $data);
    }


    public function openCourses(Request $request){
        // courses ids than needed to open
        $courses_ids = $request->courses_ids;
        $semester_id =  $request->semester_id;

        // create a new available courses
        if( !isset($courses_ids) || !isset($courses_ids)){
            // 
            // messing values
            return;
        }

        // check if course exists
        foreach ( $courses_ids as $course_id ){
            // check if 
            if(! AvailableCourse::where('course_id' , $course_id)->where('semester_id' , $semester_id)->exists() ){
                $av_course = AvailableCourse::create(['course_id' => $course_id, 'semester_id' => $semester_id]);
            }
        }
        $arr = ["success" => true, "message" => 'Selected courses was opened successfully.'];
        return $arr;        
    }
    public function getAllOpenedCourses(Request $request)
    {
        $semester = Semester::latest()->first();
        if ($request->ajax()) {
            $data = AvailableCourse::where('semester_id', $semester->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('course_code', function ($row1) {
                    return $row1->Course->code;
                })
                ->editColumn('course_name', function ($row1) {
                    return $row1->Course->name;
                })
                ->editColumn('course_level', function ($row1) {
                    return $row1->Course->level;
                })
                ->editColumn('course_semester', function ($row1) {
                    return $row1->Course->semester;
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<div class="col-md-8 row p-2">
                    // <a data-toggle="tooltip" href="" class="btn btn-success btn-sm btn-preview">
                    // <i class="icon-eye2"></i>Preview</a>
                    // </div>';
                    $btn = '';

                    return $btn;
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }
     
        $data = [
            'semester' => $semester,
        ];
        return view('dashboard.supervisor.currentSemesterAvailableCourses', $data);
    }

    public function approveRegistration(Request $request)
    {
        // courses ids than needed to open
        $enrollments_ids = $request->enrollments_ids;
        // dd($enrollments_ids);
        // create a new available courses
        if (!isset($enrollments_ids)) {
            // 
            // messing values
            return;
        }

        // check if course exists
        foreach ($enrollments_ids as $enrollment_id) {
            // check if 
            if (Enrollment::find( $enrollment_id)->exists()) {
                $enrollment = Enrollment::find($enrollment_id);
                $enrollment->status = 'A';
                $enrollment->save();
            }
        }
        $arr = ["success" => true, "message" => 'Selected Enrollments was Approved.'];
        return $arr;
    }
    public function cancelRegistration(Request $request)
    {
        // courses ids than needed to open
        $enrollments_ids = $request->enrollments_ids;
        // dd($enrollments_ids);
        // create a new available courses
        if (!isset($enrollments_ids)) {
            // 
            // messing values
            return;
        }

        // check if course exists
        foreach ($enrollments_ids as $enrollment_id) {
            // check if 
            if (Enrollment::find( $enrollment_id)->exists()) {
                $enrollment = Enrollment::find($enrollment_id);
                $enrollment->status = 'C';
                $enrollment->save();
            }
        }
        $arr = ["success" => true, "message" => 'Selected Enrollments was Approved.'];
        return $arr;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
