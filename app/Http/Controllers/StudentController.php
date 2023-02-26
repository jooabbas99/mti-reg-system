<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use App\Models\Semester;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Transcript;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerCourses(Request $request)
    {
        $student = Student::where('user_id','=', $request->user()->id)->get()->first();
        $semester = Semester::latest()->first();
        if ($request->ajax()) {
            $data = Course::rightJoin('available_courses as av', 'av.course_id', '=', 'courses.id')
            ->where(function ($query) use ($student) {
                $query->whereNull('pre_course_id')
                ->orWhereIn('pre_course_id', function ($subquery) use ($student) {
                    $subquery->select('pc.course_id')
                    ->from('transcripts as pc')
                    ->join('students as st', 'st.id', '=', 'pc.student_id')
                    ->where('pc.student_id', $student->id)
                        ->where('st.level', '=', DB::raw('courses.level'));
                });
            })
            ->whereNotIn('courses.id', function ($subquery) use ($student) {
                $subquery->select('pc.course_id')
                ->from('transcripts as pc')
                ->where('pc.student_id', $student->id);
            })
            ->whereNotIn('courses.id', function ($subquery) use ($student) {
                $subquery->select('pc.course_id')
                ->from('transcripts as pc')
                ->where('pc.student_id', $student->id)
                ->where('pc.grade', '!=', 0);
            })
            ->where('semester', $semester->semester)
                ->where('courses.level', $student->level)
            // ->select('av.id as av_id', 'code as course_code', 'name as course_name', 'semester')
            ->get();

            // dd($data);

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
                    return $row1->code;
                })
                ->editColumn('course_name', function ($row1) {
                    return $row1->name;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->semester;
                })
                ->editColumn('level', function ($row1) {
                    return $row1->level;
                })
                ->rawColumns(['check', 'course_code', 'course_name', 'semester', 'level'])
                ->make(true);
        }
        // web request
        $data = [
            'student' => $student,
        ];
        return view('dashboard.students.available_courses', $data);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::all();
            return DataTables::of($students)
                ->addIndexColumn()
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('action', function ($data) {
                    return '
                    <div >
                        <form action="' . route('student.destroy', $data->id) . '" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <a href="' . route('student.studentProfile', $data->id) . '" class="btn btn-primary">Show Details</a>
                            
                        </form>
                    </div>
                    ';
                })
                ->editColumn('name', function ($data) {
                    return $data->firstname.' '.$data->lastname;
                })
                ->rawColumns(['action','name', 'check'])
                ->make(true);
        }
        // web request
        $data = [
            'is_student' => true,
        ];
        return view('dashboard.students.list', $data);
    }

    public function myRegistrations(Request $request)
    {
        $student = Student::where('user_id','=', $request->user()->id)->get()->first();
        $semester = Semester::latest()->first();
      
        $currentSemester = Semester::latest()->first();
        // show regular offers 
        // show irregular offers 
        $enrolled_passed_course_ids = DB::table('transcripts')
        ->where('student_id', $student->id)
        ->where('grade', '<>', '0')
        ->pluck('course_id');

        $count_not_enrolled = DB::table('courses')
        ->whereNotIn('id', $enrolled_passed_course_ids)
            ->count();
        $data = [
            'student' => $student,
            'semester' => $currentSemester,
            'enrolled_passed_course_ids' => count($enrolled_passed_course_ids),
            'count_not_enrolled' => $count_not_enrolled,
        ];
    
        return view('dashboard.students.myregistrations', $data);
    }

    public function profile(Request $request)
    {
        $data = [
            'student' => Student::where('user_id', '=', $request->user()->id)->first(),
            'user' => $request->user()

        ];
        return view('dashboard.students.form', $data);
    }
    public function studentProfile(Request $request)
    {
        $student_id = $request->id; // replace with the student ID

        $enrolled_passed_course_ids = DB::table('transcripts')
        ->where('student_id', $student_id)
        ->where('grade','<>','0')
        ->pluck('course_id');

        $count_not_enrolled = DB::table('courses')
            ->whereNotIn('id', $enrolled_passed_course_ids)
            ->count();
        $data = [
            'student' => Student::find($request->id),
            'user' => $request->user(),
            'enrolled_passed_course_ids'=>count($enrolled_passed_course_ids),
            'count_not_enrolled'=>$count_not_enrolled,
        ];
        return view('dashboard.students.profile', $data);
    }

    public function register(Request $request)
    {
        // courses ids than needed to open
        $semester = Semester::latest()->first();
        $courses_ids = $request->courses_ids;
        $student = Student::where('user_id', '=', $request->user()->id)->get()->first();
        // create a new available courses
        if (!isset($courses_ids)) {
            // 
            // messing values
            return;
        }
        // check if course exists
        foreach ($courses_ids as $course_id) {
            // check if 
            if (!Enrollment::where('available_course_id', $course_id)->where('student_id', $student->id)->exists()) {
                $av_course = Enrollment::create(['available_course_id' => $course_id, 'student_id' => $student->id,'status'=>'P','semester_id'=> $semester->id]);
            }
        }
        $arr = ["success" => true, "message" => 'Selected courses was Registered successfully.'];
        return $arr;
    }


    public function getCurrentRegistrations(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::find($request->id);
            $currentSemester = Semester::latest()->first();
            $data = Enrollment::where('student_id', '=', $student->id)->where('semester_id', '=', $currentSemester->id);
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
                    return $row1->Student->firstname . ' ' . $row1->Student->lastname;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->Semester->name;
                })
                ->editColumn('level', function ($row1) {
                    return $row1->Student->level;
                })
                ->rawColumns(['check', 'course_code', 'course_name', 'student_name', 'semester', 'level'])
                ->make(true);
        }
    }
    public function getFailedRegistrations(Request $request)
    {
        if ($request->ajax()) {
            $student = Student::find($request->id);
            $data = Transcript::select('transcripts.*', DB::raw('COUNT(DISTINCT t2.student_id) as grade_zero_count'))
            ->where('transcripts.student_id', '=', $student->id)
                ->where('transcripts.grade', '=', '0')
                ->leftJoin('transcripts as t2', function ($join) {
                    $join->on('transcripts.course_id', '=', 't2.course_id')
                    ->where('t2.grade', '=', '0')
                    ->where('t2.student_id', '!=', DB::raw('transcripts.student_id'))
                    ;
                })
                ->whereNotExists(function ($query) use ($student) {
                    $query->select(DB::raw(1))
                        ->from('transcripts as t3')
                        ->whereRaw('t3.student_id = transcripts.student_id')
                        ->whereRaw('t3.course_id = transcripts.course_id')
                        ->where('t3.grade', '!=', '0');
                })
                ->groupBy('transcripts.id')
                ->get();

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
                    return $row1->Student->firstname . ' ' . $row1->Student->lastname;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->semester;
                })
                
                ->rawColumns(['check', 'course_code', 'course_name', 'student_name', 'semester'])
                ->make(true);
        }
    }
    public function getAllRegistrations(Request $request)
    {
        if ($request->ajax()) {
            // select * from courses as nc where (nc.id in (select pc.course_id from transcripts pc where pc.student_id = 1 and pc.grade = 0 ));
            $student = Student::find($request->id);
            $data = Transcript::where('student_id','=' ,$student->id);
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
                    return $row1->Student->firstname . ' ' . $row1->Student->lastname;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->semester;
                })
                
                ->rawColumns(['check', 'course_code', 'course_name', 'student_name', 'semester'])
                ->make(true);
        }
    }

    public function getSemesterCourses(Request $request)
    {
        if ($request->ajax()) {
            // select * from courses as nc where (nc.id in (select pc.course_id from transcripts pc where pc.student_id = 1 and pc.grade = 0 ));
            $student = Student::find($request->id);
            $currentSemester = Semester::latest()->first();

            $data = Course::where('level', '=', $student->level)->where('semester','=', $currentSemester->semester)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                
                ->editColumn('course_code', function ($row1) {
                    return $row1->code;
                })
                ->editColumn('course_name', function ($row1) {
                    return $row1->name;
                })
                ->editColumn('semester', function ($row1) {
                    return $row1->semester;
                })
                ->rawColumns(['course_code', 'course_name', 'semester'])
                ->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
