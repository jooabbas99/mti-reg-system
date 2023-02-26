<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModuleSetting;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreModuleSettingRequest;
use App\Http\Requests\UpdateModuleSettingRequest;
use Validator;
use Auth;
use App\Models\User;
define ("ATTRIBUTE", serialize (array("text(short field)","radio(select one)","email","select(dropdown)","checkbox(multiple select)","number","url","textarea(long field)")));
define ("VALIDATION", serialize (array("required","min_length","max_length")));
class ModuleSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ModuleSetting::orderBy('id', 'DESC')->get();
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
                ->addColumn('action', function ($row) {
                    $btn = '<div class="col-md-8 row">
                    <a data-toggle="tooltip" href="' . route('modulesetting.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit ml-1"><i class="icon-pencil"></i>Edit</a>
                    </div>';

                    return $btn;
                })
                ->rawColumns(['check', 'action'])
                ->make(true);
        }
        return view('dashboard.module_setting.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attribute = unserialize (ATTRIBUTE);
        $validate_attr = unserialize (VALIDATION);
        return view('dashboard.module_setting.form',compact('attribute','validate_attr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModuleSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = unserialize (ATTRIBUTE);
        $validate_attr = unserialize (VALIDATION);
        $input = $request->all();
        $validation_fields = [
            'name' => 'required|unique:module_settings',
            'type' => 'required',
            'validate' => 'required'
        ];
        $validator = Validator::make($request->all(), $validation_fields);
        if ($validator->fails()) {
            return redirect()->route('modulesetting.create')->withErrors($validator)->withInput();
        } else {
            // exit;

            if((in_array("max_length",$input['validate']) && in_array("min_length",$input['validate'])) && $input['maximum'] < $input['minimum']) {

                    return redirect()->route('modulesetting.create')->withErrors(array('Maximum nuber should be greter than minimum number'))->withInput();
            }else{
                foreach ($input['validate'] as $key => $value) {
                   
                    if($value == "max_length"){
                        $input['validate'][$key] =  'max_length['.$input['maximum'].']';
                    }elseif($value == "min_length"){
                       $input['validate'][$key] =  'min_length['.$input['minimum'].']';
                    }
                }
       
                $input['slug'] = url_title($input['name'], '_', true);
                $input['page'] = 'user';
                if(empty($input['attributevalue'])){
                    $input['data'] = NULL;
                }else{
                    
                    $data = array('attributevalue'=>explode(",", $input['attributevalue']));
                    $input['data'] = json_encode($data);
                }
                unset($input['attributevalue']);
                unset($input['maximum']);
                unset($input['minimum']);
                unset($input['_token']);
                $input['validate_attr'] = json_encode(array('rules'=> $input['validate']));
                unset($input['validate']);
                $response = ModuleSetting::create($input);
                if($response->id){
                    return redirect()->route('modulesetting.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
                }
                else{
                    return redirect()->route('modulesetting.index')->with('error', '<i class="icon-tick"></i><strong>Failed to create!</strong>, Failed');
                }

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModuleSetting  $moduleSetting
     * @return \Illuminate\Http\Response
     */
    public function show(ModuleSetting $moduleSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModuleSetting  $moduleSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = unserialize (ATTRIBUTE);
        $validate_attr = unserialize (VALIDATION);
        $user = ModuleSetting::where('id',$id)->first()->toArray();
        $user['validate_attr'] = json_decode($user['validate_attr'],true);
        if($user['type'] == 'radio(select one)' || $user['type'] == 'checkbox(multiple select)' || $user['type'] == 'select(dropdown)'){
            if(!empty($user['data'])){
            $user['data'] = json_decode($user['data'],true);
            $user['data'] = implode(",", $user['data']['attributevalue']);
        }
        }
        $k = $user['validate_attr']['rules'];
        foreach ($k as $key => $value) {
            $myArray[] = explode('[', $value);

            $a[] = $myArray[$key]['0'];
            if(in_array("max_length", $myArray[$key])){
                $number = explode(']', $myArray[$key]['1']);
                $user['maximum'] = $number['0'];
            }
            if(in_array("min_length", $myArray[$key])){
                $number = explode(']', $myArray[$key]['1']);
                $user['minimum'] = $number['0'];
            }
        }
        $user['validate_attr']['rules'] = $a;
        return view('dashboard.module_setting.form', compact('user','attribute','validate_attr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModuleSettingRequest  $request
     * @param  \App\Models\ModuleSetting  $moduleSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $attribute = unserialize (ATTRIBUTE);
        $validate_attr = unserialize (VALIDATION);
        $input = $request->all();
        $validation_fields = [
            'name' => 'required',
            'type' => 'required',
            'validate' => 'required'
        ];
        $validator = Validator::make($request->all(), $validation_fields);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if((in_array("max_length",$input['validate']) && in_array("min_length",$input['validate'])) && $input['maximum'] < $input['minimum']) {
              return redirect()->back()->withErrors(array('Maximum nuber should be greter than minimum number'))->withInput();

            }else{
                foreach ($input['validate'] as $key => $value) {
                   
                    if($value == "max_length"){
                        $input['validate'][$key] =  'max_length['.$input['maximum'].']';
                    }elseif($value == "min_length"){
                       $input['validate'][$key] =  'min_length['.$input['minimum'].']';
                    }
                }
                $input['slug'] = url_title($input['name'], '_', true);
                $input['page'] = 'user';
                if(!empty($input['attributevalue'])){
          
                    $data = array('attributevalue'=>explode(",",$input['attributevalue']));
                
                    $input['data'] = json_encode($data);
                }else{
                    unset($input['data']);
                }
                unset($input['attributevalue']);
                unset($input['maximum']);
                unset($input['minimum']);
                unset($input['_token']);
                $input['validate_attr'] = json_encode(array('rules'=> $input['validate']));
                unset($input['validate']);
                // $myArray = explode('(', $_POST['type']);
                //  $_POST['type'] = $myArray['0'];
                $response = ModuleSetting::where('id',$id)->update($input);
                if($response){
                   return redirect()->route('modulesetting.index')->with('success', '<i class="icon-tick"></i><strong>Well done!</strong>, Success');
                }
                else{
                     return redirect()->route('modulesetting.index')->with('error', '<i class="icon-tick"></i><strong>Failed to update!</strong>, Failed');
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModuleSetting  $moduleSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        $user = ModuleSetting::whereIn('id', $ids)->delete();
        if ($user) {
            $arr = ["success" => true, "message" => 'Selected Module Setting Delete successfully.'];
            return $arr;
        }
    }

    public function getattribute($user){
        $pages = ModuleSetting::where('page',$user)->get();
        if(!$pages->isEmpty()){
            $page = $pages->toArray();
            //dd($record);
            return view('dashboard.users.formmodel',compact('page'))->render();
        }
        else{
             return "false";
        }
    }

    public function editattribute($id){
        
        if($id == "user"){
            $id = Auth::user()->id;
         }
        $user='user';
        $pages = ModuleSetting::where('page',$user)->get();
        if(!$pages->isEmpty()){
            $user = User::find($id)->toArray();
            $page = $pages->toArray();
            $user['module'] = json_decode($user['module'],true);
            //dd($user);
            return view('dashboard.users.formmodel',compact('user','page'))->render();
        }else{
            return "false";
        }
        
    }
    public function getattributeStore($user){
        $page = ModuleSetting::where('page',$user)->get();
        if(!$page->isEmpty()){
            $record = $page->toArray();
            $response = ['status'=>true,'message'=>'Success','record'=>$record];
        }
        else{
              $response = ['status'=>false,'message'=>'Please enter valid email and password', 'record' => ''];
        }
        return $response;
    }
}
