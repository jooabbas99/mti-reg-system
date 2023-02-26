<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ModuleSettingController;
// use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table("users")
                ->select('users.*')
                ->where('users.role', '0')
                ->orderBy('id', 'DESC')->get();
                // $data = User::orderBy('id', 'DESC')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('mergeColumn', function ($row3) {
                    if($row3->image == ''){
                        $image = '<span class="avatar avatar-img list-img">
                        <img src="'.asset('assets/images/user.png').'" /></span>';
                    }
                    else
                    {
                        $image = '<span class="avatar avatar-img list-img">
                        <img src="'.asset('assets/images/' . $row3->image).'"></span>';
                    }
                    return $image . ' '. $row3->firstname .' '. $row3->lastname;
                })
                ->editColumn('check', function ($row1) {
                    $btn1 = '<div class="custom-control custom-checkbox">
                        <input class="custom-control-input values" name="userselect[]"
                        value="' . $row1->id . '" type="checkbox" id="' . $row1->id . '">
                        <label class="custom-control-label" for="' . $row1->id . '"></label>
                        </div>';

                    return $btn1;
                })
                ->editColumn('status', function ($row2) {
                    if ($row2->status == '1') {
                        $class = 'btn-success';
                        $url = url('admin/user/status/' . $row2->id . '/0');
                        $name = 'Active';
                    } else {
                        $class = 'btn-warning';
                        $url = url('admin/user/status/' . $row2->id . '/1');
                        $name = 'Inactive';
                    }
                    $btn = '<div class="col-md-2 row">
                   <a data-toggle="tooltip" href="' . $url . '" class="btn ' . $class . ' btn-sm btn-edit"><i class="icon-tick""></i>' . $name . '</a>
                    </div>';

                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    if ($row->login_type == '1') {

                        $html = '<a data-toggle="tooltip" href="' . route('user.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit ml-3"><i
                       class="icon-pencil"></i>Edit</a>';
                    } else {
                        $html = '<span class="ml-2"></span>';
                    }

                    $btn = '<div class=" row">
                    ' . $html . '<a data-toggle="tooltip" href="' . route('user.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-edit ml-1"><i
                    class="icon-trash2"></i>Delete</a>
                    </div>';

                    return $btn;
                })
                ->rawColumns(['check', 'action', 'status', 'mergeColumn'])
                ->make(true);
        }
        $users = User::orderBy('id', 'DESC')->get();
        return view('dashboard.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['result'] = ['method' => 'add'];
        return view('dashboard.users.form', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('asdf');
         $input = $request->all();
        // dd($input);
        $user ='user';
        $module=ModuleSettingController::getattributeStore($user);
        $validation_fields = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:4',
            'image' => 'required',
        ];
        
        if(!empty($module['record'])){
                foreach ($module['record'] as $key => $value) {
                    # code...
                    $validate_value = json_decode($value['validate_attr'],true);
                    $r = $validate_value['rules'];
                    // implode(',', (array) $a);
                    $value['validate_attr'] = str_replace(']','',str_replace('[',':',implode("|",(array) $r)));
                    $value['validate_attr'] = str_replace('_length','',$value['validate_attr']);
                    if($value['type'] == "checkbox(multiple select)"){
                        $validation_fields[$value['slug']] =  $value['validate_attr'];
                    }else{
                        $validation_fields[$value['slug']] =  $value['validate_attr'];
                    }

                }
            } 
            $validator = Validator::make($request->all(), $validation_fields);
        if ($validator->fails()) {
            return redirect()->route('user.create')->withErrors($validator)->withInput();
            // return response()->json(['error' => $validator->errors()->all()]);
        } else {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = public_path('assets/images');
                $name = time() . rand(1, 99999) . "." . $image->getClientOriginalExtension();
                $image->move($path, $name);
                // dd($path);
            }
            
            $users = new User();
            $users->firstname = $request->firstname;
            $users->lastname = $request->lastname;
            $users->username = $request->username;
            $users->birthdate = $request->birthdate;
            $users->image = isset($name) ? $name : "";
            $users->image_flag = $request->image_flag;
            $users->role = '0';
            $users->email = $request->email;
            $users->login_type = '1';
            $users->status = '1';
            $users->password = bcrypt($request->password);
            if(!empty($module['record'])){
                foreach ($module['record'] as $key => $value) {
                    $d[$value['slug']] = $input[$value['slug']];
                    unset($input[$value['slug']]);
                 }
                $users->module = json_encode($d);
            }
            $users->save();

            return redirect()->route('user.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
        }
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
        // dd($id);
        $user = User::find($id);
        $data['result'] = ['method' => 'edit'];
        return view('dashboard.users.form', $data, compact('user'));
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
        // dd($request->all());
        $input = $request->all();
        $user ='user';
        $module=ModuleSettingController::getattributeStore($user);
        $validation_fields = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users,username,' . $id . ',id',
            'email' => 'required|unique:users,email,' . $id . ',id',
            'password' => 'required|confirmed|min:4',
        ];
        if(!empty($module['record'])){
                foreach ($module['record'] as $key => $value) {
                    # code...
                    $validate_value = json_decode($value['validate_attr'],true);
                    $r = $validate_value['rules'];
                    // implode(',', (array) $a);
                    $value['validate_attr'] = str_replace(']','',str_replace('[',':',implode("|",(array) $r)));
                    $value['validate_attr'] = str_replace('_length','',$value['validate_attr']);
                    if($value['type'] == "checkbox(multiple select)"){
                        $validation_fields[$value['slug']] =  $value['validate_attr'];
                    }else{
                        $validation_fields[$value['slug']] =  $value['validate_attr'];
                    }

                }
            } 
             $validator = Validator::make($request->all(), $validation_fields);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return response()->json(['error' => $validator->errors()->all()]);
        } else {

            $users = User::where('id', $id)->first();
            $users->firstname = $request->firstname;
            $users->lastname = $request->lastname;
            $users->username = $request->username;
            $users->birthdate = $request->birthdate;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = public_path('assets/images');
                $name = time() . rand(1, 99999) . "." . $image->getClientOriginalExtension();
                $image->move($path, $name);
                $users->image = $name;
                // dd($path);
            }
            $users->email = $request->email;
            $users->password = bcrypt($request->password);
            if(!empty($module['record'])){
            foreach ($module['record'] as $key => $value) {
                $d[$value['slug']] = $input[$value['slug']];
                unset($input[$value['slug']]);
             }
            $users->module = json_encode($d);
            }
            $users->save();

            return redirect()->route('user.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect()->route('user.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
    }

    public function status($id, $status)
    {
        // dd($id, $status);
        $user = User::where('id', $id)->update(array('status' => $status));
        // dd($user);
        return redirect()->route('user.index');
    }

    public function deleteAllUser(Request $request)
    {
        $ids = $request->ids;
        $user = User::whereIn('id', $ids)->delete();
        if ($user) {
            $arr = ["success" => true, "message" => 'Selected User Delete successfully.'];
            return $arr;
        }
    }
}
