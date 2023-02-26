<?php

namespace App\Http\Controllers;

// use App\Models\Cms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $users = User::count();

        return view('dashboard.dashboard', compact('users'));
    }

    public function profile()
    {
        if(Auth::user()->role == 1){
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
        }
        else{
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();
        }
        $data['result'] = ['method' => 'add'];
        return view('dashboard.profile', $data, compact('user'));
    }
    
    public function storeProfile(Request $request)
    {
        $input = $request->all();
        $id = Auth::user()->id;
        $user = 'user';
        $module = ModuleSettingController::getattributeStore($user);
        $validation_fields = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users,username,' . $id . ',id',
            'email' => 'required|unique:users,email,' . $id . ',id',
        ];
        if (!empty($module['record'])) {
            foreach ($module['record'] as $key => $value) {
                # code...
                $validate_value = json_decode($value['validate_attr'], true);
                $r = $validate_value['rules'];
                // implode(',', (array) $a);
                $value['validate_attr'] = str_replace(']', '', str_replace('[', ':', implode("|", (array) $r)));
                $value['validate_attr'] = str_replace('_length', '', $value['validate_attr']);
                if ($value['type'] == "checkbox(multiple select)") {
                    $validation_fields[$value['slug']] = $value['validate_attr'];
                } else {
                    $validation_fields[$value['slug']] = $value['validate_attr'];
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
            if (!empty($module['record'])) {
                foreach ($module['record'] as $key => $value) {
                    $d[$value['slug']] = $input[$value['slug']];
                    unset($input[$value['slug']]);
                }
                $users->module = json_encode($d);
            }
            $users->save();
            return redirect()->route('admin.profile')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
        }
    }

    public function change_password()
    {
        if (Auth::user()->role == '1') {
            return redirect()->route('dashboard');
        }
        return view('dashboard.change_password');
    }

    public function update_password(Request $request)
    {
        if (Auth::user()->role == '1') {
            return redirect()->route('dashboard');
        }
      
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $this->form_validation->set_rules($validation);
        if($this->form_validation->run() == false){
            $this->load->view('dashboard.admin/change_password',$this->data);
        }
        else{
            unset($_POST['confirm_password']);
            $_POST['current_password'] = md5($_POST['current_password']);
            $_POST['password'] = md5($_POST['password']);
            $response = $this->admin->update_password($this->session->userdata('admin_id'),$_POST);
            if($response['status']===true){
                $this->session->set_flashdata('success', $response['message']);
                redirect(base_url('admin/admin/change_password'));
            }
            else{
                $this->session->set_flashdata('error', $response['message']);
                $this->load->view('dashboard.admin/change_password',$this->data);
            }
        }
    }
}
